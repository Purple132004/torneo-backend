<?php
$ch = curl_init('http://localhost:8000/api/tournaments');
$data = json_encode(['name' => 'Test Cup', 'date' => '2026-02-01', 'location' => 'Test', 'participants' => [1,2,3,4]]);
// debug
// file_put_contents('debug_payload.txt', $data);
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
