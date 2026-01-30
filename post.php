<?php
$ch = curl_init('http://localhost:8000/api/tournaments');
$data = file_get_contents(__DIR__ . '/request.json');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
if ($res === false) {
    echo 'curl error: ' . curl_error($ch) . PHP_EOL;
} else {
    echo $res . PHP_EOL;
}
curl_close($ch);
