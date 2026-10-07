<?php

$projectRoot = dirname(dirname(__DIR__));

$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH);

if ($requestPath === false || $requestPath === null) {
    $requestPath = '/';
}

$requestPath = rawurldecode($requestPath);
$filePath = $projectRoot . str_replace('/', DIRECTORY_SEPARATOR, $requestPath);

$maxiterIsDevEnv = true;
$candidatesEnv = array(
    $projectRoot . DIRECTORY_SEPARATOR . 'env.ini',
    $projectRoot . DIRECTORY_SEPARATOR . '.env',
);
$envMaxiterRaw = null;
foreach ($candidatesEnv as $candidateEnvFile) {
    if (file_exists($candidateEnvFile)) {
        $ext = strtolower(pathinfo($candidateEnvFile, PATHINFO_EXTENSION));
        if ($ext === 'ini') {
            $envIni = @parse_ini_file($candidateEnvFile);
            if (is_array($envIni)) {
                $envMaxiterRaw = null;
                if (isset($envIni['ENVIRONMENT'])) {
                    $envMaxiterRaw = (string)$envIni['ENVIRONMENT'];
                } elseif (isset($envIni['APP_ENV'])) {
                    $envMaxiterRaw = (string)$envIni['APP_ENV'];
                }
                if ($envMaxiterRaw !== null) {
                    $env = strtolower(trim($envMaxiterRaw));
                    if ($env !== '' && $env !== 'dev' && $env !== 'development' && $env !== 'local') {
                        $maxiterIsDevEnv = false;
                    }
                    break;
                }
            }
        } else {
            $dotenv = @file($candidateEnvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (is_array($dotenv)) {
                $envFound = null;
                foreach ($dotenv as $line) {
                    $line = trim($line);
                    if ($line === '' || $line[0] === '#' || $line[0] === ';') continue;
                    if (strpos($line, '=') === false) continue;
                    list($k, $v) = explode('=', $line, 2);
                    $k = trim($k);
                    $v = trim($v);
                    if ($v !== '' && ($v[0] === '"' || $v[0] === "'")) {
                        $v = trim($v, "\"'\r\n\t ");
                    }
                    if (($k === 'ENVIRONMENT' || $k === 'APP_ENV') && $envFound === null) {
                        $envFound = $v;
                    }
                }
                if ($envFound !== null) {
                    $env = strtolower(trim($envFound));
                    if ($env !== '' && $env !== 'dev' && $env !== 'development' && $env !== 'local') {
                        $maxiterIsDevEnv = false;
                    }
                    break;
                }
            }
        }
    }
}
if ($maxiterIsDevEnv && function_exists('getenv')) {
    $envCandidates = array(getenv('APP_ENV'), getenv('ENVIRONMENT'));
    foreach ($envCandidates as $envRaw) {
        if ($envRaw === false || $envRaw === null) continue;
        $env = strtolower(trim((string)$envRaw));
        if ($env !== '' && $env !== 'dev' && $env !== 'development' && $env !== 'local') {
            $maxiterIsDevEnv = false;
            break;
        }
    }
}

$blockedFiles = array('/env.ini', '/.env', '/.env-example', '/.env.example');

if (in_array(strtolower($requestPath), $blockedFiles, true)) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

$lrClientFile = $projectRoot . '/bootstrap/server/maxiter-live-reload-client.js';
$lrEnabledFile = $projectRoot . '/bootstrap/server/.maxiter_dev_server';
$lrEnabled = $maxiterIsDevEnv && file_exists($lrEnabledFile);
$lrPort = false;
if ($lrEnabled) {
    $lrPortRaw = @file_get_contents($lrEnabledFile);
    if ($lrPortRaw !== false && ctype_digit(trim($lrPortRaw))) {
        $lrPort = (int)trim($lrPortRaw);
    }
}

$blockDevRoutesUnlessEnabled = function () use ($lrEnabled) {
    if (!$lrEnabled) {
        http_response_code(404);
        echo 'Not Found';
        return true;
    }
    return false;
};

if ($requestPath === '/__maxiter_live_reload.js') {
    if ($blockDevRoutesUnlessEnabled()) return true;
    header('Content-Type: application/javascript; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    if ($lrPort !== false) {
        echo 'window.__MAXITER_LIVE_RELOAD_PORT__ = ' . $lrPort . ';' . PHP_EOL;
    }
    if (file_exists($lrClientFile)) {
        readfile($lrClientFile);
    } else {
        echo '/* Maxiter live-reload client file missing */';
    }
    return true;
}

if ($requestPath === '/__maxiter_live_port') {
    if ($blockDevRoutesUnlessEnabled()) return true;
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    echo json_encode(array(
        'enabled' => $lrEnabled,
        'port'    => $lrPort,
        'server'  => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null,
    ));
    return true;
}

if ($requestPath !== '/' && is_file($filePath)) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $static = array(
        'js'  => 'application/javascript',
        'css' => 'text/css',
        'html'=> 'text/html',
        'htm' => 'text/html',
        'json'=> 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg'=> 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'webp'=> 'image/webp',
        'woff'=> 'font/woff',
        'woff2'=>'font/woff2',
        'ttf' => 'font/ttf',
        'otf' => 'font/otf',
        'eot' => 'application/vnd.ms-fontobject',
        'map' => 'application/json',
        'mp4' => 'video/mp4',
        'mp3' => 'audio/mpeg',
        'pdf' => 'application/pdf',
    );
    $realFilePath = realpath($filePath);
    $realProjectRoot = realpath($projectRoot);
    $insideProjectRoot = $realFilePath !== false && $realProjectRoot !== false
        && (strpos($realFilePath, $realProjectRoot . DIRECTORY_SEPARATOR) === 0
            || $realFilePath === $realProjectRoot);
    if (!$insideProjectRoot && is_file($filePath)) {
        http_response_code(403);
        echo 'Forbidden';
        return true;
    }
    if (isset($static[$ext]) && $lrEnabled === true && ($ext === 'html' || $ext === 'htm')) {
        $content = file_get_contents($filePath);
        $bufferContentType = $static[$ext];
        $maxiterInjectHtmlStatic = function ($buffer) use ($lrEnabled, $lrPort) {
            if ($lrEnabled !== true || stripos($buffer, '<html') === false) {
                return $buffer;
            }
            $tagPort = 'window.__MAXITER_LIVE_RELOAD_PORT__';
            $tagLoaded = '__MAXITER_LIVE_RELOAD_LOADED__';
            $tagSrc = '/__maxiter_live_reload.js';
            if (stripos($buffer, $tagPort) !== false || stripos($buffer, $tagLoaded) !== false || stripos($buffer, $tagSrc) !== false) {
                return $buffer;
            }
            $portSnippet = '';
            if ($lrPort !== false) {
                $portSnippet = '<script>' . $tagPort . ' = ' . $lrPort . ';</script>';
            }
            $snippet = $portSnippet . '<script async src="/__maxiter_live_reload.js?v=' . time() . '"></script>';
            $pos = stripos($buffer, '</body>');
            if ($pos !== false) {
                return substr($buffer, 0, $pos) . $snippet . substr($buffer, $pos);
            }
            $pos = stripos($buffer, '</head>');
            if ($pos !== false) {
                return substr($buffer, 0, $pos) . $snippet . substr($buffer, $pos);
            }
            return $buffer . $snippet;
        };
        header('Content-Type: ' . $bufferContentType . '; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        echo $maxiterInjectHtmlStatic($content);
        return true;
    }
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $projectRoot . DIRECTORY_SEPARATOR . 'index.php';

$routePath = trim($requestPath, '/');

if ($routePath !== '') {
    $_GET['url'] = $routePath;
} else {
    unset($_GET['url']);
}

$maxiterInjectHtml = function ($buffer) use ($lrEnabled, $lrPort) {
    if ($lrEnabled !== true || stripos($buffer, '<html') === false) {
        return $buffer;
    }
    $tagPort = 'window.__MAXITER_LIVE_RELOAD_PORT__';
    $tagLoaded = '__MAXITER_LIVE_RELOAD_LOADED__';
    $tagSrc = '/__maxiter_live_reload.js';
    if (stripos($buffer, $tagPort) !== false || stripos($buffer, $tagLoaded) !== false || stripos($buffer, $tagSrc) !== false) {
        return $buffer;
    }
    $portSnippet = '';
    if ($lrPort !== false) {
        $portSnippet = '<script>' . $tagPort . ' = ' . $lrPort . ';</script>';
    }
    $snippet = $portSnippet . '<script async src="/__maxiter_live_reload.js?v=' . time() . '"></script>';
    $pos = stripos($buffer, '</body>');
    if ($pos !== false) {
        return substr($buffer, 0, $pos) . $snippet . substr($buffer, $pos);
    }
    $pos = stripos($buffer, '</head>');
    if ($pos !== false) {
        return substr($buffer, 0, $pos) . $snippet . substr($buffer, $pos);
    }
    return $buffer . $snippet;
};

$maxiterContentType = '';
if (function_exists('headers_list')) {
    foreach (headers_list() as $h) {
        if (stripos($h, 'Content-Type:') === 0) {
            $maxiterContentType = trim(substr($h, strlen('Content-Type:')));
        }
    }
}

if ($lrEnabled) {
    ob_start();
    register_shutdown_function(function () use ($maxiterInjectHtml, &$maxiterContentType) {
        while (ob_get_level() > 0) {
            $buf = @ob_get_clean();
            if ($buf === false || $buf === '') continue;
            if (function_exists('headers_list')) {
                foreach (headers_list() as $h) {
                    if (stripos($h, 'Content-Type:') === 0) {
                        $maxiterContentType = trim(substr($h, strlen('Content-Type:')));
                    }
                }
            }
            $isHtml = (stripos($maxiterContentType, 'text/html') !== false)
                || ($maxiterContentType === '' && (stripos($buf, '<!doctype') !== false || stripos($buf, '<html') !== false));
            echo $isHtml ? $maxiterInjectHtml($buf) : $buf;
        }
    });
}

require $projectRoot . DIRECTORY_SEPARATOR . 'index.php';
