<?php

/**
 * This file is the entry point for the Web Scraper application.
 *
 * PHP version 8.2.12
 *
 * @author  Aras
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Aras\DonationsTrackerCli\App;

/**
 * Starts the solution.
 */
App::Router($argc, $argv);