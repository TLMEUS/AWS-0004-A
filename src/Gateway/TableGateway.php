<?php
/**
 * This file contains the src/Gateway/TableGateway.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Gateway
 * File Name: TableGateway.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 07/06/2024
 *
 * @noinspection ALL
 */
declare(strict_types = 1);

namespace Gateway;

use Root\AbstractGateway;
use PDO;

class TableGateway extends AbstractGateway {

    public string $tableName = 'tbl_tables';

    public array $colNames = [
        'colName',
        'colSection',
        'colSeats'
    ];

    public function getAll(): array
    {
        $stmt = $this->conn->prepare("SELECT MAX(colSection) FROM $this->tableName");
        $stmt->execute();
        $count = $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
        $max[0] = $count[0]['MAX(colSection)'];
        for ($i = 0; $i <= $max[0]; $i++) {
            $stmt2 = $this->conn->prepare("SELECT colName, colSeats FROM $this->tableName WHERE `colSection` = :colSection");
            $stmt2->bindParam(param: ":colSection", var: $i);
            $stmt2->execute();
            $return[$i] = $stmt2->fetchAll(mode: PDO::FETCH_ASSOC);
        }
        return $return;
    }

}