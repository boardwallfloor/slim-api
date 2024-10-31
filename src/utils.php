<?php

function logEvent($message)
{
    $filePath = 'event_log.txt';

    if (is_array($message)) {
        $message = json_encode($message, JSON_PRETTY_PRINT);
    }

    $logEntry = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;

    file_put_contents($filePath, $logEntry, FILE_APPEND | LOCK_EX);
}

function isValidKTP($ktp, $dob, $sex)
{
    if (!$dob || !$sex || strlen($ktp) < 12) {
        return false;
    }

    $day = (int)substr($ktp, 6, 2);
    $month = (int)substr($ktp, 8, 2);
    $year = (int)substr($ktp, 10, 2);

    [$dobYear, $dobMonth, $dobDay] = explode('-', $dob);

    if ($sex === 'female') {
        $dobDay = $dobDay + 40;
    }

    return ($day == $dobDay && $month == $dobMonth && $year == (int)substr($dobYear, -2));
}
