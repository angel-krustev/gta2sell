<?php
// Configuration
require_once '../config/config.php';

define('CACHE_DIR', __DIR__ . '/cache/retsimages');

$resourceRecordKey = $_GET['resourceRecordKey'] ?? null;
$imgIndex = isset($_GET['img']) ? (int)$_GET['img'] : 1;

if (!$resourceRecordKey || $imgIndex < 1) {
    servePlaceholder();
    exit;
}

// Ensure the local cache directory exists
if (!is_dir(CACHE_DIR)) {
    mkdir(CACHE_DIR, 0755, true);
}

$cacheFilePath = CACHE_DIR . "/image_{$resourceRecordKey}_{$imgIndex}.jpg";

// 1. If image is cached locally, serve it directly with browser cache headers
if (file_exists($cacheFilePath) && filesize($cacheFilePath) > 0) {
    serveFile($cacheFilePath);
    exit;
}

// 2. Not cached: fetch listing media records from the AMPRE OData API
try {
    $mediaUrl = fetchMediaUrlFromApi($resourceRecordKey, $imgIndex, $BEARER_TOKEN);
    if (!$mediaUrl) {
        servePlaceholder();
        exit;
    }

    // 3. Download the binary stream from AMPRE CDN and save to cache
    downloadAndSaveImage($mediaUrl, $cacheFilePath);

    // 4. Stream the file to the browser
    serveFile($cacheFilePath);

} catch (Exception $e) {
    servePlaceholder();
    exit;
}

/**
 * Queries OData for this ResourceRecordKey, applies identical filtering as image_helper.php,
 * and picks the Nth image ($imgIndex).
 */
function fetchMediaUrlFromApi(string $key, int $index, string $token): ?string
{
    $baseUrl = "https://query.ampre.ca/odata/Media";
    $escapedKey = str_replace("'", "''", $key);

    $queryParams = [
        '$filter='  . rawurlencode("ResourceRecordKey eq '{$escapedKey}'"),
        '$select='  . rawurlencode('MediaKey,ResourceRecordKey,MediaURL,Order,ImageSizeDescription,MediaStatus,MediaType'),
        '$orderby=' . rawurlencode('Order asc'),
        '$top=500' // Retrieve all records in one call to match image_helper.php
    ];

    $ch = curl_init($baseUrl . '?' . implode('&', $queryParams));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Bearer {$token}",
            "Accept: application/json"
        ]
    ]);

    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$res) {
        return null;
    }

    $data = json_decode($res, true);
    if (empty($data['value']) || !is_array($data['value'])) {
        return null;
    }

    // IDENTICAL FILTER: Only Active, JPEG, and /rs:fit:3840:3840/
    $validRecords = array_values(array_filter($data['value'], function ($r) {
        $status = $r['MediaStatus'] ?? '';
        $type   = $r['MediaType'] ?? '';
        $url    = $r['MediaURL'] ?? '';

        $isActive = strcasecmp($status, 'Active') === 0;
        $isJpeg   = strcasecmp($type, 'image/jpeg') === 0;
        $isFit3840 = strpos($url, '/rs:fit:3840:3840/') !== false;

        return $isActive && $isJpeg && $isFit3840 && !empty($url);
    }));

    // IDENTICAL DEDUPLICATION: Group by base photo identity
    $deduped = [];
    foreach ($validRecords as $r) {
        $mediaKey = $r['MediaKey'] ?? '';
        $baseKey  = (strpos($mediaKey, '-') !== false)
            ? substr($mediaKey, 0, strrpos($mediaKey, '-'))
            : $mediaKey;

        $uniqueKey = ($r['ResourceRecordKey'] ?? '') . '_' . ($r['Order'] ?? 0) . '_' . $baseKey;

        if (!isset($deduped[$uniqueKey])) {
            $deduped[$uniqueKey] = $r;
        }
    }

    $finalRecords = array_values($deduped);
    usort($finalRecords, fn($a, $b) => ($a['Order'] ?? 0) <=> ($b['Order'] ?? 0));

    // Convert 1-based index from URL ($imgIndex = 1) to 0-based array index
    $targetIndex = $index - 1;
    return $finalRecords[$targetIndex]['MediaURL'] ?? null;
}

/**
 * Downloads binary image and writes it to disk.
 */
function downloadAndSaveImage(string $sourceUrl, string $destPath): void
{
    $ch = curl_init($sourceUrl);
    $fp = fopen($destPath, 'wb');
    curl_setopt_array($ch, [
        CURLOPT_FILE           => $fp,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);

    if ($code !== 200) {
        @unlink($destPath);
        throw new Exception("Source CDN returned status {$code}");
    }
}

/**
 * Sends appropriate binary and caching headers, then flushes file.
 */
function serveFile(string $filePath): void
{
    header('Content-Type: image/jpeg');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: public, max-age=86400'); // 24 hours browser cache
    readfile($filePath);
}

/**
 * Serves an inline SVG placeholder when an image is missing or cannot be retrieved.
 */
function servePlaceholder(): void
{
    header('Content-Type: image/svg+xml');
    header('Cache-Control: public, max-age=3600');
    echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 400" width="600" height="400">'
       . '<rect width="600" height="400" fill="#F5F5F5"/>'
       . '<g opacity="0.5" fill="#D8D8D8">'
       . '<path d="M228 143v114h144V143H228zm132 101H240v-88h120v88z"/>'
       . '<polygon points="246 234 271 208 280 212 310 181 321 195 326 192 354 234"/>'
       . '<circle cx="275" cy="178" r="10"/>'
       . '</g></svg>';
}
