<?php
/**
 * Photo URLs used to be built from a local mirrored copy of the images
 * (timthumb resizing /wp/web/retsimages/...). That local mirror no longer
 * exists after the IDX/Postgres migration, so we point at the original
 * feed image instead.
 *
 * idx_media (the RESO media table) is currently empty on the feed mirror,
 * so there is no confirmed real media CDN URL yet.
 */
require_once("../config/config.php");

// Inline placeholder SVG shown when no photo is available / image 404s.
$emp_image = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjAwcHgiIGhlaWdodD0iNDAwcHgiIHZpZXdCb3g9IjAgMCA2MDAgNDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2MDAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIi8+DQo8ZyBvcGFjaXR5PSIwLjciPg0KCTxwYXRoIGZpbGw9IiNEOEQ4RDgiIGQ9Ik0yMjguMTg0LDE0My41djExM2gxNDMuNjMydi0xMTNIMjI4LjE4NHogTTM2MC4yNDQsMjQ0LjI0N0gyNDAuNDM3di04OC40OTRoMTE5LjgwOEwzNjAuMjQ0LDI0NC4yNDcNCgkJTDM2MC4yNDQsMjQ0LjI0N3oiLz4NCgk8cG9seWdvbiBmaWxsPSIjRDhEOEQ4IiBwb2ludHM9IjI0Ni44ODEsMjM0LjcxNyAyNzEuNTcyLDIwOC43NjQgMjgwLjgyNCwyMTIuNzY4IDMxMC4wMTYsMTgxLjY4OCAzMjEuNTA1LDE5NS40MzQgDQoJCTMyNi42ODksMTkyLjMwMyAzNTQuNzQ2LDIzNC43MTcgCSIvPg0KCTxjaXJjbGUgZmlsbD0iI0Q4RDhEOCIgY3g9IjI3NS40MDUiIGN5PSIxNzguMjU3IiByPSIxMC43ODciLz4NCjwvZz4NCjwvc3ZnPg0K';

/**
 * Build a photo URL for a listing. Prefers media_listing_key (the feed's
 * media identifier); falls back to the MLS number while that column is
 * unpopulated.
 */
function get_property_image_url($media_listing_key, $ml_num, $index = 1, $width = 600, $height = 400)
{
    $key = !empty($media_listing_key) ? $media_listing_key : $ml_num;
    if (empty($key)) {
        return null;
    }
    return '/rs/' . intval($width) . 'x' . intval($height) . '/r/retsimages/1/image_' . $ml_num . '_' . intval($index) . '.jpg';
}

/**
 * Same as get_property_image_url() but returns the empty-listing placeholder
 * when nimages is 0.
 */
function get_property_image_url_or_placeholder($nimages, $media_listing_key, $ml_num, $index = 1, $width = 600, $height = 400)
{
    global $emp_image;
    if ((int)$nimages === 0) {
        return $emp_image;
    }
    $url = get_property_image_url($media_listing_key, $ml_num, $index, $width, $height);
    return $url !== null ? $url : $emp_image;
}

/**
 * Shared filtering and deduplication logic for Ampre Media API records.
 */
function filter_ampre_media_records(array $rawItems): array
{
    // Filter strictly for active JPEGs matching the medium 3840x3840 CDN resize signature
    $valid = array_values(array_filter($rawItems, function ($r) {
        $status = $r['MediaStatus'] ?? '';
        $type   = $r['MediaType'] ?? '';
        $url    = $r['MediaURL'] ?? '';

        $isActive = strcasecmp($status, 'Active') === 0;
        $isJpeg   = strcasecmp($type, 'image/jpeg') === 0;
        $isFit3840 = strpos($url, '/rs:fit:3840:3840/') !== false;

        return $isActive && $isJpeg && $isFit3840 && !empty($url);
    }));

    // Deduplicate by base photo identity (stripping -m suffix)
    $deduped = [];
    foreach ($valid as $r) {
        $mediaKey = $r['MediaKey'] ?? '';
        $baseKey  = (strpos($mediaKey, '-') !== false)
            ? substr($mediaKey, 0, strrpos($mediaKey, '-'))
            : $mediaKey;

        $uniqueKey = ($r['ResourceRecordKey'] ?? '') . '_' . ($r['Order'] ?? 0) . '_' . $baseKey;

        if (!isset($deduped[$uniqueKey])) {
            $deduped[$uniqueKey] = $r;
        }
    }

    $final = array_values($deduped);
    usort($final, fn($a, $b) => ($a['Order'] ?? 0) <=> ($b['Order'] ?? 0));

    return $final;
}

/**
 * Fetch image records from the feed using AMPRE OData API.
 * Returns an array of Media records matching the criteria.
 */
function fetch_image_urls_from_feed($ml_num)
{
    global $BEARER_TOKEN;

    if (empty($ml_num) || empty($BEARER_TOKEN)) {
        return array();
    }

    $baseUrl = "https://query.ampre.ca/odata/Media";
    $escapedKey = str_replace("'", "''", $ml_num);

    $queryParams = [
        '$filter='  . rawurlencode("ResourceRecordKey eq '{$escapedKey}'"),
        '$select='  . rawurlencode('MediaKey,ResourceRecordKey,MediaURL,Order,ImageSizeDescription,MediaStatus,MediaType'),
        '$orderby=' . rawurlencode('Order asc'),
        '$top=500' // Ensure all photos are retrieved without pagination cutoff
    ];

    $ch = curl_init($baseUrl . '?' . implode('&', $queryParams));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Bearer {$BEARER_TOKEN}",
            "Accept: application/json"
        ]
    ]);

    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$res) {
        return array();
    }

    $data = json_decode($res, true);
    if (empty($data['value']) || !is_array($data['value'])) {
        return array();
    }

    return filter_ampre_media_records($data['value']);
}

/**
 * Get multiple image URLs from the feed for a property (up to 40 images).
 * Returns sequential 1-based URLs that map directly to image_proxy.php.
 */
function get_property_image_urls_from_feed($ml_num, $width = 600, $height = 400)
{
    $validRecords = fetch_image_urls_from_feed($ml_num);
    if (empty($validRecords)) {
        return array();
    }

    $image_urls = array();
    $max_count = min(40, count($validRecords));

    // Emit 1-based sequential links (_1, _2, _3...) matching array indexes
    for ($i = 0; $i < $max_count; $i++) {
        $imgNum = $i + 1;
        $image_urls[] = "/rs/{$width}x{$height}/r/retsimages/1/image_{$ml_num}_{$imgNum}.jpg";
    }

    return $image_urls;
}
