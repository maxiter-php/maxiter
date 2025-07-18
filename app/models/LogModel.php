<?php
/*
This is the log file, use it statically where you want using LogModel::log("Your log text here")

@author Victor Béser
*/
class LogModel
{

    public static function removeEmojis($text)
    {
        return preg_replace('/[\x{1F600}-\x{1F64F}' . 
            '\x{1F300}-\x{1F5FF}' . 
            '\x{1F680}-\x{1F6FF}' . 
            '\x{1F1E0}-\x{1F1FF}' . 
            '\x{2600}-\x{26FF}' .   
            '\x{2700}-\x{27BF}]++/u', '', $text);
    }

    public static function log($log)
    {
        $currentDateTime = (new DateTime())->format('Y-m-d H:i:s');

        $cleanLog = self::removeEmojis(mb_strtoupper($log));

        $query = "INSERT INTO log (description, created_at) VALUES (:log, :date)";
        return DatabaseModel::connection(EnvModel::env("DB"))->execute($query, [
            ":log" => $cleanLog,
            ":date" => $currentDateTime,
        ]);
    }



}