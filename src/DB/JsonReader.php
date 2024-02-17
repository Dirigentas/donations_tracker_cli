<?php

/**
 * Class JsonReader
 * 
 * Provides methods for reading from and writing to files.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli\db;
 
class JsonReader
{   
    private $data, $filename;

        /**
     * Read data from a file.
     * 
     * @param string $filename The name of the file
     * @return array The data read from the file
     */
    public function __construct(string $filename)
    {
        if (!file_exists($filename . '.json')) {
            $this->data = [];
        } 
        else {
            $handle = fopen($filename . '.json', 'r');

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
     * Get the ID for a new record.
     * 
     * @param string $filename The name of the file
     * @return int The ID for the new record
     */
    public static function getId(string $filename) : int
    {
        if (!file_exists($filename.'_id')) {
            file_put_contents($filename .'_id', json_encode(1));
            return 1;
        } 
        else {
            $id = json_decode(file_get_contents($filename .'_id'), true);
            $id++;
            file_put_contents($filename .'_id', json_encode($id));
            return $id;
        }
    }



    /**
     * Write data to a file.
     * 
     * @param string $filename The name of the file
     * @param mixed $data The data to write to the file
     * @return void
     */
    public static function writeDataToFile(string $filename, array $data): void
    {
        $jsonData = json_encode($data);
        file_put_contents($filename . '.json', $jsonData);
    }

    /**
     * Create a new record.
     * 
     * @param string $filename The name of the file
     * @param array $newRecord The new record to create
     * @return void
     */
    public static function create(string $filename, array $newRecord): void
    {
        $data = self::readDataFromFile($filename);

        $data['id: ' . self::getId($filename)] = $newRecord;
        
        self::writeDataToFile($filename, $data);
    }

    /**
     * Update an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to update
     * @param array $newRecord The updated record
     * @return void
     */
    public static function update(string $filename, string $id, array $newRecord): void
    {
        $data = self::readDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id] = $newRecord;
            self::writeDataToFile($filename, $data);
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
    public static function partialUpdate(string $filename, $id, array $newRecord, string $updatedField, $updatedFieldId): void
    {
        $data = self::readDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id]['donations'][$updatedFieldId] = $newRecord;
            self::writeDataToFile($filename, $data);
        }
    }

    /**
     * Delete an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to delete
     * @return void
     */
    public static function delete(string $filename, string $id): void
    {
        $data = self::readDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            unset($data['id: ' . $id]);
            self::writeDataToFile($filename, $data);
        }
    }
}