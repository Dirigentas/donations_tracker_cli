<?php

/**
 * Class App
 * 
 * Main application class responsible for routing CLI commands.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli;

 use Aras\DonationsTrackerCli\DB\FileReader;
 use Aras\DonationsTrackerCli\Controllers\CharityController;
 use Aras\DonationsTrackerCli\Controllers\DonationsController;


final class App
{
    /**
     * Router function to handle CLI commands.
     * 
     * @param int $argc The number of arguments passed to the script
     * @param array $argv An array of the arguments passed to the script
     * @return void
     */
    public static function Router(int $argc, array $argv): void
    {      
        $filename = './src/DB/charities';

        if ($argc < 2) {
            echo "Usage: composer run-script start view_charities\n";
            echo "Usage: composer run-script start add_charity <name> <email>\n";
            echo "Usage: composer run-script start edit_charity <id_number> <name> <email>\n";
            echo "Usage: composer run-script start delete_charity <id_number>\n";
            echo "Usage: composer run-script start add_donation <donor_name> <amount> <charity_id>\n";
            echo "Usage: composer run-script start export_data\n";
            exit(1);
        }

        if ($argc == 2 && $argv[1] == 'view_charities') {
            print_r(FileReader::ReadDataFromFile($filename));
        }

        if ($argc == 4 && $argv[1] == 'add_charity') {

            CharityController::Create($filename, $argv[2], $argv[3]);

            echo "New charity added successfully.\n";
        }

        if ($argc == 5 && $argv[1] == 'edit_charity') {
            CharityController::Update($filename, $argv[2], $argv[3], $argv[4]);
        }

        if ($argc == 3 && $argv[1] == 'delete_charity') {
            FileReader::Delete($filename, $argv[2]);
        }

        if ($argc == 5 && $argv[1] == 'add_donation') {
            DonationsController::Create($filename, $argv[2], $argv[3], $argv[4]);
        }

        if ($argc == 2 && $argv[1] == 'export_data') {
            CharityController::WriteToCsv($filename);
        }
    }
}
