<?php
/**
 * This file contains the Source/Root/Dotenv.php class for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Root
 * File Name: Dotenv.php
 * File Author: Troy L Marker
 * Language: PHP 8.2
 *
 * File Copyright: 07/06/2024
 */
declare(strict_types=1);


namespace Root;
/**
 * Dotenv class for loading environment variables from a file.
 */
class Dotenv
{

    /**
     * Loads environment variables from a file.
     *
     * @param string $path The path of the file to load.
     *
     * @return void
     */
    public function load(string $path): void
    {
        $lines = file(filename: $path, flags: FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            list($name, $value) = explode(separator: "=", string: $line, limit: 2);
            $_ENV[$name] = $value;
        }
    }
}