<?php
    function bulan($number)
    {
        return date("F", mktime(0, 0, 0, $number, 1));
    }