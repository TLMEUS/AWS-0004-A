<?php
/**
 * This file contains the src/Root/AbstractGateway.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Root
 * File Name: AbstractGateway.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 07/06/2024
 */
declare(strict_types=1);

namespace Root;

use PDO;

/**
 * Class AbstractGateway
 *
 * The AbstractGateway class provides a base class for gateway classes to interact with the database.
 */
abstract class AbstractGateway {

    public PDO $conn;

    public string $tableName = "";

    public array $colNames = [];

    /**
     * Constructor for the class that initializes the connection to the database.
     *
     * @param Database $database The instance of the Database class used to establish the connection.
     * @return void
     */
    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }

    /**
     * Retrieves all records from the table.
     *
     * @return array Returns an array containing all the records from the table.
     * The records are fetched as associative arrays using the PDO::FETCH_ASSOC mode.
     */
    public function getAll(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->tableName");
        $stmt->execute();
        return $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a single record from the table based on the given ID.
     *
     * @param string $id The ID of the record to retrieve.
     * @return array Returns an array containing the retrieved record.
     * If the record is found, it is fetched as an associative array using the PDO::FETCH_ASSOC mode.
     * If the record is not found, an error response is sent with a 404 status code and an array containing
     * the error code and message is returned.
     *
     * @noinspection PhpUnused
     */
    public function getSingle(string $id): array
    {
        $stmt = $this->conn->prepare(query: "SELECT * FROM $this->tableName WHERE colId = :id");
        $stmt->bindParam(param: ":id", var: $id);
        $stmt->execute();
        $return = $stmt->fetch(mode: PDO::FETCH_ASSOC);
        if ($return === false) {
            http_response_code(response_code: 404);
            $retval = [
                'code' => 404,
                'message' => 'Record not found'
            ];
        } else {
            $retval = $return;
        }
        return $retval;
    }

    /**
     * Creates a new record in the table.
     *
     * @param array $data An associative array containing the data to be inserted.
     * The keys of the array should correspond to the column names in the table, and the values should be the data to be inserted.
     *
     * @return array Returns an array containing all the records from the table after the new record has been inserted.
     * The records are fetched as associative arrays using the PDO::FETCH_ASSOC mode.
     *
     * @noinspection PhpUnused
     */
    public function create(array $data): array
    {
        $fields = [];
        $sql = 'INSERT INTO ' . $this->tableName . ' (' . implode(', ', $this->colNames) . ') VALUES (:' . implode(', :', $this->colNames) . ')';
        $stmt = $this->conn->prepare($sql);
        foreach ($this->colNames as $colName) {
            $fields[$colName] = [$data[$colName], PDO::PARAM_STR];
        }
        foreach ($fields as $name => $values) {
            $stmt->bindValue(param: ":$name", value: $values[0], type: $values[1]);
        }
        $stmt->execute();
        return $this->getAll();
    }

    /**
     * Updates a record in the table with the given ID using the provided data.
     *
     * @param string $id The ID of the record to update.
     * @param array $data An associative array representing the updated values for each column.
     *                    The keys of the array should match the column names in the table.
     *                    The values should be the new values to set for each column.
     * @return array Returns an array containing all the records from the table after the update.
     *               The records are fetched as associative arrays using the PDO::FETCH_ASSOC mode.
     *
     * @noinspection PhpUnused
     */
    public function update(string $id, array $data): array
    {
        $line = "";
        $fields = [];
        foreach ($this->colNames as $colName) {
            $line .= "$colName = :$colName, ";
        }
        $line = substr($line, offset: 0, length: -2);
        $sql = "UPDATE $this->tableName SET $line WHERE colId = :id";
        $stmt = $this->conn->prepare(query: $sql);
        $stmt->bindParam(param: ":id", var: $id);
        foreach ($this->colNames as $colName) {
            $fields[$colName] = [$data[$colName], PDO::PARAM_STR];
        }
        foreach ($fields as $name => $values) {
            $stmt->bindValue(param: ":$name", value: $values[0], type: $values[1]);
        }
        $stmt->execute();
        return $this->getAll();
    }

    /**
     * Deletes a record from the table based on provided ID.
     *
     * @param int $id The ID of the record to be deleted.
     *
     * @return array Returns an array containing all the records from the table after deletion.
     * The records are fetched as associative arrays using the PDO::FETCH_ASSOC mode.
     *
     * @noinspection PhpUnused
     */
    public function delete(int $id): array
    {
        $stmt = $this->conn->prepare(query: "DELETE FROM $this->tableName WHERE colId = :id");
        $stmt->bindParam(param: ":id", var: $id);
        $stmt->execute();
        return $this->getAll();
    }
}