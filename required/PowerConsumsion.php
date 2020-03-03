<?php
$powerGeneratedMonth = array();
$powerGeneratedDays = array();
$generated = 0;


$days = cal_days_in_month(CAL_GREGORIAN, date(t));//days in curent month

$sunRise = date_sunrise(time(), SUNFUNCS_RET_STRING, 38.4, -9, 90, 1);//time sun rises
$sunSet = date_sunset(time(), SUNFUNCS_RET_STRING, 38.4, -9, 90, 1);//time sun sets


//hours
for ($hours = 0; $hours <= 24; $hours++) {
    //mins

    if ($hours > $sunRise && $hours < $sunSet) {
        $generated = +rand(0, 10);
    } else {
        $generated = 0;
    }
    array_push($powerGeneratedDays, array($generated));//an array of all generated power

}

?>
