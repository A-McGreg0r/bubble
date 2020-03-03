<?php
$powerGeneratedMonth = array();
$powerGeneratedDays = array();
$generated = 0;
$days = cal_days_in_month(CAL_GREGORIAN, date(t));
//hours
for ($i = 0; $days <= $i; $i++) {
    for ($hours = 0; $hours <= 24; $hours++) {
        //mins
        for ($y = 0; $y <= 60; $y++) {
            if ($hours < 3) {
                $generated = -rand(0, 2);
            }

            if ($hours > 3 && $hours < 6) {
                $generated = +rand(0, 2);
            }
            if ($hours > 6 && $hours < 12) {
                $generated = +rand(2, 5);
            }
            if ($hours > 12 && $hours < 16) {
                $generated = -rand(2, 3);
            }
            if ($hours > 16 && $hours < 20) {
                $generated = +rand(2, 5);
            }
            if ($hours > 20 && $hours <= 24) {
                $generated = +rand(2, 5);
            }
            array_push($powerGeneratedDays, array($generated));//an array of all generated power
        }
    }
    array_push($powerGeneratedMonth, array(array_sum($powerGeneratedDays)));//an array of all generated power
    unset($powerGeneratedDays);
}

?>
