<?php
function logMessage($message) {
    if (DEBUG_MODE) {
        file_put_contents('bot.log', date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
    }
}

function sendTelegramRequest($method, $params = []) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

function processMessage($message) {
    logMessage("Processing message: " . print_r($message, true));
    
    $chat_id = $message['chat']['id'];
    $text = $message['text'] ?? '';
    
    if (strpos($text, "/start") === 0) {
        $response = "Hello! I'm a simple Telegram bot. Send me a message and I'll echo it back.";
        sendTelegramRequest('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $response
        ]);
    } elseif (!empty($text)) {
        $response = "You said: " . $text;
        sendTelegramRequest('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $response
        ]);
    }
}
