<?php
$url = urldecode($_GET['url'] ?? '');
if (!$url) {
    http_response_code(400);
    echo "Missing 'url' parameter.";
    exit;
}

$headers = [
    "Referer: https://yourdomain.com",
    "User-Agent: Mozilla/5.0"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data = curl_exec($ch);
curl_close($ch);

header("Content-Type: application/octet-stream");
echo $data;
?>
