<?php
/**
 * Fallback implementations of helper functions that used to live in the old
 * (external, MySQL-era) config/func.php + config/global.php. Those files are
 * outside this workspace and weren't available during the Postgres migration,
 * so these are safe, best-effort stand-ins guarded by function_exists() —
 * if the real legacy helpers are already loaded elsewhere, these no-op.
 */

if (!function_exists('err_log')) {
    function err_log($msg, $file = null)
    {
        error_log(($file ? '[' . $file . '] ' : '') . (is_scalar($msg) ? $msg : print_r($msg, true)));
    }
}

if (!function_exists('url_cooker')) {
    function url_cooker($str)
    {
        // Underscore is preserved (not collapsed to '-'): res_template.php encodes
        // "addr_aptnum" in property URLs with '_' and splits on it when parsing back.
        $slug = strtolower(trim((string)$str));
        $slug = preg_replace('/[^a-z0-9_]+/', '-', $slug);
        return trim($slug, '-');
    }
}

if (!function_exists('to_url')) {
    function to_url($str)
    {
        return url_cooker($str);
    }
}

if (!function_exists('url2mysql')) {
    function url2mysql($str)
    {
        return str_replace('-', '%', (string)$str);
    }
}

if (!function_exists('getPropertyType')) {
    function getPropertyType($type_own_srch)
    {
        $t = strtolower((string)$type_own_srch);
        if (strpos($t, 'condo') !== false || strpos($t, 'apartment') !== false || strpos($t, 'co-op') !== false || strpos($t, 'co-ownership') !== false) {
            return 'condo';
        }
        if (strpos($t, 'town') !== false) {
            return 'townhouse';
        }
        if (strpos($t, 'semi') !== false) {
            return 'semi';
        }
        return 'house';
    }
}

// Local image mirroring is gone; kept only so old call sites don't fatal.
if (!function_exists('get_path_form_mln')) {
    function get_path_form_mln($ml_num)
    {
        return '';
    }
}

if (!function_exists('hDays')) {
    function hDays($today, $updated)
    {
        try {
            $a = new DateTime($today);
            $b = new DateTime($updated ?: $today);
            return $a->diff($b);
        } catch (Exception $e) {
            return new DateInterval('P0D');
        }
    }
}

if (!function_exists('verifyFormToken')) {
    function verifyFormToken($name)
    {
        return isset($_POST[$name]) && $_POST[$name] !== '';
    }
}

if (!function_exists('generateFormToken')) {
    function generateFormToken($name)
    {
        $token = bin2hex(random_bytes(16));
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[$name] = $token;
        }
        return $token;
    }
}

if (!function_exists('is_decimal')) {
    function is_decimal($value)
    {
        return is_numeric($value);
    }
}

// Used by index.php's '/{municipality}-home/{community}/{street}' route to center the map/page.
if (!function_exists('get_st_latlon')) {
    function get_st_latlon($municipality, $community, $street)
    {
        global $mysqli, $RES;
        $stmt = $mysqli->prepare("select lat, lon, municipality, community, st, st_sfx, st_dir from $RES where municipality ilike ? and community ilike ? and st ilike ? limit 1");
        $stmt->bind_param('sss', $municipality, $community, $street);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if (!$row) {
            return array();
        }
        return array($row['lat'], $row['lon'], $row['municipality'], $row['community'], $row['st'], $row['st_sfx'], $row['st_dir']);
    }
}

// Used by index.php's '/{municipality}-real-estate/{community}' route to center the map/page.
if (!function_exists('get_community_latlon')) {
    function get_community_latlon($municipality, $community)
    {
        global $mysqli, $RES;
        $stmt = $mysqli->prepare("select lat, lon from $RES where municipality ilike ? and community ilike ? limit 1");
        $stmt->bind_param('ss', $municipality, $community);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? array($row['lat'], $row['lon']) : array();
    }
}

if (!function_exists('bd_nice_number')) {
    function bd_nice_number($value)
    {
        return '$' . number_format((float)$value, 0);
    }
}

