<?php
require_once 'config.php';
require_once 'functions.php';

// Get the input data from Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    logMessage("Invalid update received");
    exit;
}

// Handle the update
if (isset($update["message"])) {
    processMessage($update["message"]);
}

logMessage("Update processed: " . print_r($update, true));
