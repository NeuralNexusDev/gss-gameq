<?php
header("Content-Type: application/json");

require_once('./GameQ-3.1.0/src/GameQ/Autoloader.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];


$uri = trim($uri, '/');
$uri = explode('/', $uri);

// if ($uri[0] !== 'src') {
//     header("HTTP/1.1 404 Not Found");
//     exit();
// } else {
//     $uri = array_slice($uri, 1);
// }


if ($requestMethod !== 'GET') {
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}

$endpoint = $uri[0];

if ($endpoint === '') {
    header("HTTP/1.1 200 OK");
    echo "GameQ API";
    exit();

// Endpoint: gameq-server
} else if ($endpoint === 'gameq-server.php') {
    try {
        $game = $uri[1];
        $host = $_GET['host'];
        $port = $_GET['port'];

        $GameQ = new \GameQ\GameQ();

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

    // Internal server error
    } catch (\Throwable $th) {
        header("HTTP/1.1 500 Internal Server Error");
        echo $th;
        exit();
    }

// Endpoint not found
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

?>