<?php

use App\Helpers\Admin\BackendHelper;
use Hashids\Hashids;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

if (!function_exists('update_env')) {
    function update_env( $data = [] ) : void
    {

        $path = base_path('.env');

        if (file_exists($path)) {
            foreach ($data as $key => $value) {
                $value = Str::replace(" ","",$value);
                file_put_contents($path, str_replace(
                    $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
                ));
            }
        }

    }
}

if (! function_exists('putPermanentEnv')) {

    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }

}

if (! function_exists('analytics_count_step_size')) {

    function analytics_count_step_size($max): float|int
    {
        return round(($max/10 + 2.5)/5)*5;
    }
}

if (! function_exists('number_format_short')) {


    function number_format_short( $n, $precision = 1 ): string
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }

}

if (! function_exists('trim_search_keyword')) {

    function trim_search_keyword($keyword = ""): string
    {
        return Str::replace(["'",'"'],'',strip_tags($keyword));
    }
}

if (! function_exists('get_time_by_format')) {

    function get_time_by_format($time = null, $format = "m/d/Y g:i A"): string
    {
        try {
            return Carbon::parse($time)->format($format);
        }
        catch (\Exception $exception)
        {
            return "";
        }
    }
}

if (! function_exists('get_date_by_format')) {

    function get_date_by_format($time = null, $format = "m/d/Y"): string
    {
        try {
            return Carbon::createFromDate($time)->format($format);
        }
        catch (\Exception $exception)
        {
            return "";
        }
    }
}

if (! function_exists('display_date_format')) {

    function display_date_format($time = null, $format = "m/d/Y", $fromFormat = "Y-m-d", $default = null): ?string
    {
        try
        {
            if (checkData($time))
            {
                return Carbon::createFromFormat($fromFormat,$time)->format($format);
            }
        }
        catch (\Exception $exception) { }
        return $default;
    }
}

if (! function_exists('checkData')) {

    function checkData($item,$array = false,$trim = false):bool
    {
        if ($array)
        {
            return $trim?isset($item) && trim($item)!="" && gettype($array) == "array":isset($item) && $item!="" && gettype($array) == "array";
        }
        return $trim?isset($item) && trim($item)!="":isset($item) && $item!="";
    }
}

if (! function_exists('collapseEmails')) {

    function collapseEmails($email):array
    {
        $emails = BackendHelper::JsonDecode(config('theme.orders_mail_groups'));
        return \Arr::collapse([
            $emails,
            [$email]
        ]);
    }
}

if (!function_exists('join_slug_base_url')) {

    function join_slug_base_url($append = ""): string
    {
        return config('settings.app_base_url').$append;
    }
}

if (!function_exists('check_odd_even')) {

    function check_odd_even($number): string
    {
        if ($number % 2 == 0) {
            return 'even';
        } else {
            return 'odd';
        }
    }
}

if (! function_exists('generate_timezone_list')) {
    function generate_timezone_list(): array
    {
        // Use a fixed UTC time to make offsets consistent
        $utcNow = new DateTime('now', new DateTimeZone('UTC'));

        $regions = [
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        ];

        // Collect identifiers for the selected regions
        $timezones = [];
        foreach ($regions as $region) {
            $timezones = array_merge(
                $timezones,
                DateTimeZone::listIdentifiers($region)
            );
        }

        // Build array with offset + identifier for proper sorting
        $temp = [];
        foreach ($timezones as $timezone) {
            $tz = new DateTimeZone($timezone);
            $temp[] = [
                'identifier' => $timezone,
                'offset'     => $tz->getOffset($utcNow),
            ];
        }

        // Sort by offset, then identifier
        usort($temp, function ($a, $b) {
            if ($a['offset'] === $b['offset']) {
                return strcmp($a['identifier'], $b['identifier']);
            }
            return $a['offset'] <=> $b['offset'];
        });

        // Build final list: 'Region/City' => '(UTC+05:30) Region/City'
        $list = [];
        foreach ($temp as $tz) {
            $offset = $tz['offset'];
            $sign   = $offset < 0 ? '-' : '+';
            $hours  = gmdate('H:i', abs($offset));
            $pretty = "UTC{$sign}{$hours}";

            $list[$tz['identifier']] = "({$pretty}) {$tz['identifier']}";
        }

        return $list;
    }
}


if (!function_exists('encryptOrderId')) {
    function encryptOrderId($orderId): string
    {
        $hashids = new Hashids('',12);
        return $hashids->encode($orderId);
    }
}

if (!function_exists('decryptOrderId')) {
    function decryptOrderId($truncatedEncodedOrderId): ?string
    {
        try
        {
            $hashids = new Hashids('',12);
            $result = $hashids->decode($truncatedEncodedOrderId);
            return Arr::first($result);
        }
        catch (\Exception $exception)
        {
            return null;
        }

    }
}

if (!function_exists('findMaxInArray')) {
    function findMaxInArray($array) {
        // Check if the array is empty
        if (empty($array)) {
            return null; // or any other default value you'd like to return
        }

        // Find the maximum value in the array
        return max($array);
    }
}

if (!function_exists('excel_trim')) {
    function excel_trim($item): ?string
    {
        try {
            return checkData($item)?trim($item):null;
        }
        catch (\Exception $exception){ return null; }
    }
}
