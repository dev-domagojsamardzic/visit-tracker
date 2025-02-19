<?php

namespace App\Validators;

use DateTime;

class InputValidator
{
    /**
     * Validate date is correct
     * @param string $date
     * @return bool
     */
    public static function validateDate(string $date): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Validate date range
     * @param string $start
     * @param string $end
     * @return bool
     */
    public static function validateDateRange(string $start, string $end): bool
    {
        if (!self::validateDate($start) || !self::validateDate($end)) {
            return false;
        }

        return strtotime($start) <= strtotime($end);
    }

    /**
     * Validate visitor_id
     * @param string $value
     * @return bool
     */
    public static function validateVisitorId(string $value): bool
    {
        return preg_match('/^[a-zA-Z0-9]{10}$/', $value);
    }

    /**
     * Validate url
     * @param string $url
     * @return bool
     */
    public static function validateUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}