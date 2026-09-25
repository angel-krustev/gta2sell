<?php
require_once '../config/config.php';

function renderProxiedListingImages(string $resourceRecordKey, string $bearerToken): void
{
    $baseUrl = "https://query.ampre.ca/odata/Media";
    $escapedKey = str_replace("'", "''", $resourceRecordKey);

    $queryParams = [
        '$filter=' . rawurlencode("ResourceRecordKey eq '{$escapedKey}'"),
        '$select=' . rawurlencode('MediaURL,Order,ImageSizeDescription,MediaStatus,MediaType'),
        '$orderby=' . rawurlencode('Order asc')
    ];

    $ch = curl_init($baseUrl . '?' . implode('&', $queryParams));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => [
            "Authorization: Bearer {$bearerToken}",
            "Accept: application/json"
        ]
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($res, true);
    $records = $data['value'] ?? [];

    // Filter to count valid Large JPEGs
    $validPhotos = array_filter($records, function ($r) {
        return in_array(strtolower($r['ImageSizeDescription'] ?? ''), ['medium'], true)
            && strcasecmp($r['MediaStatus'] ?? '', 'Active') === 0
            && strcasecmp($r['MediaType'] ?? '', 'image/jpeg') === 0;
    });

    $count = count($validPhotos);

    // Render HTML tags pointing to your local proxy URL
    for ($i = 1; $i <= $count; $i++) {
        // Option A: Matching the /rs/600x400/r/retsimages/... pattern
        $srcA = "/rs/600x400/r/retsimages/1/image_{$resourceRecordKey}_{$i}.jpg";

        // Option B: Simple relative format: image_{resourceKey}_{i}.jpg
        // $srcB = "image_{$resourceRecordKey}_{$i}.jpg";

        echo '<figure class="uk-overlay">' . PHP_EOL;
        echo '  <img width="60%" src="' . htmlspecialchars($srcA) . '" onerror="imgError(this);" alt="">' . PHP_EOL;
        echo '</figure>' . PHP_EOL;
    }
}
