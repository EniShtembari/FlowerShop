<?php
$stream_context = stream_context_create([
    'ssl' => [
        'cafile' => 'C:\xampp\php\extras\ssl\cacert.pem',
        'verify_peer' => true,
        'verify_peer_name' => true,
    ]
]);
$socket = stream_socket_client(
    "tcp://smtp.gmail.com:587",
    $errno,
    $errstr,
    30,
    STREAM_CLIENT_CONNECT,
    $stream_context
);
if ($socket) {
    echo "OpenSSL is working properly.";
} else {
    echo "OpenSSL error: $errstr ($errno)";
}
?>
