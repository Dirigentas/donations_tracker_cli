<?php

/**
 * 
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli\DB;
 
final class FileReader
{   
    // ID
    public static function GetId($filename) : int
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

    // Read
    public static function ReadDataFromFile($filename)
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

    // Write
    public static function WriteDataToFile($filename, $data)
    {
            $jsonData = json_encode($data);
            file_put_contents($filename . '.json', $jsonData);

    }

    // Create
    public static function Create($filename, $newRecord)
    {
        $data = self::ReadDataFromFile($filename);

        $data['id: ' . self::GetId($filename)] = $newRecord;
        
        self::WriteDataToFile($filename, $data);
    }

    // Update
    public static function Update($filename, $id, $newRecord)
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id] = $newRecord;
            self::WriteDataToFile($filename, $data);
        }
    }

    // Partial Update
    public static function PartialUpdate($filename, $id, $newRecord, $updatedField, $updatedFieldId)
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id][$updatedField][$updatedFieldId] = $newRecord;
            self::WriteDataToFile($filename, $data);
        }
    }

    // Delete
    public static function Delete($filename, $id)
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            unset($data['id: ' . $id]);
            self::WriteDataToFile($filename, $data);
        }
    }
}