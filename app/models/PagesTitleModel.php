<?php
/*
PagesTitleModel let you be able to set different <title> tag for your pages.
Set it using PagesTitleModel::title("Your title") in any view page to use it!

@author Victor Béser
*/

class PagesTitleModel {

    private static $title;

    public static function title($string) {
        self::$title = $string;
    }

    public static function getTitle() {
        return self::$title;
    }
}

