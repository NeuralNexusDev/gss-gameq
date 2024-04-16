<?php
namespace Neuralnexus\GssGameq;

use GameQ\GameQ;

require 'vendor/autoload.php';

header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod !== 'GET') {
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$uri = explode('/', $uri);
$endpoint = $uri[0];

if ($endpoint === 'GssGameq.php') {
    try {
        $game = $uri[1];
        $host = $_GET['host'];
        $port = $_GET['port'];

        $GameQ = new GameQ();

        $GameQ->addServers([
            [
                'type' => $game,
                'host' => $host . ':' . $port,
            ]
        ]);

        $results = $GameQ->process();

        header("HTTP/1.1 200 OK");
        echo json_encode($results);
        exit();

    } catch (\Throwable $th) {
        header("HTTP/1.1 500 Internal Server Error");
        echo $th;
        exit();
    }

} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
