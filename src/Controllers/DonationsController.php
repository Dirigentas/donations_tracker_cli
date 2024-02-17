<?php

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\db\JsonReader;
use Aras\DonationsTrackerCli\Validation;

class DonationsController
{
    private $fileName = 'charities';
    private $editableField = 'donations';

    /**
     * Create a new donation record.
     *
     * @param string $filename The name of the file to store the data
     * @param string $donorName The name of the donor
     * @param float $amount The donation amount
     * @param string $charityId The ID of the charity receiving the donation
     * @return void
     */
    public function create(string $donorName, string $amount, int $charityId): void
    {
        if (!Validation::donationAmount($amount)) {
            echo "Field 'amount' must be a number." . PHP_EOL;
            exit(1);
        }

        $donation = ['donor_name' => $donorName, 'amount' => $amount, 'date' => date(date('Y-m-d H:i'))];
        
        (new JsonReader($this->fileName))->partialUpdate($charityId, $donation, $this->editableField, 'id: ' . (new JsonReader($this->editableField))->getId());
    }
}