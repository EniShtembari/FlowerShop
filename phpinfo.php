<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Curl is working!';
}

curl_close($ch);
?>