// Groups nearby markers by actual proximity (the original proximity-clustering
// algorithm isn't available post-migration). $px is the clustering radius in
// screen pixels at the given Google Maps $zoom level. Uses greedy nearest-to-
// existing-cluster matching rather than a fixed grid, so two markers just a
// few meters apart don't get split into separate pins by an arbitrary grid line.
if (!function_exists('cluster')) {
    function cluster($markers, $px, $zoom)
    {
        $zoom = (int)$zoom;
        $px = (float)$px;
        if ($zoom <= 0 || $px <= 0) {
            return array_map(function ($m) { return array($m); }, $markers);
        }
        // Degrees of longitude per screen pixel at this zoom (Web Mercator tile math).
        $degPerPixel = 360 / (256 * pow(2, $zoom));
        $radius = $px * $degPerPixel;
        if ($radius <= 0) {
            return array_map(function ($m) { return array($m); }, $markers);
        }
        $clusters = array();
        foreach ($markers as $m) {
            if (!isset($m['lat']) || !isset($m['lon']) || $m['lat'] === '' || $m['lon'] === '') {
                $clusters[] = array($m);
                continue;
            }
            $placed = false;
            foreach ($clusters as &$c) {
                if (abs($m['lat'] - $c[0]['lat']) <= $radius && abs($m['lon'] - $c[0]['lon']) <= $radius) {
                    $c[] = $m;
                    $placed = true;
                    break;
                }
            }
            unset($c);
            if (!$placed) {
                $clusters[] = array($m);
            }
        }
        return $clusters;
    }
}

// money_format() was removed in PHP 8.0; this covers the '%.0n' usage
// (locale currency, no decimals) found throughout the templates.
if (!function_exists('money_format')) {
    function money_format($format, $number)
    {
        return '$' . number_format((float)$number, 0);
    }
}

if (!function_exists('get_municipality_latlon')) {
function get_municipality_latlon($municipality){
    global $mysqli;
    $query = "select lat,lon,municipality from URL_MAPPER where municipality_url ilike ? and record_type='municipality';"  ;
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param("s",$municipality);
        $stmt->execute();
        $result = $stmt->get_result();
       if ($row = $result->fetch_assoc()) {
           $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);

           extract($escapedListing);
           if( !(empty($lon) || empty( $lat)) ){
                          $stmt->close();
                           return array($lat,$lon,$municipality);
           } else {
                           return array();
           }
       }
    }
 }
}
if (!function_exists('get_community_latlon')) {
 function get_community_latlon($municipality,$community ){
    global $mysqli;
    $query = "select lat,lon,municipality,community from URL_MAPPER where municipality_url = ? and community_url = ? and record_type='community';  "  ;
    err_log($query.":".$municipality.":".$community);
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param("ss",$municipality,$community);
        $stmt->execute();
        $result = $stmt->get_result();
       if ($row = $result->fetch_assoc()) {
           $escapedListing= array_map(array($mysqli, 'real_escape_string'), $row);
           extract($escapedListing);
           err_log($query.":>".$escapedListing."<:".$lat.": ".$lon);
           if( !(empty($lon) || empty( $lat)) ){
                          $stmt->close();
                           return array($lat,$lon,$municipality,$community);
           } else {
                           return array();
           }
       }
    }
  }
 }


if (!function_exists('get_st_latlon')) {
 function get_st_latlon($municipality,$community,$st){
    global $mysqli;
    $query = "select lat,lon,st,st_sfx,st_dir,community,municipality from URL_MAPPER where municipality_url ilike ? and community_url = ? and st_url = ? and record_type='st';  "  ;
     err_log($query);
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param("sss",$municipality,$community,$st);
        $stmt->execute();
        $result = $stmt->get_result();
       if ($row = $result->fetch_assoc()) {
           $escapedListing= array_map(array($mysqli, 'real_escape_string'), $row);

           extract($escapedListing);
           if( !(empty($lon) || empty( $lat)) ){
                          $stmt->close();
                           return array($lat,$lon,$municipality,$community,$st,$st_sfx,$st_dir);
           } else {
                           return array();
           }
       }
    }
 }

}
