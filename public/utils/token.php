<?php
function refreshTokenIfNeeded($url) {
  if (strpos($url, 'token=') === false) return $url;

  preg_match('/token=([^&]+)/', $url, $matches);
  $oldToken = $matches[1];

  // Simulate token refresh (replace with real logic)
  $newToken = bin2hex(random_bytes(8));

  return str_replace("token=$oldToken", "token=$newToken", $url);
}
