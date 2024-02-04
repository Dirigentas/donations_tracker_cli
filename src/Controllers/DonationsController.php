<?php

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\DB\FileReader;

final class DonationsController
{
    public static function Create($filename, $donorName, $amount, $charityid)
    {
        $donation = ['donor_name' => $donorName, 'amount' => $amount, 'date' => date(date('Y-m-d H:i'))];

        FileReader::PartialUpdate($filename, $charityid, $donation, 'donations', 'id: ' . FileReader::GetId('./src/DB/donations'));
    }
}