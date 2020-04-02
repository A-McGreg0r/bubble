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

    function season_inc($case, $S) {
        switch ($case) {
            case 0:
                $name = 'winter';
                $percentage = 12.5;
                $sum = $S[0];
                echo "$name<br>";
                echo "$percentage<br>";
                echo "$sum<br><br>";
                break;
            case 1:
                $name = 'spring';
                $percentage = 25.0;
                $sum = $S[1];
                echo "$name<br>";
                echo "$percentage<br>";
                echo "$sum<br><br>";
                break;
            case 2:
                $name = 'summer';
                $percentage = 37.5;
                $sum = $S[2];
                echo "$name<br>";
                echo "$percentage<br>";
                echo "$sum<br><br>";
                break;
            case 3:
                $name = 'fall';
                $percentage = 25.0;
                $sum = $S[3];
                echo "$name<br>";
                echo "$percentage<br>";
                echo "$sum<br><br>";    
                break;
            default:
                echo "Invalid Season.";
        }
        $midpoint=round(($sum/2),0);
        for ($i = 1; $i <= $midpoint; $i++) {$sum_total = $sum_total + $i;}
        $inc = $percentage / $sum_total;
        return $inc;
    }
    
    function print_daily_season_inc($case, $S, $I, $P) {
        switch ($case) {
            case 0:
                $inc = $I[0];
                $sum = $S[0];
                $mid=round(($sum/2),0);
                $pointer=$mid;
                for ($d=1; $d <= $sum; $d++) {
                    if ($d <= $mid) {
                        $percentage = $pointer*$inc/100;
                        $pointer--;
                    }
                    else {$percentage = ($d-$mid)*$inc/100;}
                    echo "day [";echo $d;echo "]::";
                    echo $percentage;echo "%    ";
                    echo $percentage*$P;echo " Watts<br>";
                }
                break;
            case 1:
                $inc = $I[1];
                $sum = $S[1];
                for ($d=1; $d <= $sum; $d++) {
                    echo "day [";echo $d;echo "]::";
                    echo $d*$inc/100;echo "%    ";
                    echo round(($d*$inc/100)*$P, 2);echo " Watts<br>";
                }
                break;
            case 2:
                $inc = $I[2];
                $sum = $S[2];
                $mid=round(($sum/2),0);
                $pointer=$mid;
                for ($d=1; $d <= $sum; $d++) {
                    if ($d > $mid) {
                        $percentage = $pointer*$inc/100;
                        $pointer--;
                    }
                    else {$percentage = $d*$inc/100;}
                    echo "day [";echo $d;echo "]::";
                    echo $percentage;echo "%    ";
                    echo $percentage*$P;echo " Watts<br>";
                }
                break;
            case 3:
                $inc = $I[3];
                $sum = $S[3];
                $pointer = $sum;
                for ($d=1; $d <= $sum; $d++) {
                    echo "day [";echo $d;echo "]::";
                    echo $pointer*$inc/100;echo "%    ";
                    echo round(($pointer*$inc/100)*$P, 2);echo " Watts<br>";
                    $pointer--;
                }
                break;
            default:
                echo "Invalid Season.";
            }
    }

    function season_calc($case, $S, $I, $P, $Y) {
        $inc = $I[$case];
        $sum = $S[$case];
        $mid=round(($sum/2),0);
        $previous_max_days=0;
        switch ($case) {
            case 0:
                $max_days=cal_days_in_month(CAL_GREGORIAN, 12, $Y);
                $m=0;
                for ($d=1; $d <= $sum; $d++) {
                    $pointer=$mid;
                    if ($d <= $mid) {
                        $percentage = $pointer*$inc/100;
                        $pointer--;
                    }
                    else {$percentage = ($d-$mid)*$inc/100;}
                    echo "day [";echo $d;echo "]::";
                    //echo $percentage;echo "%    "
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                    $diff = $d-$previous_max_days;
                    if ($diff < $max_days) {
                        //INSERT INTO table VALUES ($d ,$percentage*$P)
                        echo $percentage*$P;echo " W<br>";
                    }
                    else {
                        $previous_max_days = $d;
                        $m++;
                        $max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
                        //echo date("m");echo " <br>";
                        echo $percentage*$P;echo " W<br>";
                    }
                    //INSERT INTO table VALUES ($d ,$percentage*$P)
                }
                break;
            case 1:
                for ($d=1; $d <= $sum; $d++) {
                    echo "day [";echo $d;echo "]::";
                    //echo $d*$inc/100;echo "%    ";
                    echo round(($d*$inc/100)*$P, 2);echo " W<br>";
                }
                break;
            case 2:
                $pointer=$mid;
                for ($d=1; $d <= $sum; $d++) {
                    if ($d > $mid) {
                        $percentage = $pointer*$inc/100;
                        $pointer--;
                    }
                    else {$percentage = $d*$inc/100;}
                    echo "day [";echo $d;echo "]::";
                    //echo $percentage;echo "%    ";
                    echo $percentage*$P;echo " W<br>";
                }
                break;
            case 3:
                $pointer=$sum;
                for ($d=1; $d <= $sum; $d++) {
                    echo "day [";echo $d;echo "]::";
                    //echo $pointer*$inc/100;echo "%    ";
                    echo round(($pointer*$inc/100)*$P, 2);echo " W<br>";
                    $pointer--;
                }
                break;
            default:
                echo "Invalid Season.";
            } 
    }
    
    $Y=$Y;//INT::Year
    $P=$anual_power_gen;
    $S=inti_seasons($Y);//Array::Sum of number of days per season
    $inc = array();//Array::Seasonal incruments
    for ($i=0;$i<4;$i++){
        array_push($inc, season_inc($i, $S));
        season_calc($i, $S, $inc, $P, $Y);
        echo "<br><br>";
    }
    
}

_main(intval(date("Y")), 10000000.0)
?>
