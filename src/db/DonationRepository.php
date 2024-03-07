<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli\db;

use Aras\DonationsTrackerCli\Donation;

class DonationRepository
{
    private $donations = [];
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = __DIR__ . "/" . $filePath . '.json';
        
        if (file_exists($this->filePath)) {
            $data = file_get_contents($this->filePath);
            $donationsData = json_decode($data, true);
            if ($donationsData) {
                foreach ($donationsData as $donationData) {
                    $this->donations[] = new Donation($donationData['id'], $donationData['donorName'], $donationData['amount'], $donationData['charityId'], $donationData['dateTime']);
                }
            }
        }
    }

    public function addDonation(Donation $donation)
    {
        $this->donations[] = $donation;
    }

    public function getAllDonations()
    {
        return $this->donations;
    }

    public function deleteDonation($charityId): void
    {
        foreach ($this->donations as $key => $donation) {
            if ($donation->getCharityId() == $charityId) {
                unset($this->donations[$key]);
            }
        }
    }

    public function __destruct()
    {
        $donationsData = [];
        foreach ($this->donations as $donation) {
            $donationsData[] = [
                'id' => $donation->getId(),
                'donorName' => $donation->getDonorName(),
                'amount' => $donation->getAmount(),
                'charityId' => $donation->getCharityId(),
                'dateTime' => $donation->getDateTime()
            ];
        }
        file_put_contents($this->filePath, json_encode($donationsData, JSON_PRETTY_PRINT));
    }
}
