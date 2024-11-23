<?php
/*
This is the log file, use it statically where you want using LogModel::log("Your log text here")

@author Victor Béser
*/
class LogModel {

    private static $log;
    public static function log($log) {
        $currentDateTime = new DateTime();
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        self::$log = mb_strtoupper($log);

        $query = "INSERT INTO logs (log, created_at) VALUES (:log, :date)";
        $result = DatabaseModel::connection("maxiter")->execute($query, [
            ":log" => self::$log,
            ":date" => $formattedDateTime,
        ]);
    }

}