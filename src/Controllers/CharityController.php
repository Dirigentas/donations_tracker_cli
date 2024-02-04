<?php

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\DB\FileReader;

final class CharityController
{
    public static function Create($filename, $name, $email)
    {
        $newRecord = ['name' => $name, 'email' => $email, 'donations' => ''];

        FileReader::Create($filename, $newRecord);
    }

    public static function Update($filename, $id, $name, $email)
    {
        $newRecord = ['name' => $name, 'email' => $email];

        FileReader::Update($filename, $id, $newRecord);
    }
    
    /**
     * This method writes the provided data to a CSV file with the specified filename format.
     *
     * @param array $formattedSearchCriteria An array containing parameters for requesting flight data.
     * @param array $csvDataArray An array containing the data to be written to the CSV file.
     * @return void
     */
    public static function WriteToCsv(string $filename): void
    {
        $csvFileName = fopen('./public/charities.csv', 'w');

        fputcsv($csvFileName, [
            "id",
            "name",
            "representative_email"
        ]);

        foreach (FileReader::ReadDataFromFile($filename) as $key => $row) {
            $key = substr($key, 4);
            array_pop($row);
            array_unshift($row, $key);
            fputcsv($csvFileName, $row);
        }
        fclose($csvFileName);
    }

}