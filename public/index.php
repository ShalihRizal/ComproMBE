<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Ensure Environment Configuration Exists
|--------------------------------------------------------------------------
|
| On shared hosting deployments where .env is not uploaded directly,
| initialize the production environment configuration if missing.
|
*/
if (!file_exists(__DIR__.'/../.env')) {
    @file_put_contents(__DIR__.'/../.env', implode("\n", [
        'APP_NAME="PT Makmur Bersama Enjiniring"',
        'APP_ENV=production',
        'APP_KEY=base64:m1S0d77ZSdlfhA/kjyR64iCLtTynxN+zA4mv09Xn+Ac=',
        'APP_DEBUG=false',
        'APP_URL=https://makben.co.id',
        '',
        'APP_LOCALE=en',
        'APP_FALLBACK_LOCALE=en',
        '',
        'LOG_CHANNEL=stack',
        'LOG_STACK=single',
        'LOG_LEVEL=error',
        '',
        'DB_CONNECTION=mysql',
        'DB_HOST=127.0.0.1',
        'DB_PORT=3306',
        'DB_DATABASE=u203934978_mbe',
        'DB_USERNAME=u203934978_mbe',
        'DB_PASSWORD=6f6f8f8dd726cd3e5a38A1!',
        '',
        'SESSION_DRIVER=file',
        'SESSION_LIFETIME=120',
        'SESSION_ENCRYPT=false',
        '',
        'CACHE_STORE=file',
        'CACHE_DRIVER=file',
        'QUEUE_CONNECTION=sync',
        'FILESYSTEM_DISK=local',
        '',
    ]));
}

// Clean up stale compiled view cache and deploy archive once
if (!file_exists(__DIR__.'/../storage/framework/views/.cleanup_done')) {
    foreach (glob(__DIR__.'/../storage/framework/views/*.php') as $f) {
        @unlink($f);
    }
    foreach (glob(__DIR__.'/../*.zip') as $z) {
        @unlink($z);
    }
    @touch(__DIR__.'/../storage/framework/views/.cleanup_done');
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
