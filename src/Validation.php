<?php

declare(strict_types=1);

namespace Aras\DonationsTrackerCli;

final class Validation
{
    /**
     * Validate an email address.
     *
     * @param string $email The email address to validate
     * @return string|bool The validated email address if valid, otherwise false
     */
    public static function EmailValidation(string $email): string|bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate a donation amount.
     *
     * @param string $amount The donation amount to validate
     * @return bool True if the amount is numeric, otherwise false
     */
    public static function DonationAmount(string $amount): bool
    {
        return is_numeric($amount);
    }
}