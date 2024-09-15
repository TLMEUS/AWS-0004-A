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

class TableGateway extends AbstractGateway {

    public string $tableName = 'tbl_tables';

    public array $colNames = [
        'colName',
        'colSection',
        'colSeats'
    ];

}