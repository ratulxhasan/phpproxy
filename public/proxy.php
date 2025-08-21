<?php
$url = urldecode($_GET['url'] ?? '');
if (!$url) {
    http_response_code(400);
    echo "Missing 'url' parameter.";
    exit;
}

$headers = [
    "Referer: https://test-streams.mux.dev",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL verification
$data = curl_exec($ch);
curl_close($ch);

// Check for Akamai error page
if (strpos($data, 'errors.edgesuite.net') !== false) {
    http_response_code(403);
    echo "Stream provider blocked the request.";
    exit;
}

header("Content-Type: application/octet-stream");
echo $data;
?>
