<?php
$powerGeneratedMonth = array();
$powerGeneratedDays = array();


$days = cal_days_in_month(CAL_GREGORIAN, 10, 2020);//days in curent month

$sunRise = date_sunrise(time(), SUNFUNCS_RET_DOUBLE, 55.9, -3.1, 47, 0);//time sun rises
$sunSet = date_sunset(time(), SUNFUNCS_RET_DOUBLE, 55.9, -3.1, 47, 0);//time sun sets


//hours
for ($hours = 0; $hours <= 23; $hours++) {

    if ($hours > $sunRise && $hours < $sunSet) {
        echo "test1";
        $powerGeneratedDays[$hours] = ($powerGeneratedDays[$hours] = +(rand(1, 2) * $hours));
        if ($hours < 10) {
            echo "test2";
            $powerGeneratedDays[$hours] = ($powerGeneratedDays[$hours] = +(rand(1, 2) * $hours));
        } else if ($hours > 11 && $hours < 13) {
            echo "test2";
            $powerGeneratedDays[$hours] = ($powerGeneratedDays[$hours] = +(rand(1, 3) * $hours));
        } else if ($hours > 14) {
            echo "test3";
            $powerGeneratedDays[$hours] = ($powerGeneratedDays[$hours] = +(rand(1, 2) * $hours));
        } else {
            $powerGeneratedDays[$hours] = 0;
            $hours++;
        }
    }
}
echo($sunRise);
echo($sunSet);
print_r($powerGeneratedDays);

?>
