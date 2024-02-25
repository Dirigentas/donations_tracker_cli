<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

// use Aras\DonationsTrackerCli\Controllers\CharityController;

class CharityRepository {
    private $charities = [];

    public function addCharity(Charity $charity) {
        $this->charities[] = $charity;
    }

    public function getAllCharities() {
        return $this->charities;
    }

    public function getCharityById($id) {
        foreach ($this->charities as $charity) {
            if ($charity->getId() === $id) {
                return $charity;
            }
        }
        return null;
    }

    public function deleteCharity($id) {
        foreach ($this->charities as $key => $charity) {
            if ($charity->getId() === $id) {
                unset($this->charities[$key]);
                return true;
            }
        }
        return false;
    }
}