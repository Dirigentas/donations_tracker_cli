<?php

/**
 * Class App
 * 
 * Main application class responsible for routing CLI commands.
 */

 declare(strict_types=1);

 namespace Aras\DonationsTrackerCli;

 use Aras\DonationsTrackerCli\Controllers\CharityController;
 use Aras\DonationsTrackerCli\Controllers\DonationsController;
 use Aras\DonationsTrackerCli\CharityPersistence;


final class App
{
    private $notesToUser = [
        "Usage1" => "composer run-script start view_charity <id_number>",
        "Usage2" => "composer run-script start view_charities",
        "Usage3" => "composer run-script start add_charity <name> <email>",
        "Usage4" => "composer run-script start edit_charity <id_number> <name> <email>",
        "Usage5" => "composer run-script start delete_charity <id_number>",
        "Usage6" => "composer run-script start add_donation <donor_name> <amount> <charity_id>",
        "Usage7" => "composer run-script start export_data"
    ];

    /**
     * Router function to handle CLI commands.
     * 
     * @param int $argc The number of arguments passed to the script
     * @param array $argv An array of the arguments passed to the script
     * @return void
     */
    public function router(int $argc, array $argv)
    {   
        if ($argc == 3 && $argv[1] == 'view_charity') {
            return (new CharityController())->show(+$argv[2]);
        }

        if ($argc == 2 && $argv[1] == 'view_charities') {
            return (new CharityController())->showAll();
        }

        if ($argc == 4 && $argv[1] == 'add_charity') {

            return (new CharityController())->create($argv[2], $argv[3]);
        }
        
        if ($argc == 5 && $argv[1] == 'edit_charity') {
            return (new CharityController())->update(+$argv[2], $argv[3], $argv[4]);
        }
        
        if ($argc == 3 && $argv[1] == 'delete_charity') {
            return (new CharityController())->delete(+$argv[2]);
        }

        if ($argc == 5 && $argv[1] == 'add_donation') {
            return (new DonationsController())->create($argv[2], $argv[3], +$argv[4]);
        }

        if ($argc == 2 && $argv[1] == 'export_data') {
            return (new CharityPersistence())->writeToCsv((new CharityController())->fileName);
        }

        return print_r($this->notesToUser);
    }
}
