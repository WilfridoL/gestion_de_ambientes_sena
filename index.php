<?php

function view($archivo)
{
    require "./src/views/$archivo.php";
}

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/SISTEMA%20DE%20GESTION%20DE%20AMBIENTES';

$request = str_replace($base, '', $request);
switch ($request) {
    case '/dashboard':
        view('home');
        break;
    case '/':
        view('home');
        break;
    case '/solicitudes':
        view('solicitudes');
        break;
    default:
        http_response_code(404);
        view('404');
        break;
}
