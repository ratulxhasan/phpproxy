<?php
$url = urldecode($_GET['url'] ?? '');
if (!$url) {
    http_response_code(400);
    echo "Missing 'url' parameter.";
    exit;
}

// Spoof headers to bypass CDN filters
$headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/115.0.0.0 Safari/537.36",
    "Referer: https://www.zee5.com",
    "Origin: https://www.zee5.com",
    "Accept: */*",
    "Connection: keep-alive"
];

// Use cURL for better control
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
$data = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

// Handle Akamai block or cURL failure
if ($data === false || strpos($data, 'errors.edgesuite.net') !== false) {
    http_response_code(403);
    echo "Stream provider blocked the request or cURL failed: $curlError";
    exit;
}

// Serve the stream
header("Content-Type: application/vnd.apple.mpegurl");
echo $data;
?>
