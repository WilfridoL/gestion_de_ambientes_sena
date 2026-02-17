<?php

function view($archivo)
{
    require __DIR__ . "/src/views/$archivo.php";
}

$request = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$basePath = urldecode(dirname($_SERVER['SCRIPT_NAME']));

if ($basePath !== '/' && strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
}
$request = rtrim($request, '/');

if ($request === '') {
    $request = '/';
}

switch ($request) {

    case '/':
    case '/dashboard':
        view('home');
        break;

    case '/solicitudes':
        view('solicitudes');
        break;

    case '/mis-solicitudes':
        view('mis_solicitudes');
        break;

    case '/configuracion':
        view('configuracion');
        break;

    case '/ambientes':
        view('ambiente');
        break;

    case '/instructores':
        view('instructor');
        break;

    default:
        http_response_code(404);
        view('404');
        break;
}