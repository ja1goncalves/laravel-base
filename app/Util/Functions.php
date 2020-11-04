<?php


namespace App\Util;


use Carbon\Carbon;

final class Functions
{
    public const FORMAT_DATE = "[0-9]{2}/[0-9]{2}/[0-9]{4}";
    public const FORMAT_DATE_BR = "d/m/Y H:i";
    public const FORMAT_DATE_US = "Y-m-d H:i";
    public const DATES_TIME = ['created_at', 'updated_at', 'deleted_at', 'start_at', 'end_at'];
    public const SPECIAL_CHARACTERS = [
        "/(á|à|ã|â|ä)/",
        "/(Á|À|Ã|Â|Ä)/",
        "/(é|è|ê|ë)/",
        "/(É|È|Ê|Ë)/",
        "/(í|ì|î|ï)/",
        "/(Í|Ì|Î|Ï)/",
        "/(ó|ò|õ|ô|ö)/",
        "/(Ó|Ò|Õ|Ô|Ö)/",
        "/(ú|ù|û|ü)/",
        "/(Ú|Ù|Û|Ü)/",
        "/(ñ)/","/(Ñ)/"
    ];

    public static function convertDateToUS($date, $invert = false, $time = true)
    {
        if ($invert)
            return Carbon::createFromFormat(self::getFormatDateUS($time), $date)->format(self::getFormatDateBR($time));
        else
            return Carbon::createFromFormat(self::getFormatDateBR($time), $date)->format(self::getFormatDateUS($time));
    }

    public static function getFormatDateUS($time = true): string
    {
        return $time ? self::FORMAT_DATE_US : 'Y-m-d';
    }

    public static function getFormatDateBR($time = true): string
    {
        return $time ? self::FORMAT_DATE_BR : 'd/m/Y';
    }

    public static function getWeekendDays(): array
    {
        $inFriday = Carbon::now()->isFriday();
        $inSaturday = $inFriday || Carbon::now()->isSaturday();
        $inSunday = $inSaturday || Carbon::now()->isSunday();

        return [
            'friday' => (new Carbon($inFriday ? 'last' : 'first' . ' friday this week'))->format('Y-m-d'),
            'saturday' => (new Carbon($inSaturday ? 'last' : 'first' . ' saturday this week'))->format('Y-m-d'),
            'sunday' => (new Carbon($inSunday ? 'last' : 'first' . ' sunday this week'))->format('Y-m-d'),
        ];
    }

    public static function routeDetails(string $route_name): array
    {
        $route = explode('.', $route_name);
        return [
            'module' => $route[0],
            'action' => last($route)
        ];
    }

    /**
     * @param string $str
     * @return string
     */
    public static function onlyNumbers(string $str): string
    {
        return preg_replace('/\D/', '', $str);
    }

    public static function removeSpecialCharacters(string  $str): string
    {
        return preg_replace(self::SPECIAL_CHARACTERS, explode(" ","a A e E i I o O u U n N"), $str);
    }
}
