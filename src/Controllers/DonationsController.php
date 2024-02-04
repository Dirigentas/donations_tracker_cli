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
    public static function Create(string $filename, string $donorName, $amount, $charityid): void
    {
        if (!Validation::DonationAmount($amount)) {
            echo "Field 'amount' must be a number.\n";
            exit(1);
        }

        $donation = ['donor_name' => $donorName, 'amount' => $amount, 'date' => date(date('Y-m-d H:i'))];

        FileReader::PartialUpdate($filename, $charityid, $donation, 'donations', 'id: ' . FileReader::GetId('./src/DB/donations'));
    }
}