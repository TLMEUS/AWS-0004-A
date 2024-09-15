<?php
/**
 * This file contains the src/Gateway/SectionGateway.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Gateway
 * File Name: SectionGateway.php
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

class SectionGateway extends AbstractGateway {

    public string $tableName = 'tbl_sections';

    public array $colNames = [
        'colName'
    ];
}