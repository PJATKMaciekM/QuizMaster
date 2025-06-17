<?php
function logMessage($message, $level = 'INFO') {
    $logDir = __DIR__ . '/../logs';
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $logFile = $logDir . '/site.log';
    $timestamp = date("Y-m-d H:i:s");
    $entry = "[$timestamp][$level] $message" . PHP_EOL;

    file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
}
?>