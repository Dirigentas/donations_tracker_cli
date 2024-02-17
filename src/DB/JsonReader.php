<?php

/**
 * Class JsonReader
 * 
 * Provides methods for reading from and writing to files.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli\db;

 use Aras\DonationsTrackerCli\db\DataReaderInterface;
 
class JsonReader implements DataReaderInterface
{   
    private $filename, $data;

    /**
     * Read data from a file.
     * 
     * @param string $filename The name of the file
     * @return array The data read from the file
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;

        if (!file_exists(__DIR__ . "/" . $this->filename . '.json')) {
            $this->data = [];
        } 
        else {
            $handle = fopen(__DIR__ . "/" . $this->filename . '.json', 'r');

            $jsonData = '';
            
            while (!feof($handle)) {
                $chunk = fread($handle, 8192);
                $jsonData .= $chunk;
            }
            
            fclose($handle);
            
            $jsonArray = json_decode($jsonData, true);
            
            if ($jsonArray === null && json_last_error() !== JSON_ERROR_NONE) {
                echo "Error decoding JSON: " . json_last_error_msg() . PHP_EOL;
                exit(1);
            } else {
                $this->data = $jsonArray;
            }
        }
    }

    /**
     * Write data to a file.
     * 
     * @param string $filename The name of the file
     * @param mixed $data The data to write to the file
     * @return void
     */
    public function __destruct()
    {
        $jsonData = json_encode($this->data);
        file_put_contents(__DIR__ . '/' . $this->filename . '.json', $jsonData);
    }

    /**
     * Get the ID for a new record.
     * 
     * @param string $filename The name of the file
     * @return int The ID for the new record
     */
    private function getId(): int
    {
        if (!file_exists(__DIR__ . '/' . $this->filename.'_id')) {
            file_put_contents(__DIR__ . '/' . $this->filename .'_id', json_encode(1));
            return 1;
        } 
        else {
            $id = json_decode(file_get_contents(__DIR__ . '/' . $this->filename .'_id'), true);
            $id++;
            file_put_contents(__DIR__ . '/' . $this->filename .'_id', json_encode($id));
            return $id;
        }
    }

    public function showData(int $id): array
    {
        // foreach ($this->data as $key => $data) {
        //     if ($key == "id: " . $id) {
        //         return $data;
        //     }
        // }
        return [];
    }

    public function showAllData(): array
    {
        // usort($this->data, fn ($a, $b) => $a['pavarde'] <=> $b['pavarde']);

        return $this->data;
    }

    /**
     * Create a new record.
     * 
     * @param string $filename The name of the file
     * @param array $newRecord The new record to create
     * @return void
     */
    public function createData(array $newRecord): void
    {
        $this->data['id: ' . $this->getId()] = $newRecord;
    }

    /**
     * Update an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to update
     * @param array $newRecord The updated record
     * @return void
     */
    public function updateData(int $id, array $newRecord): void
    {
        // $data = self::readDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id] = $newRecord;
            // self::writeDataToFile($filename, $data);
        }
    }

    /**
     * Partially update an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to update
     * @param array $newRecord The updated record
     * @param string $updatedField The field to update
     * @param string $updatedFieldId The ID of the field to update
     * @return void
     */
    public function partialUpdate(string $filename, $id, array $newRecord, string $updatedField, $updatedFieldId): void
    {
        // $data = self::readDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id]['donations'][$updatedFieldId] = $newRecord;
            // self::writeDataToFile($filename, $data);
        }
    }

    /**
     * Delete an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to delete
     * @return void
     */
    public function deleteData(int $id): void
    {
        // $data = self::readDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            unset($data['id: ' . $id]);
            // self::writeDataToFile($filename, $data);
        }
    }
}