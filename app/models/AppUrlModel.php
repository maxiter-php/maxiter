<?php
/*
This model resolves the application base URL dynamically at runtime,
so the framework does not depend on a configured APP_BASE_URL.

@author Victor Beser
*/
class AppUrlModel
{

    public static function scheme()
    {
        if (
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https'
        ) {
            return 'https';
        }

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '' && $_SERVER['HTTPS'] !== 'off') {
            return 'https';
        }

        return 'http';
    }

    public static function host()
    {
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] !== '') {
            return $_SERVER['HTTP_HOST'];
        }

        return 'localhost';
    }

    public static function basePath()
    {
        $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';
        $projectRoot = dirname(dirname(__DIR__));

        $normalizedDocumentRoot = self::normalizeDirectory($documentRoot);
        $normalizedProjectRoot = self::normalizeDirectory($projectRoot);

        if (
            $normalizedDocumentRoot !== '' &&
            $normalizedProjectRoot !== '' &&
            strpos($normalizedProjectRoot, $normalizedDocumentRoot) === 0
        ) {
            $relativePath = substr($normalizedProjectRoot, strlen($normalizedDocumentRoot));
            $relativePath = trim($relativePath, '/');

            if ($relativePath === '') {
                return '/';
            }

            return '/' . $relativePath . '/';
        }

        $scriptName = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', $_SERVER['SCRIPT_NAME']) : '';
        $directory = rtrim(dirname($scriptName), '/');

        if ($directory === '' || $directory === '.') {
            return '/';
        }

        if (substr($directory, -4) === '/app') {
            $directory = dirname($directory);
        } elseif (substr($directory, -16) === '/app/controllers') {
            $directory = dirname(dirname($directory));
        }

        $directory = str_replace('\\', '/', $directory);
        $directory = trim($directory, '/');

        if ($directory === '') {
            return '/';
        }

        return '/' . $directory . '/';
    }

    public static function baseUrl()
    {
        return self::scheme() . '://' . self::host() . self::basePath();
    }

    public static function url($path)
    {
        return self::baseUrl() . ltrim($path, '/');
    }

    public static function asset($path)
    {
        return self::url($path);
    }

    private static function normalizeDirectory($path)
    {
        if (empty($path)) {
            return '';
        }

        $path = str_replace('\\', '/', $path);
        $path = preg_replace('#/+#', '/', $path);

        return rtrim(strtolower($path), '/');
    }

}
