<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "<h1>Debug Telegram Integration</h1>";
// 1. Check PHP Version
echo "<h2>1. PHP Environment</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "cURL Enabled: " . (function_exists('curl_init') ? 'YES' : 'NO') . "<br>";
// 2. Include Utility
echo "<h2>2. Loading Utility</h2>";
if (file_exists('telegram_utils.php')) {
    require_once 'telegram_utils.php';
    echo "telegram_utils.php loaded.<br>";
} else {
    die("❌ telegram_utils.php NOT FOUND in " . __DIR__);
}
// 3. Test Connection
echo "<h2>3. Sending Test Message</h2>";
$testMsg = "DEBUG: Manual test from " . $_SERVER['HTTP_HOST'];
echo "Attempting to send: '$testMsg'<br>";
// We assume existing sendTelegramLog function uses the hardcoded credentials in the file
// But let's copy the logic here to see RAW output if the function fails silently
$apiToken = "8505689913:AAHXd45oS3BAAnqLxx9PUMIy_Ln7E6mEp-8";
$chatId = "5162627169";
$url = "https://api.telegram.org/bot$apiToken/sendMessage";
$data = ['chat_id' => $chatId, 'text' => $testMsg];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Disable SSL verification for debugging purposes only to rule out cert issues
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "<h3>Result:</h3>";
if ($curlError) {
    echo "❌ cURL Error: " . $curlError . "<br>";
} else {
    echo "HTTP Status Code: " . $httpCode . "<br>";
    echo "API Response: <pre>" . htmlspecialchars($response) . "</pre><br>";
    
    $json = json_decode($response, true);
    if ($json && $json['ok']) {
        echo "✅ SUCCESS! Check your Telegram.";
    } else {
        echo "❌ API Error: " . ($json['description'] ?? 'Unknown');
    }
}
?>
