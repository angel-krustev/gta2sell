<?php
require_once("/wp/config/config.php");
require_once("/wp/config/legacy_helpers.php");
require_once("/wp/config/image_helper.php");

// Process images for a specific property from feed
function process_property_images_from_feed($ml_num) {
    global $mysqli, $RES;
    
    // First, get the property data to verify it exists
    $sql = "SELECT * FROM $RES WHERE ml_num = ? LIMIT 1";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $ml_num);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Get image URLs from the feed
            $image_urls = get_property_image_urls_from_feed($ml_num, 600, 400);
            
            // Process each image URL
            foreach ($image_urls as $img_url) {
                // Insert into IMG_QUEUE table
                $sql = "INSERT INTO IMG_QUEUE SET img=? ON DUPLICATE KEY UPDATE img=img";
                if ($stmt_insert = $mysqli->prepare($sql)) {
                    $stmt_insert->bind_param("s", $img_url);
                    $stmt_insert->execute();
                    $stmt_insert->close();
                }
            }
            
            return true;
        }
    }
    
    return false;
}

// Process images for a specific property
if (isset($_GET['ml_num'])) {
    $ml_num = $_GET['ml_num'];
    process_property_images_from_feed($ml_num);
} else {
    // Process all properties with images
    $sql = "SELECT DISTINCT ml_num FROM $RES WHERE ml_num IS NOT NULL";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            process_property_images_from_feed($row['ml_num']);
        }
    }
}

?>
