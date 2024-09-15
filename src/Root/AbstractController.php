<?php
/**
 * This file contains the src/Root/AbstractController.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Root
 * File Name: AbstractController.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 07/06/2024
 *
 * @noinspection ALL
 */
declare(strict_types = 1);

namespace Root;

abstract class AbstractController {

    /**
     * Process the incoming request based on the provided method, id, and data.
     *
     * @param string $method The HTTP method of the request.
     * @param string|null $id The ID of the resource. Null if not applicable.
     * @param array|null $data The data of the resource. Null if not applicable.
     * @return array The result of the request, which could be a resource, an error message, or an empty array.
     */
    public function processRequest(string $method, ?string $id, ?array $data): array {
        if ($id === null) {
            $result = match ($method) {
                'GET' => $this->gateway->getAll(),
                'POST' => $this->gateway->create($data),
                default => [
                    'code' => '405',
                    'message' => 'Method not allowed'
                ],
            };
        } else {
            $result = match ($method) {
                'GET' => $this->gateway->getSingle($id),
                "PATCH" => $this->gateway->update($id, $data),
                "DELETE" => $this->gateway->delete($id),
                default => [
                    'code' => '405',
                    'message' => 'Method not allowed'
                ],
            };
        }
        return $result;
    }
}