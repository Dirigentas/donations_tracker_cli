<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli\Controllers;

use Aras\DonationsTrackerCli\db\JsonReader;
use Aras\DonationsTrackerCli\Validation;

class CharityController
{
    private $fileName = 'charities';
    
    /**
     * Create a new charity record.
     *
     * @param string $fileName The name of the file to store the data
     * @param string $name The name of the charity
     * @param string $email The email address of the charity representative
     * @return void
     */
    public function show(int $id): void
    {
        print_r((new JsonReader($this->fileName))->showData($id));
    }

    /**
     * Create a new charity record.
     *
     * @param string $fileName The name of the file to store the data
     * @param string $name The name of the charity
     * @param string $email The email address of the charity representative
     * @return void
     */
    public function showAll(): void
    {
        print_r((new JsonReader($this->fileName))->showAllData());
    }

    /**
     * Create a new charity record.
     *
     * @param string $fileName The name of the file to store the data
     * @param string $name The name of the charity
     * @param string $email The email address of the charity representative
     * @return void
     */
    public function create(string $name, string $email): void
    {
        if (!Validation::emailValidation($email)) {
            echo "Incorrect email format." . PHP_EOL;
            exit(1);
        }

        $newRecord = ['name' => $name, 'email' => $email];

        (new JsonReader($this->fileName))->createData($newRecord);
    }

    /**
     * Update an existing charity record.
     *
     * @param string $fileName The name of the file containing the data
     * @param string $id The ID of the charity to update
     * @param string $name The new name for the charity
     * @param string $email The new email address for the charity representative
     * @return void
     */
    public function update(int $id, string $name, string $email): void
    {
        $newRecord = ['name' => $name, 'email' => $email];

        (new JsonReader($this->fileName))->updateData($id, $newRecord);
    }

    /**
     * Delete an existing charity record.
     *
     * @param string $id The ID of the charity to update
     * @return void
     */
    public function delete(int $id): void
    {
        (new JsonReader($this->fileName))->deleteData($id);
    }
    
    /**
     * Write charity data to a CSV file.
     *
     * @param string $fileName The name of the file containing the charity data
     * @return void
     */
    public function writeToCsv(): void
    {
        $csvFileName = fopen('./public/charities.csv', 'w');

        fputcsv($csvFileName, [
            "id",
            "name",
            "representative_email"
        ]);

        foreach ((new JsonReader($this->fileName))->showAllData() as $key => $row) {
            $key = substr($key, 4);
            array_pop($row);
            array_unshift($row, $key);
            fputcsv($csvFileName, $row);
        }
        fclose($csvFileName);
    }

}