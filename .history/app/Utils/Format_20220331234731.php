<?php

    namespace App\Utils;

    trait Format
    {
        public static function generate( array $keys, array $data )
        {
            return [$keys, $data];
        }
    }

?>