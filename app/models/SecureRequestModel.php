<?php
/*
This file should be part of the header "require" in all controller files.
It will deny any url direct access.

@author Victor Béser
*/
class SecureRequestModel {

    private static function getHeaderValue($key) {
        if (!isset($_SERVER[$key]) || empty($_SERVER[$key])) {
            return null;
        }

        $value = trim($_SERVER[$key]);
        if (strpos($value, ',') !== false) {
            $parts = array_map('trim', explode(',', $value));
            $value = $parts[0];
        }

        return $value;
    }

    private static function normalizeHost($value) {
        if (empty($value)) {
            return null;
        }

        $parsedHost = parse_url($value, PHP_URL_HOST);
        if ($parsedHost === null) {
            $parsedHost = parse_url('//' . $value, PHP_URL_HOST);
        }

        if ($parsedHost === null || $parsedHost === false) {
            return null;
        }

        return strtolower($parsedHost);
    }

    private static function getComparableHost($host) {
        $parts = array_values(array_filter(explode('.', $host)));
        $partsCount = count($parts);

        if ($partsCount >= 3) {
            return implode('.', array_slice($parts, -3));
        }

        if ($partsCount >= 2) {
            return implode('.', array_slice($parts, -2));
        }

        return $host;
    }

    private static function getTrustedHosts() {
        $trustedHosts = array();
        $possibleHosts = array(
            self::getHeaderValue('HTTP_HOST'),
            self::getHeaderValue('HTTP_X_FORWARDED_HOST'),
            self::getHeaderValue('HTTP_X_ORIGINAL_HOST'),
            AppUrlModel::baseUrl()
        );

        foreach ($possibleHosts as $possibleHost) {
            $normalizedHost = self::normalizeHost($possibleHost);
            if ($normalizedHost && !in_array($normalizedHost, $trustedHosts, true)) {
                $trustedHosts[] = $normalizedHost;
            }
        }

        return $trustedHosts;
    }

    private static function isAllowedOrigin($value) {
        $originHost = self::normalizeHost($value);
        if (!$originHost) {
            return false;
        }

        foreach (self::getTrustedHosts() as $trustedHost) {
            if ($originHost === $trustedHost) {
                return true;
            }

            if (self::getComparableHost($originHost) === self::getComparableHost($trustedHost)) {
                return true;
            }
        }

        return false;
    }

    private static function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function init() {
        if (
            self::isAjaxRequest() ||
            self::isAllowedOrigin(self::getHeaderValue('HTTP_ORIGIN')) ||
            self::isAllowedOrigin(self::getHeaderValue('HTTP_REFERER'))
        ) {
            return true;
        }

        die('Denied.');
    }

}

SecureRequestModel::init();
