<?php
require_once __DIR__ . '/wp-config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    echo "DB connection error: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

$sql = "SELECT option_name, option_value FROM ${table_prefix}options WHERE option_name IN ('siteurl','home')";
if ($res = $mysqli->query($sql)) {
    echo "<pre>";
    while ($row = $res->fetch_assoc()) {
        echo htmlspecialchars($row['option_name']) . " => " . htmlspecialchars($row['option_value']) . "\n";
    }
    echo "</pre>";
    $res->free();
} else {
    echo "Query error: " . $mysqli->error;
}

$mysqli->close();
?>