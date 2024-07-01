<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['SESSION_EMAIL'])) {
    http_response_code(401); // Unauthorized
    exit(json_encode(['message' => 'Unauthorized']));
}

// Include your database connection file (e.g., config.php)
include 'config.php';

// Get the item ID from the POST data
$itemId = isset($_POST['item_id']) ? $_POST['item_id'] : null;

// Check if item ID is provided
if ($itemId) {
    // Update the status of the item to 'Found' in the registered_items table
    $updateSql = "UPDATE registered_items SET is_missing='Found' WHERE item_id='$itemId'";
    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        // Delete the item data from the reported_missing table
        $deleteSql = "DELETE FROM reported_missing WHERE item_id='$itemId'";
        $deleteResult = mysqli_query($conn, $deleteSql);

        if ($deleteResult) {
            http_response_code(200); // Success
            exit(json_encode(['message' => 'Item marked as found']));
        } else {
            http_response_code(500); // Internal Server Error
            exit(json_encode(['message' => 'Failed to delete entry from reported_missing table']));
        }
    } else {
        http_response_code(500); // Internal Server Error
        exit(json_encode(['message' => 'Failed to update item status']));
    }
} else {
    http_response_code(400); // Bad Request
    exit(json_encode(['message' => 'Invalid request']));
}
?>
