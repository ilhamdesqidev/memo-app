<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTimeInterface;

class DateHelper
{
    /**
     * Format tanggal dengan aman
     *
     * @param  Carbon|DateTimeInterface|string|null  $date
     * @param  string  $format
     * @param  string  $fallback
     * @return string
     */
    public static function safeDateFormat($date, $format = 'd M Y', $fallback = '.........................')
    {
        try {
            if ($date instanceof Carbon || $date instanceof DateTimeInterface) {
                return $date->format($format);
            }

            if (is_string($date) && trim($date) !== '') {
                return Carbon::parse($date)->format($format);
            }

            return $fallback;
        } catch (\Exception $e) {
            return $fallback;
        }
    }
}
