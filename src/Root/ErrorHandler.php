<?php
/**
 * This file contains the src/Root/ErrorHandler.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Root
 * File Name: ErrorHandler.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 07/06/2024
 */
declare(strict_types=1);

namespace Root;
use Throwable;

/**
 * Class ErrorHandler
 *
 * The ErrorHandler class handles exceptions and provides a standardized way of
 * returning error information as JSON response with HTTP status code 500.
 */
class ErrorHandler
{
    public static function handleException(Throwable $exception): void
    {
        http_response_code(response_code: 500);
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
    }
}