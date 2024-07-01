<?php
// Add CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Include your database connection file
include 'config.php';

// Define the formatDate function
function formatDate($timestamp) {
    return date('Y-m-d H:i:s', strtotime($timestamp));
}

// Query to select the latest chat messages
$query = "SELECT * FROM `tbl_chat` ORDER BY id DESC";
$run = $conn->query($query);

// Prepare the chat messages HTML
$chatHtml = '';
while ($row = $run->fetch_array()) {
    $chatHtml .= '<div class="chating_data">';
    $chatHtml .= '<span id="name">' . $row['name'] . '</span><br>';
    $chatHtml .= '<span id="message">' . $row['message'] . '</span>';
    $chatHtml .= '<span id="date">' . formatDate($row['date']) . '</span>';
    $chatHtml .= '</div>';
}

// Output the chat messages HTML
echo $chatHtml;