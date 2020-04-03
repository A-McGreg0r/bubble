<?php
function _main($Y, $anual_power_gen) {

    function inti_seasons($Y) {
        for ($m = 1; $m <= 12; $m++) {
            $d = cal_days_in_month(CAL_GREGORIAN, $m, $Y);
            if ($m < 3 || $m == 12) {$sum_winter = $sum_winter + $d;}
            elseif ($m < 6) {$sum_spring = $sum_spring + $d;}
            elseif ($m < 9) {$sum_summer = $sum_summer + $d;}
            else {$sum_fall = $sum_fall + $d;}
        }
        return array($sum_winter, $sum_spring, $sum_summer, $sum_fall);
    }

    function daily_inc($case, $S) {
        switch ($case) {
            case 0:
                //Winter
                $percentage = 12.5;
                $sum = $S[0];
                break;
            case 1:
                //Spring
                $percentage = 25.0;
                $sum = $S[1];
                break;
            case 2:
                //Summer
                $percentage = 37.5;
                $sum = $S[2];
                break;
            case 3:
                //Fall
                $percentage = 25.0;
                $sum = $S[3];
                break;
            default:
                echo "Invalid Season.";
        }
        $mid_trunc=round(($sum/2),0);
        for ($i = 1; $i <= $mid_trunc; $i++) {$sum_total = $sum_total + $i;}
        return (($percentage/2) / $sum_total);
    }

    function daily_calc($case, $S, $I, $P, $Y) {
        $inc = $I[$case];
        $sum = $S[$case];
        $mid=round(($sum/2),0);
        $previous_max_days=0;
        switch ($case) {
            case 0:
                $max_days=cal_days_in_month(CAL_GREGORIAN, 12, $Y);
                $m=0;
                echo "winter<br>";
                for ($d=1; $d <= $sum; $d++) {
                    echo "day[";echo $d;echo "]::";
                    $pointer=$mid;
                    if ($d <= $mid) {
                        $percentage = $pointer*$inc/100;
                        $pointer--;
                    }
                    else {$percentage = ($d-$mid)*$inc/100;}
                    $diff = $d-$previous_max_days;
                    if ($diff < $max_days) {
                        //INSERT INTO table VALUES ($d ,$percentage*$P)
                        $watts=$percentage*$P;
                        hourly_calc($case, $percentage, $P, $diff);
                        echo $watts;echo "<br>";
                    }
                    else {
                        $previous_max_days = $d;
                        $m++;
                        $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                        //echo date("m");echo " <br>";
                        $watts=$percentage*$P;
                        hourly_calc($case, $percentage, $P, 1);
                        echo $watts;echo "<br>";
                    }
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                }
                break;
            case 1:
                $m=3;
                $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                echo "<br>spring<br>";
                for ($d=1; $d <= $sum; $d++) {
                    echo "day[";echo $d;echo "]::   ";
                    //echo $d*$inc/100;echo "%    ";

                    //echo $percentage;echo "%    "
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                    $diff = $d-$previous_max_days;
                    if ($diff < $max_days) {
                        //INSERT INTO table VALUES ( ($d-$previous_max_days) ,$percentage*$P)
                        $watts = round($percentage*$P, 2);
                        hourly_calc($case, $percentage, $P, $diff);
                        echo $watts;echo "<br>";
                    }
                    else {
                        $previous_max_days = $d;
                        $m++;
                        $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                        //echo date("m");echo " <br>";
                        $watts = round($percentage*$P, 2);
                        hourly_calc($case, $percentage, $P, 1);
                        echo $watts;echo "<br>";
                    }
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                }
                break;
            case 2:
                $m=6;
                $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                $pointer=$mid;
                echo "<br>summer<br>";
                for ($d=1; $d <= $sum; $d++) {
                    echo "day[";echo $d;echo "]::";
                    if ($d > $mid) {
                        $percentage = $pointer*$inc/100;
                        $pointer--;
                    }
                    else {$percentage = $d*$inc/100;}
                    //echo $percentage;echo "%    "
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                    $diff = $d-$previous_max_days;
                    if ($diff < $max_days) {
                        //INSERT INTO table VALUES ( ($d-$previous_max_days) ,$percentage*$P)
                        $watts = round($percentage*$P, 2);
                        hourly_calc($case, $percentage, $P, $diff);
                        echo $watts;echo "<br>";
                    }
                    else {
                        $previous_max_days = $d;
                        $m++; 
                        $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                        //echo date("m");echo " <br>";
                        $watts = round($percentage*$P, 2);
                        hourly_calc($case, $percentage, $P, 1);
                        echo $watts;echo "<br>";
                    }
                }
                break;
            case 3:
                $m=9;
                $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                $pointer=$sum;
                echo "<br>fall<br>";
                for ($d=1; $d <= $sum; $d++) {
                    echo "day[";echo $d;echo "]::";
                    //echo $pointer*$inc/100;echo "%    ";
                    
                    $pointer--;

                    //echo $percentage;echo "%    "
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                    $diff = $d-$previous_max_days;
                    if ($diff < $max_days) {
                        //INSERT INTO table VALUES ( ($d-$previous_max_days) ,$percentage*$P)
                        $watts = round(($pointer*$inc/100)*$P, 2);
                        echo $watts;echo "<br>";
                        hourly_calc($case, $percentage, $P, $diff);
                    }
                    else {
                        $previous_max_days = $d;
                        $m++;
                        $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                        //echo date("m");echo " <br>";
                        $watts = round(($pointer*$inc/100)*$P, 2);
                        hourly_calc($case, $percentage, $P, 1);
                        echo $watts;echo "<br>";
                    }
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                }
                break;
            default:
                echo "Invalid Season.";
            } 
    }

    function hourly_calc($case, $percentage, $P, $d) {
        $sum=0;
        switch ($case) {
            case 0:
                //Winter
                //Daylight hours::10
                //8-6
                $rise=8;
                $set=18;
                break;
            case 1:
                //Spring
                //Daylight hours::12
                //7-8
                $rise=7;
                $set=20;
                break;
            case 2:
                //Summer
                //Daylight hours::14
                //6-9 nice
                $rise=6;
                $set=21;
                break;
            case 3:
                //Fall
                //Daylight hours::12
                //7-8
                $rise=7;
                $set=20;
                break;
            default:
                echo "Invalid Season.";
        }
        //from rise to set, allocate percentage
        $daylight_hours = ($set-$rise);
        $midday = $rise + ($daylight_hours/2);
        for ($i=1; $i <= ($daylight_hours/2); $i++) {$sum = $sum + $i;}
        $hourly_inc = ($percentage/2)/$sum;
        for ($h=$rise; $h <= $midday; $h++) {
            //INSERT INTO TABLE
            $watts = $hourly_inc * (($h-$rise)+1) * $percentage * $P;
        }
    }
    
    $Y=$Y;//INT::Year
    $P=$anual_power_gen;
    $S=inti_seasons($Y);//Array::Sum of number of days per season
    $inc = array();//Array::Seasonal incruments
    for ($i=0;$i<4;$i++){
        array_push($inc, daily_inc($i, $S));
        daily_calc($i, $S, $inc, $P, $Y);
    }
    
}

_main(intval(date("Y")), 10000000.0)
?>
