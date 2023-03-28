<?php
session_start();

$host = "127.0.0.1";
$port = 12345;
require_once "frameEncoder.php";
$socket = socket_create(AF_INET, SOCK_STREAM, 6);
if ($socket === false) {
    echo "Socket create error";
    die();
}
if (socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1) === false) {
    echo "Set option error";
}
if (socket_set_nonblock($socket) === false) {
    echo "Socket nonblock set error";
    die();
}

if (socket_bind($socket, $host, $port) === false) {
    echo "Socket bind error";
    die();
}
if (socket_listen($socket) === false) {
    echo "Socket listen error";
    die();
}

$connections = [];
while (true) {
    if (($client = socket_accept($socket)) !== false) {
        $request = socket_read($client, 5000);
        if ($request === false) {
            echo "Socket read error";
        }
        preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $request, $matches);
        $key = base64_encode(pack(
            'H*',
            sha1($matches[1] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
        ));
        $headers = "HTTP/1.1 101 Switching Protocols\r\n";
        $headers .= "Upgrade: websocket\r\n";
        $headers .= "Connection: Upgrade\r\n";
        $headers .= "Sec-WebSocket-Version: 13\r\n";
        $headers .= "Sec-WebSocket-Accept: $key\r\n\r\n";
        if (socket_write($client, $headers, strlen($headers)) === false) {
            echo "Headers socket write error";
        }
        array_push($connections, $client);
    }
    foreach ($connections as $key => $value) {
        $arr = [];
        if (count(glob('users/*.json')) <= 1) {
            array_push($arr, "Нет других пользователей");
        } else {
            foreach (glob('users/*.json') as $i) {
                    array_push($arr, (substr(substr($i, 0, -5), 6)));
            }
        }
        $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
        $response = frameEncode($json);
        if (socket_write($value, $response) === false) {
            unset($connections[$key]);
        }

    }
}









