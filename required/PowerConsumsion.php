<?php

$powerConsumed = array();

//hours
for ($x = 0; $x <= 24; $x++) {
    //mins
    for ($y = 0; $y <= 60; $y++) {
        //do power consumsion .
        if ($x < 3) {
            $powerConsumed = -rand(0, 2);
        }
        if ($x > 3 && $x < 6) {
            $powerConsumed = +rand(0, 2);
        }
        if ($x > 6 && $x < 12) {
            $powerConsumed = +rand(2, 5);
        }
        if ($x > 12 && $x < 16) {
            $powerConsumed = -rand(2, 3);
        }
        if ($x > 16 && $x < 20) {
            $powerConsumed = +rand(2, 5);
        }
        if ($x > 20 && $x <= 24) {
            $powerConsumed = +rand(2, 5);
        }

    }
}