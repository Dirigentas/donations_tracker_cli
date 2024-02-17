<?php

/**
 * Class App
 * 
 * Main application class responsible for routing CLI commands.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli;

 use Aras\DonationsTrackerCli\db\JsonReader;
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
    public static function router(int $argc, array $argv)
    {   
        if ($argc < 2) {
            echo "Usage: composer run-script start view_charities" . PHP_EOL;
            echo "Usage: composer run-script start add_charity <name> <email>" . PHP_EOL;
            echo "Usage: composer run-script start edit_charity <id_number> <name> <email>" . PHP_EOL;
            echo "Usage: composer run-script start delete_charity <id_number>" . PHP_EOL;
            echo "Usage: composer run-script start add_donation <donor_name> <amount> <charity_id>" . PHP_EOL;
            echo "Usage: composer run-script start export_data" . PHP_EOL;
            exit(1);
        }

        if ($argc == 2 && $argv[1] == 'view_charities') {
            return (new CharityController())->index();
        }

        if ($argc == 4 && $argv[1] == 'add_charity') {

            return (new CharityController())->create($argv[2], $argv[3]);
        }
        
        if ($argc == 5 && $argv[1] == 'edit_charity') {
            return (new CharityController())->update(+$argv[2], $argv[3], $argv[4]);
        }

        if ($argc == 3 && $argv[1] == 'delete_charity') {
            JsonReader::delete($fileName, $argv[2]);
        }

        if ($argc == 5 && $argv[1] == 'add_donation') {
            DonationsController::create($fileName, $argv[2], $argv[3], $argv[4]);
        }

        if ($argc == 2 && $argv[1] == 'export_data') {
            CharityController::writeToCsv($fileName);
        }
    }
}
