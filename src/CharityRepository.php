<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

// use Aras\DonationsTrackerCli\Controllers\CharityController;

class CharityRepository {
    private $charities = [];
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        
        if (file_exists($this->filePath)) {
            $data = file_get_contents($this->filePath);
            $charitiesData = json_decode($data, true);
            if ($charitiesData) {
                foreach ($charitiesData as $charityData) {
                    $this->charities[] = new Charity($charityData['id'], $charityData['name'], $charityData['representativeEmail']);
                }
            }
        }
    }

    public function addCharity(Charity $charity)
    {
        $this->charities[] = $charity;
    }

    public function getAllCharities()
    {
        uasort($this->charities, fn ($a, $b) => $a['name'] <=> $b['name']);

        return $this->charities;
    }

    public function getCharityById($id)
    {
        foreach ($this->charities as $charity) {
            if ($charity->getId() === $id) {
                return $charity;
            }
        }
        return null;
    }

    public function deleteCharity($id)
    {
        foreach ($this->charities as $key => $charity) {
            if ($charity->getId() === $id) {
                unset($this->charities[$key]);
                return true;
            }
        }
        return false;
    }

    private function __destruct()
    {
        $charitiesData = [];
        foreach ($this->charities as $charity) {
            $charitiesData[] = [
                'id' => $charity->getId(),
                'name' => $charity->getName(),
                'representativeEmail' => $charity->getRepresentativeEmail()
            ];
        }
        file_put_contents($this->filePath, json_encode($charitiesData, JSON_PRETTY_PRINT));
    }
}