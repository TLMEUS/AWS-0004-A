<?php
/**
 * This file contains the src/Root/Database.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Root
 * File Name: Database.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 07/06/2024
 */
declare(strict_types=1);

namespace Root;

use PDO;
/**
 * Class Database provides functionality for connecting to a database.
 */
readonly class Database
{

    /**
     * Class constructor.
     *
     * @param string $host The host of the database server.
     * @param string $name The name of the database.
     * @param string $user The username to authenticate with the database server.
     * @param string $pass The password to authenticate with the database server.
     *
     * @return void
     */
    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $pass
    )
    {

    }

    /**
     * Gets a connection to the database.
     *
     * @return PDO The database connection.
     */
    public function getConnection(): PDO
    {
        $dsn = "mysql:host=$this->host;dbname=$this->name;charset=utf8";
        return new PDO($dsn, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}