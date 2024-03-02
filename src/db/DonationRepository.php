<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli\db;

use Aras\DonationsTrackerCli\Controllers\CharityController;

class DonationRepository {
    private $donations = [];

    public function addDonation(Donation $donation) {
        $this->donations[] = $donation;
    }

    public function getAllDonations() {
        return $this->donations;
    }
}