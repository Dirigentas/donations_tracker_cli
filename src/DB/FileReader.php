<?php

/**
 * 
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli\DB;
 
final class FileReader
{ 
    private static function GetId($filename) : int
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

    // Function to read data from a file
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

    // Function to write data to a file
    public static function WriteDataToFile($filename, $data)
    {
            $jsonData = json_encode($data);
            file_put_contents($filename . '.json', $jsonData);

    }

    // Function to create a new record
    public static function Create($filename, $name, $email)
    {
        $data = self::ReadDataFromFile($filename);

        $newRecord = ['name' => $name, 'email' => $email];

        $data['id: ' . self::GetId($filename)] = $newRecord;
        
        self::WriteDataToFile($filename, $data);
    }

    // Function to update a record
    public static function Update($filename, $id, $name, $email)
    {
        $data = self::ReadDataFromFile($filename);
        if (isset($data['id: ' . $id])) {
            $data['id: ' . $id] = ['name' => $name, 'email' => $email];
            self::WriteDataToFile($filename, $data);
        }
    }

    // Function to delete a record
    public static function Delete($filename, $id)
    {
        $data = self::ReadDataFromFile($filename);
        // print_r($data);
        // die;
        if (isset($data['id: ' . $id])) {
            unset($data['id: ' . $id]);
            self::WriteDataToFile($filename, $data);
        }
    }
}