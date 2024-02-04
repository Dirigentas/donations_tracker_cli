<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

final class Validation
{
    public static function EmailValidation(string $email): string|bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function DonationAmount($amount): bool
    {
        return is_numeric($amount);
    }
}