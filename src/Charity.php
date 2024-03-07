<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

// use Aras\DonationsTrackerCli\Controllers\CharityController;

class Charity {
    private $id;
    private $name;
    private $representativeEmail;

    public function __construct($id, $name, $representativeEmail)
    {
        $this->id = $id;
        $this->name = $name;
        $this->representativeEmail = $representativeEmail;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRepresentativeEmail()
    {
        return $this->representativeEmail;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setRepresentativeEmail(string $email): void
    {
        $this->representativeEmail = $email;
    }
}