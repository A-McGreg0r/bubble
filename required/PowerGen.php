<?php
$powerGeneratedMonth = array();
$powerGeneratedDays = array();
$generated = 0;


$days = cal_days_in_month(CAL_GREGORIAN, date(t));//days in curent month

$sunRise = date_sunrise(time(), SUNFUNCS_RET_STRING, 38.4, -9, 90, 1);//time sun rises
$sunSet = date_sunset(time(), SUNFUNCS_RET_STRING, 38.4, -9, 90, 1);//time sun sets


//hours
for ($hours = 0; $hours <= 24; $hours++) {
    if ($hours > $sunRise && $hours < $sunSet) {

        if ($hours < 12) {
            $val = +(rand(1, 2) * $hours);
        }
        if ($hours == 12) {
            $val = +(rand(1, 3) * $hours);
        }
        if ($hours > 12) {
            $val = +(rand(1, 2) * $hours);
        }
        $generated = +$val;

    } else {
        $generated = 0;
    }
    array_push($powerGeneratedDays, array($generated));//an array of all generated power

}

?>
