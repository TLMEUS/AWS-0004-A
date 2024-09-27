<?php
/**
 * This file contains the api/index.php file for project AWS-0004-A.
 *
 * File information:
 * Project Name: AWS-0004-A
 * Section Name: api
 * File Name: index.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 06/29/2024
 *
 */
declare(strict_types=1);

use Controller\SectionsController;
use Controller\TablesController;
use Gateway\SectionGateway;
use Gateway\TableGateway;
use Root\AbstractController;
use Root\AbstractGateway;
use Root\Database;
use Root\Dotenv;

define("ROOT_PATH", dirname(path: __DIR__));
spl_autoload_register(callback: function (string $class_name) {
    require ROOT_PATH . "/src/" . str_replace(search: "\\", replace: "/", subject: $class_name) . ".php";
});
$dotenv = new DotEnv;
$dotenv->load(path: dirname(path: ROOT_PATH) . "/RWS-0001-A/config/.env");
set_exception_handler(callback: "\\Root\\ErrorHandler::handleException");
$path = parse_url($_SERVER["REQUEST_URI"], component: PHP_URL_PATH);
$parts = explode(separator: "/", string: $path);
$resource = $parts[1];
$id       = $parts[2] ?? null;
$action   = $parts[3] ?? null;
header(header: 'Content-Type: application/json; charset=UTF-8');
$database = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
switch ($resource) {
    case 'sections':
        $gateway = new SectionGateway($database);
        $controller = new SectionsController($gateway);
        break;
    case 'tables':
        $gateway = new TableGateway($database);
        $controller = new TablesController($gateway);
        break;
    default:
        http_response_code(response_code: 404);
        echo json_encode([
            "code" => '404',
            "message" => 'Page Not Found'
        ]);
        exit;
}
try {
    $result = $controller->processRequest($_SERVER['REQUEST_METHOD'], $id, $_GET);
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(response_code: 500);
    echo json_encode([
        "code" => '500',
        "message" => 'Internal Server Error'
    ]);
}