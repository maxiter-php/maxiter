<?php
/*
Centralized environment configuration loader for Maxiter.

@author Victor Beser
*/

require_once __DIR__ . '/helpers.php';

if (!function_exists('maxiter_env_file_path')) {
    function maxiter_env_file_path()
    {
        return maxiter_env_ini_file_path();
    }
}

if (!function_exists('maxiter_env_ini_file_path')) {
    function maxiter_env_ini_file_path()
    {
        return maxiter_project_path('env.ini');
    }
}

if (!function_exists('maxiter_dotenv_file_path')) {
    function maxiter_dotenv_file_path()
    {
        return maxiter_project_path('.env');
    }
}

if (!function_exists('maxiter_is_env_section_array')) {
    function maxiter_is_env_section_array($value)
    {
        return is_array($value);
    }
}

if (!function_exists('maxiter_merge_env_config')) {
    function maxiter_merge_env_config($baseConfig, $overrideConfig)
    {
        $merged = is_array($baseConfig) ? $baseConfig : array();

        if (!is_array($overrideConfig)) {
            return $merged;
        }

        foreach ($overrideConfig as $key => $value) {
            if (isset($merged[$key]) && is_array($merged[$key]) && is_array($value)) {
                $merged[$key] = maxiter_merge_env_config($merged[$key], $value);
                continue;
            }

            $merged[$key] = $value;
        }

        return $merged;
    }
}

if (!function_exists('maxiter_strip_env_quotes')) {
    function maxiter_strip_env_quotes($value)
    {
        $value = trim((string) $value);
        $length = strlen($value);

        if ($length >= 2) {
            $firstChar = substr($value, 0, 1);
            $lastChar = substr($value, -1);

            if (($firstChar === '"' && $lastChar === '"') || ($firstChar === "'" && $lastChar === "'")) {
                $value = substr($value, 1, $length - 2);
            }
        }

        return str_replace(array('\n', '\r', '\t'), array("\n", "\r", "\t"), $value);
    }
}

if (!function_exists('maxiter_parse_ini_env_config')) {
    function maxiter_parse_ini_env_config()
    {
        $envFile = maxiter_env_ini_file_path();

        if (!file_exists($envFile)) {
            return array();
        }

        $parsed = parse_ini_file($envFile, true);

        return ($parsed !== false && is_array($parsed)) ? $parsed : array();
    }
}

if (!function_exists('maxiter_assign_dotenv_value')) {
    function maxiter_assign_dotenv_value(&$config, $section, $key, $value)
    {
        if ($section === null || $section === '') {
            $config[$key] = $value;
            return;
        }

        if (!isset($config[$section]) || !is_array($config[$section])) {
            $config[$section] = array();
        }

        $config[$section][$key] = $value;
    }
}

if (!function_exists('maxiter_normalize_dotenv_key')) {
    function maxiter_normalize_dotenv_key($key)
    {
        $key = trim((string) $key);
        $section = null;
        $normalizedKey = $key;
        $databaseKeys = array('DB', 'DRIVER', 'PORT', 'HOST', 'USER', 'PASS', 'EXPORT_EXT', 'CUSTOM_EXPORT_CMD', 'CUSTOM_IMPORT_CMD');

        if (strpos($key, '__') !== false) {
            $parts = explode('__', $key, 2);
            $section = strtolower(trim($parts[0]));
            $normalizedKey = strtoupper(trim($parts[1]));
        } elseif (strpos($key, '.') !== false) {
            $parts = explode('.', $key, 2);
            $section = strtolower(trim($parts[0]));
            $normalizedKey = strtoupper(trim($parts[1]));
        } elseif (in_array($key, array('APP_NAME', 'APP_DESCRIPTION', 'BEARER_TOKEN', 'UPDATE_USER', 'UPDATE_REPO', 'UPDATE_BRANCH'))) {
            $section = 'app';
        } elseif ($key === 'DEFAULT_TIMEZONE') {
            $section = 'timezone';
        } elseif (in_array($key, $databaseKeys)) {
            $section = 'maxiter';
        }

        return array($section, strtoupper($normalizedKey));
    }
}

if (!function_exists('maxiter_parse_dotenv_config')) {
    function maxiter_parse_dotenv_config()
    {
        $dotenvFile = maxiter_dotenv_file_path();
        $config = array();

        if (!file_exists($dotenvFile)) {
            return $config;
        }

        $lines = file($dotenvFile, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return $config;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || strpos($line, '#') === 0 || strpos($line, ';') === 0) {
                continue;
            }

            if (strpos($line, '=') === false) {
                continue;
            }

            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $value = maxiter_strip_env_quotes(isset($parts[1]) ? $parts[1] : '');

            if ($key === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_.-]*$/', $key) !== 1) {
                continue;
            }

            list($section, $normalizedKey) = maxiter_normalize_dotenv_key($key);
            maxiter_assign_dotenv_value($config, $section, $normalizedKey, $value);
        }

        return $config;
    }
}

if (!function_exists('maxiter_load_env_config')) {
    function maxiter_load_env_config()
    {
        static $env = null;

        if ($env !== null) {
            return $env;
        }

        $iniConfig = maxiter_parse_ini_env_config();
        $dotenvConfig = maxiter_parse_dotenv_config();

        $env = maxiter_merge_env_config($iniConfig, $dotenvConfig);

        return $env;
    }
}

if (!function_exists('maxiter_get_env_value')) {
    function maxiter_get_env_value($config, $section, $key, $defaultValue)
    {
        if (!is_array($config)) {
            return $defaultValue;
        }

        if (isset($config[$section]) && is_array($config[$section]) && isset($config[$section][$key])) {
            return $config[$section][$key];
        }

        if (isset($config[$key])) {
            return $config[$key];
        }

        return $defaultValue;
    }
}

if (!function_exists('maxiter_find_database_section')) {
    function maxiter_find_database_section($config, $databaseName)
    {
        if (!is_array($config)) {
            return null;
        }

        if (isset($config[$databaseName]) && is_array($config[$databaseName])) {
            return $databaseName;
        }

        foreach ($config as $section => $values) {
            if (!is_array($values)) {
                continue;
            }

            if (isset($values['DB']) && strtolower($values['DB']) === strtolower($databaseName)) {
                return $section;
            }
        }

        return null;
    }
}
