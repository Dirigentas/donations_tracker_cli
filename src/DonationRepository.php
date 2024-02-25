<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

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