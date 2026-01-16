<?php
/**
 * Sends a message to a Telegram Bot.
 * 
 * @param string $message The message text to send. Support HTML formatting.
 * @param string|null $chatId Optional. The Chat ID to send to. Defaults to the configured ID.
 * @return array The response from the Telegram API.
 */
function sendTelegramLog($message, $chatId = null) {
    // CONFIGURATION
    // -------------------------------------------------------
    // PASTE YOUR API TOKEN HERE
    $apiToken = "8505689913:AAHXd45oS3BAAnqLxx9PUMIy_Ln7E6mEp-8"; 
    
    // PASTE YOUR CHAT ID HERE (Required)
    // See instructions if you don't have it: https://api.telegram.org/bot<TOKEN>/getUpdates
    $defaultChatId = "5162627169"; 
    // -------------------------------------------------------
    // Use the passed chat ID or fallback to default
    $targetChatId = $chatId ? $chatId : $defaultChatId;
    if ($targetChatId === "YOUR_CHAT_ID_HERE") {
        error_log("Telegram Logger Error: Chat ID not set in telegram_utils.php");
        return ['ok' => false, 'description' => 'Chat ID not configured'];
    }
    $url = "https://api.telegram.org/bot$apiToken/sendMessage";
    
    $data = [
        'chat_id' => $targetChatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
        error_log("Telegram Request Error: " . $error);
        return ['ok' => false, 'description' => $error];
    }
    
    return json_decode($response, true);
}
?>