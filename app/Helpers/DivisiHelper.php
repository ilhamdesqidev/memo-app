<?php

if (!function_exists('getInitials')) {
    function getInitials($string) {
        $words = explode(' ', $string);
        $initials = '';
        
        foreach ($words as $word) {
            // Ambil huruf pertama dari setiap kata
            $initials .= strtoupper(substr($word, 0, 1));
        }
        
        return $initials;
    }
}