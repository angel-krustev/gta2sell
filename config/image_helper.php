<?php
/**
 * Photo URLs used to be built from a local mirrored copy of the images
 * (timthumb resizing /wp/web/retsimages/...). That local mirror no longer
 * exists after the IDX/Postgres migration, so we point at the original
 * feed image instead.
 *
 * idx_media (the RESO media table) is currently empty on the feed mirror,
 * so there is no confirmed real media CDN URL yet. MEDIA_BASE_URL below is
 * a PLACEHOLDER — replace it with the actual IDX/RESO media base URL (or
 * switch get_property_image_url() to read media_url from idx_media once
 * that table is populated) as soon as it's known.
 */

if (!defined('MEDIA_BASE_URL')) {
    // TODO: replace with the real feed media base URL.
    define('MEDIA_BASE_URL', 'https://media.idxfeed.example.com/photos');
}

// Inline placeholder SVG shown when no photo is available / image 404s.
$emp_image = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjAwcHgiIGhlaWdodD0iNDAwcHgiIHZpZXdCb3g9IjAgMCA2MDAgNDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2MDAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIi8+DQo8ZyBvcGFjaXR5PSIwLjciPg0KCTxwYXRoIGZpbGw9IiNEOEQ4RDgiIGQ9Ik0yMjguMTg0LDE0My41djExM2gxNDMuNjMydi0xMTNIMjI4LjE4NHogTTM2MC4yNDQsMjQ0LjI0N0gyNDAuNDM3di04OC40OTRoMTE5LjgwOEwzNjAuMjQ0LDI0NC4yNDcNCgkJTDM2MC4yNDQsMjQ0LjI0N3oiLz4NCgk8cG9seWdvbiBmaWxsPSIjRDhEOEQ4IiBwb2ludHM9IjI0Ni44ODEsMjM0LjcxNyAyNzEuNTcyLDIwOC43NjQgMjgwLjgyNCwyMTIuNzY4IDMxMC4wMTYsMTgxLjY4OCAzMjEuNTA1LDE5NS40MzQgDQoJCTMyNi42ODksMTkyLjMwMyAzNTQuNzQ2LDIzNC43MTcgCSIvPg0KCTxjaXJjbGUgZmlsbD0iI0Q4RDhEOCIgY3g9IjI3NS40MDUiIGN5PSIxNzguMjU3IiByPSIxMC43ODciLz4NCjwvZz4NCjwvc3ZnPg0K';

/**
 * Build a photo URL for a listing. Prefers media_listing_key (the feed's
 * media identifier); falls back to the MLS number while that column is
 * unpopulated. Width/height are appended as query params the same way the
 * old timthumb links (?w=..&h=..) were used, in case the feed CDN honours them.
 */
function get_property_image_url($media_listing_key, $ml_num, $index = 1, $width = 600, $height = 400)
{
    $key = !empty($media_listing_key) ? $media_listing_key : $ml_num;
    if (empty($key)) {
        return null;
    }
    return MEDIA_BASE_URL . '/' . rawurlencode($key) . '/' . intval($index) . '.jpg?w=' . intval($width) . '&h=' . intval($height);
}

/**
 * Same as get_property_image_url() but returns the empty-listing placeholder
 * when nimages is 0 (kept for parity with the old $nimages == 0 checks).
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
