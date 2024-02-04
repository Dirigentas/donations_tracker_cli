<?php

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\DB\FileReader;
use Aras\DonationsTrackerCli\Validation;

final class DonationsController
{
    public static function Create($filename, $donorName, $amount, $charityid)
    {
        if (!Validation::DonationAmount($amount)) {
            echo "Field 'amount' must be a number.\n";
            exit(1);
        }

        $donation = ['donor_name' => $donorName, 'amount' => $amount, 'date' => date(date('Y-m-d H:i'))];

        FileReader::PartialUpdate($filename, $charityid, $donation, 'donations', 'id: ' . FileReader::GetId('./src/DB/donations'));
    }
}