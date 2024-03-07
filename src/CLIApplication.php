<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

use Aras\DonationsTrackerCli\Charity;
use Aras\DonationsTrackerCli\db\CharityRepository;
use Aras\DonationsTrackerCli\Donation;
use Aras\DonationsTrackerCli\db\DonationRepository;

class CLIApplication {
    private $charityRepository;
    private $donationRepository;

    public function __construct() {
        $this->charityRepository = new CharityRepository('charities');
        $this->donationRepository = new DonationRepository('donations');
    }

    public function run($argv)
    {
        // Parse command-line arguments and execute corresponding actions
        if (isset($argv[1])) {
            $command = $argv[1];
            switch ($command) {
                case 'view-charities':
                    $this->viewCharities();
                    break;
                case 'add-charity':
                    if (isset($argv[2], $argv[3])) {
                        $this->addCharity($argv[2], $argv[3]);
                    } else {
                        echo "Usage: php index.php add-charity 'name' 'email'\n";
                    }
                    break;
                case 'update-charity':
                    if (isset($argv[2], $argv[3], $argv[4])) {
                        $this->updateCharity($argv[2], $argv[3], $argv[4]);
                    } else {
                        echo "Usage: php index.php update-charity 'id' 'name' 'email'\n";
                    }
                    break;    
                    case 'delete-charity':
                    if (isset($argv[2])) {
                        $this->deleteCharity($argv[2]);
                    } else {
                        echo "Usage: php index.php delete-charity 'id'\n";
                    }
                    break;
                case 'view-donations':
                    $this->viewDonations();
                    break;
                case 'add-donation':
                    if (isset($argv[2], $argv[3], $argv[4])) {
                        $this->addDonation($argv[2], $argv[3], $argv[4]);
                    } else {
                        echo "Usage: php index.php add-donation 'donor_name' 'amount' 'charity_id'\n";
                    }
                    break;
                case 'import-charities':
                    if (isset($argv[2])) {
                        $this->importCharities($argv[2]);
                    } else {
                        echo "Usage: php index.php import-charities 'file_path'\n";
                    }
                    break;
                default:
                    echo "Unknown command: $command\n";
            }
        } else {
            echo "\nphp public/index.php view-charities" . PHP_EOL .
            "php public/index.php add-charity 'Charity_Name' 'email@example.com'" . PHP_EOL .
            "php public/index.php update-charity 'charity_id' 'Charity Name' 'email@example.com'" . PHP_EOL .
            "php public/index.php delete-charity 'charity_id'" . PHP_EOL .
            "php public/index.php view-donations" . PHP_EOL .
            "php public/index.php add-donation 'Donor_Name' 'amount' 'charity_id'" . PHP_EOL .
            "php public/index.php import-charities /path/to/charities.csv" . PHP_EOL;
        }
    }

    private function viewCharities()
    {
        $charities = $this->charityRepository->getAllCharities();
        foreach ($charities as $charity) {
            echo "ID: {$charity->getId()}, Name: {$charity->getName()}, Email: {$charity->getRepresentativeEmail()}\n";
        }
    }

    private function addCharity($name, $email)
    {
        // Validation (valid email, etc.) can be added here
        $charity = new Charity(count($this->charityRepository->getAllCharities()) + 1, $name, $email);
        $this->charityRepository->addCharity($charity);
        echo "Charity added successfully.\n";
    }

    private function updateCharity($id, $name, $email)
    {
        if ($this->charityRepository->updateCharity($id, $name, $email)) {
            echo "Charity with ID $id updated successfully.\n";
        } else {
            echo "Charity with ID $id not found.\n";
        }
    }

    private function deleteCharity($id)
    {
        if ($this->charityRepository->deleteCharity($id)) {
            $this->donationRepository->deleteDonation($id);

            echo "Charity with ID $id and all affiliated donations deleted successfully.\n";
        } else {
            echo "Charity with ID $id not found.\n";
        }
    }

    private function viewDonations()
    {
        $donations = $this->donationRepository->getAllDonations();
        foreach ($donations as $donation) {
            echo "ID: {$donation->getId()}, Donor name: {$donation->getDonorName()}, Amount: {$donation->getAmount()}, Charity ID: {$donation->getCharityId()}\n";
        }
    }

    private function addDonation($donorName, $amount, $charityId)
    {
        // Validation (valid donation amount, etc.) can be added here
        $donation = new Donation(
            count($this->donationRepository->getAllDonations()) + 1,
            $donorName,
            $amount,
            $charityId
        );
        $this->donationRepository->addDonation($donation);
        echo "Donation added successfully.\n";
    }
}