<?php
/**
 * This file contains the src/Controller/SectionController.php file for project AWS-0003-A.
 *
 * File information:
 * Project Name: AWS-0003-A
 * Section Name: Source
 * Module Name: Controller
 * File Name: SectionController.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 07/06/2024
 *
 * @noinspection ALL
 */
declare(strict_types = 1);

namespace Controller;

use Gateway\SectionGateway;
use Root\AbstractController;

class SectionController extends AbstractController {

    public function __construct(public SectionGateway $gateway) {
    }
}