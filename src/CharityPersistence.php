<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

use Aras\DonationsTrackerCli\db\JsonReader;
use Aras\DonationsTrackerCli\Controllers\CharityController;

class CharityPersistence
{
    /**
     * Write charity data to a CSV file.
     *
     * @param string $fileName The name of the file containing the data.
     * @return void
     */
    public function writeToCsv(string $fileName): void
    {
        $csvFileName = fopen('./public/' . $fileName . '.csv', 'w');

        fputcsv($csvFileName, [
            "id",
            "name",
            "representative_email"
        ]);

        foreach ((new JsonReader($fileName))->showAllData() as $key => $row) {
            $key = substr($key, 4);
            array_pop($row);
            array_unshift($row, $key);
            fputcsv($csvFileName, $row);
        }
        fclose($csvFileName);
    }
}