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
    

}