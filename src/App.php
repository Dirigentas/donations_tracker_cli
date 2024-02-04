<?php

/**
 * 
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli;

 use Aras\DonationsTrackerCli\DB\FileReader;

final class App
{
    public static function Router(int $argc, array $argv): void
    {      
        $filename = './src/DB/charities';

        // Check if command-line arguments are provided
        if ($argc < 2) {
            echo "Usage: composer run-script start view_charities\n";
            echo "Usage: composer run-script start add_charity <name> <email>\n";
            echo "Usage: composer run-script start edit_charity <id_number> <name> <email>\n";
            echo "Usage: composer run-script start delete_charity <id_number>\n";
            echo "Usage: composer run-script start add_donation <donor_name <amount> <charity_id>\n";
            exit(1);
        }

        if ($argc == 2 && $argv[1] == 'view_charities') {
            print_r(FileReader::ReadDataFromFile($filename));
        }


        if ($argc == 4 && $argv[1] == 'add_charity') {
            // Validate input (e.g., ensure age is a positive integer)

            FileReader::Create($filename, $argv[2], $argv[3]);

            echo "New charity added successfully.\n";
        }

        if ($argc == 5 && $argv[1] == 'edit_charity') {
        $updateData = ['name' => 'Jane', 'age' => 25];
            FileReader::Update($filename, $argv[2], $argv[3], $argv[4]);
        }

        if ($argc == 3 && $argv[1] == 'delete_charity') {
            FileReader::Delete($filename, $argv[2]);
        }
    }
}
