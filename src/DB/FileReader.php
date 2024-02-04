<?php

/**
 * Class FileReader
 * 
 * Provides methods for reading from and writing to files.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli\DB;
 
final class FileReader
{   
    /**
     * Get the ID for a new record.
     * 
     * @param string $filename The name of the file
     * @return int The ID for the new record
     */
    public static function GetId(string $filename) : int
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
     * Read data from a file.
     * 
     * @param string $filename The name of the file
     * @return array The data read from the file
     */
    public static function ReadDataFromFile(string $filename): array
    {
        if (!file_exists($filename . '.json')) {
            $data = [];
            return $data;
        } 
        else {
            $data = file_get_contents($filename . '.json');
            return json_decode($data, true);
        }
    }

    /**
     * Write data to a file.
     * 
     * @param string $filename The name of the file
     * @param mixed $data The data to write to the file
     * @return void
     */
    public static function WriteDataToFile(string $filename, array $data): void
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
    public static function Create(string $filename, array $newRecord): void
    {
        $data = self::ReadDataFromFile($filename);

        $data['id: ' . self::GetId($filename)] = $newRecord;
        
        self::WriteDataToFile($filename, $data);
    }

    /**
     * Update an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to update
     * @param array $newRecord The updated record
     * @return void
     */
    public static function Update(string $filename, string $id, array $newRecord): void
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id] = $newRecord;
            self::WriteDataToFile($filename, $data);
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
    public static function PartialUpdate(string $filename, $id, array $newRecord, string $updatedField, $updatedFieldId): void
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id]['donations'][$updatedFieldId] = $newRecord;
            self::WriteDataToFile($filename, $data);
        }
    }

    /**
     * Delete an existing record.
     * 
     * @param string $filename The name of the file
     * @param string $id The ID of the record to delete
     * @return void
     */
    public static function Delete(string $filename, string $id): void
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            unset($data['id: ' . $id]);
            self::WriteDataToFile($filename, $data);
        }
    }
}