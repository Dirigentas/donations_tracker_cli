<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\DB\FileReader;
use Aras\DonationsTrackerCli\Validation;

final class CharityController
{
    /**
     * Create a new charity record.
     *
     * @param string $filename The name of the file to store the data
     * @param string $name The name of the charity
     * @param string $email The email address of the charity representative
     * @return void
     */
    public static function create(string $filename, string $name, string $email): void
    {
        if (!Validation::emailValidation($email)) {
            echo "Incorrect email format." . PHP_EOL;
            exit(1);
        }

        $newRecord = ['name' => $name, 'email' => $email];

        FileReader::create($filename, $newRecord);
    }

    /**
     * Update an existing charity record.
     *
     * @param string $filename The name of the file containing the data
     * @param string $id The ID of the charity to update
     * @param string $name The new name for the charity
     * @param string $email The new email address for the charity representative
     * @return void
     */
    public static function update(string $filename, string $id, string $name, string $email): void
    {
        $newRecord = ['name' => $name, 'email' => $email];

        FileReader::update($filename, $id, $newRecord);
    }
    
    /**
     * Write charity data to a CSV file.
     *
     * @param string $filename The name of the file containing the charity data
     * @return void
     */
    public static function writeToCsv(string $filename): void
    {
        $csvFileName = fopen('./public/charities.csv', 'w');

        fputcsv($csvFileName, [
            "id",
            "name",
            "representative_email"
        ]);

        foreach (FileReader::readDataFromFile($filename) as $key => $row) {
            $key = substr($key, 4);
            array_pop($row);
            array_unshift($row, $key);
            fputcsv($csvFileName, $row);
        }
        fclose($csvFileName);
    }

}