<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

use Aras\DonationsTrackerCli\Controllers\CharityController;

class CSVImporter {
    public function importCharities($filePath) {
        $charities = [];
        if (($handle = fopen($filePath, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $charities[] = new Charity($data[0], $data[1], $data[2]);
            }
            fclose($handle);
        }
        return $charities;
    }
}