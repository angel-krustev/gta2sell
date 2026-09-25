<?php
/**
 * Postgres/PostGIS connection bootstrap + mysqli-compatible shim.
 *
 * Legacy pages call $mysqli->prepare($sql)->bind_param($types,...)->execute()
 * then ->get_result()->fetch_assoc(), and $mysqli->real_escape_string()/->error.
 * These classes reproduce that surface on top of PDO pgsql so most existing
 * query code runs unchanged against Postgres. New code should prefer PDO directly.
 *
 * $RES points at idx_property_legacy, a DB view that exposes the new IDX
 * schema (idx_property) under the old short column names (ml_num, lat, lon,
 * municipality, br, bath_tot, lp_dol, dom, ...) so existing SELECT/extract()
 * based code keeps working without per-file column renames.
 */

{
    private $stmt;

    public function __construct(PDOStatement $stmt)
    {
        $this->stmt = $stmt;
    }

    public function fetch_assoc()
    {
        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    // mysqli_result::fetch_array() also returns numeric+assoc keys; callers
    // in this codebase only use the assoc keys, so assoc-only is equivalent here.
    public function fetch_array()
    {
        return $this->fetch_assoc();
    }

    public function fetch_all()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __get($name)
    {
        if ($name === 'num_rows') {
            return $this->stmt->rowCount();
        }
        return null;
    }
}

class PgStmtCompat
{
    private $pdo;
    private $stmt;
    private $sql;
    public $error = '';

    public function __construct(PDO $pdo, $sql)
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
        $this->stmt = $pdo->prepare($sql);
    }

    /**
     * Mimics mysqli_stmt::bind_param('sid...', $v1, $v2, ...).
     * Type chars: s=string, i=int, d=double, b=blob (all bound as-is; PDO/pgsql
     * does not require strict typing for text/numeric columns).
     */
    public function bind_param($types, &...$params)
    {
        for ($i = 0; $i < count($params); $i++) {
            $type = isset($types[$i]) ? $types[$i] : 's';
            $pdoType = PDO::PARAM_STR;
            if ($type === 'i') {
                $pdoType = PDO::PARAM_INT;
            } elseif ($type === 'b') {
                $pdoType = PDO::PARAM_LOB;
            }
            $this->stmt->bindValue($i + 1, $params[$i], $pdoType);
        }
        return true;
    }

    public function execute()
    {
        try {
            $ok = $this->stmt->execute();
            $this->error = '';
            return $ok;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function get_result()
    {
        return new PgStmtResultCompat($this->stmt);
    }

    public function close()
    {
        $this->stmt = null;
        return true;
    }

    public function __get($name)
    {
        if ($name === 'errno') {
            return $this->error === '' ? 0 : 1;
        }
        return null;
    }
}

class MysqliCompat
{
    public $pdo;
    public $error = '';
    public $connect_error = '';
    public $errno = 0;

    public function __construct($host, $port, $db, $user, $pass)
    {
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";
        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            $this->connect_error = $e->getMessage();
        }
    }

    public function prepare($sql)
    {
        try {
            return new PgStmtCompat($this->pdo, $sql);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->errno = 1;
            return false;
        }
    }

    public function query($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
            $this->error = '';
            return new PgStmtResultCompat($stmt);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    // Old code SQL-escapes fetched row values before extract(); PDO uses bound
    // params so this is only kept for call-site compatibility (array_map over rows).
    public function real_escape_string($value)
    {
        return is_string($value) ? addslashes($value) : $value;
    }

    // Connection stays open for the request lifetime; kept for call-site compatibility.
    public function close()
    {
        return true;
    }
}

$mysqli = new MysqliCompat(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
if ($mysqli->connect_error) {
    error_log('Postgres connection failed: ' . $mysqli->connect_error);
}

$RES = 'idx_property_legacy';
