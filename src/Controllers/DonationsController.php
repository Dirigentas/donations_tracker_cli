<?php

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\DB\FileReader;
use Aras\DonationsTrackerCli\Validation;

final class DonationsController
{
    /**
     * Create a new donation record.
     *
     * @param string $filename The name of the file to store the data
     * @param string $donorName The name of the donor
     * @param float $amount The donation amount
     * @param string $charityId The ID of the charity receiving the donation
     * @return void
     */
    public static function create(string $filename, string $donorName, $amount, $charityid): void
    {
        if (!Validation::donationAmount($amount)) {
            echo "Field 'amount' must be a number." . PHP_EOL;
            exit(1);
        }

        $donation = ['donor_name' => $donorName, 'amount' => $amount, 'date' => date(date('Y-m-d H:i'))];

        FileReader::partialUpdate($filename, $charityid, $donation, 'donations', 'id: ' . FileReader::getId('./src/DB/donations'));
    }
}