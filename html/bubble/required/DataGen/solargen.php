+<?php
require "../config.php";
global $db;

function cal_days_in_year($Y){
    $d=0; 
    for($m=1;$m<=12;$m++){ $d = $d + cal_days_in_month(CAL_GREGORIAN,$m,$Y); }
    return intval($d*8);
}

function inti_seasons($Y) {
    $sum_winter=0;
    $sum_spring=0;
    $sum_summer=0;
    $sum_fall=0;
    for ($m = 1; $m <= 12; $m++) {
        $d = cal_days_in_month(CAL_GREGORIAN, $m, $Y);
        if ($m < 3 || $m == 12) {$sum_winter = $sum_winter + $d;}   //$m=12|1|2
        elseif ($m < 6) {$sum_spring = $sum_spring + $d;}   //$m=3|4|5
        elseif ($m < 9) {$sum_summer = $sum_summer + $d;}   //$m=6|7|8
        else {$sum_fall = $sum_fall + $d;}  //$m=9|10|11
    }
    return array($sum_winter, $sum_spring, $sum_summer, $sum_fall);
}

function daily_inc($case, $S) {
    $sum_total=0;
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

function daily_calc($case, $S, $I, $P, $Y, $hub_id) {
    $inc = $I; //total inc for the season
    $sum = $S[$case]; //sum of days in season
    $mid = round(($sum/2),0); //nth day = total days / 2
    $previous_max_days=0; //sum of previous moths days
	$even=$sum % 2 == 0;
	$watts_sum=0;

    switch ($case) {
        case 0:
            $m=12;
			$pointer=$mid; //warm to cold - cooling
			$x=-1; //decrument initially
            break;
        case 1:
            $m=3;
			$pointer=1; //cold to warm - warming
			$x=1; //incrument initially
            break;
        case 2:
            $m=6;
            $pointer=1; //warm to hot - warming
			$x=1; //incrument initially
            break;
        case 3:
            $m=9;
            $pointer=$mid; //hot to warm - cooling
			$x=-1; //decrument initially
            break;
        default:
            echo "Invalid Season.";
        }

	$max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
	
	for ($d=1; $d <= $sum; $d++) {
		$dim = $d-$previous_max_days;	//days into month
		
		if ($dim > $max_days) {
			$previous_max_days=$previous_max_days+$max_days;
			if ($m==12){$m=1;}
			else{$m++;}
			$max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
			$dim = 1;
			$watts_sum=0;
		}

		if ($d == $mid) {
			$x=$x*(-1);
			if (!$even) {$pointer=$pointer+$x;}
		}
		else {$pointer=$pointer+$x;}
		$percentage=$pointer*$inc/100;
		$watts=$percentage*$P;
		$watts_sum=$watts_sum+$watts;
		if (intval(date('m'))==$m && intval(date('d'))==$dim){ 
			hourly_calc($case, $percentage, $P, $dim, $m, $hub_id); 
			break;
		}		
    }
}

function hourly_calc($case, $percentage, $P, $d, $m, $hub_id) {
    switch ($case) {
        case 0:
            $rise=8;
            $set=16;
            break;
        case 1:
            $rise=7;
            $set=19;
            break;
        case 2:
            $rise=6;
            $set=20;
            break;
        case 3:
            $rise=7;
            $set=19;
            break;
        default:
            echo "Invalid Season.";
    }
    //from rise to set, allocate percentage
    $daylight_hours = ($set-$rise);
    
    if (is_float($peak=$daylight_hours/2)) {$peak=round($daylight_hours/2, 0);$repeat=true;}
    else{$peak=(round($daylight_hours/2, 0)+1);$repeat=false;}
    echo "$peak peak <br>";
    for ($i=0; $i <= $peak; $i++) {
        if ($repeat && $i=$peak){$S = $S + ($i*2);}
        else{$S = $S + $i;}
    }
    if ($repeat) {
        $sum=2*$S;
        $qV = ($percentage)/($sum);
    }
    else {
        $sum=(2*$S)-$peak;
        $qV = ($percentage)/($sum);
    }
    $S=0;$i=0;$N=0;
    for ($h=0; $h <= 23; $h++) {
        //INSERT INTO TABLE
        
        if ($h>=$rise && $h<=$set) {
            if ($i < $peak) {$N++;$i++;}
            elseif ($repeat){$repeat=false;}
            else {$N--;}
            $watts = $N * $qV * $P;
            echo "$watts = $N * $qV * $P <br>";
        }
        else {
            $watts = 0;
        }
        
		if ($h == (intval(date('H'))+1)){ 
			echo "| * $N  * | ";
            echo "hour[ $h ]::";
            echo "$watts <br>";
            $inst_hourly_gen = $db->prepare("INSERT INTO hourly_gen (hub_id, entry_month, entry_day, entry_hour, energy_gen) VALUES (?, ?, ?, ?, ?)");
            $inst_hourly_gen->bind_param("iiiid", $hub_id, $m, $d, $h, $watts);
            $inst_hourly_gen->execute();
            $stmt13 = $db->prepare("SELECT * FROM hourly_gen WHERE hub_id = ?");
            $stmt13->bind_param("i", $hub_id);
            $stmt13->execute();
            $result13 = $stmt13->get_result();
            $num_row13 = $result13->num_rows;
            if ($num_row13 >= 24) {
                $all13 = $result13->fetch_all(MYSQLI_ASSOC);
                foreach($all13 as $row13){
                    $num_row13 = $num_row13 - 1;
                    if ($num_row13 >= 24) {
                        $stmt14 = $db->prepare("DELETE FROM hourly_gen WHERE entry_id = ?");
                        $stmt14->bind_param("i", $row13['entry_id']);
                        $stmt14->execute();
                    }
                }
            }
		}
    }
    
}

$Y=intval(date('Y'));//INT::Year
$diy=cal_days_in_year($Y);
$S=inti_seasons($Y);//Array::Sum of number of days per season
$inc = array();//Array::Seasonal incruments
$m=intval(date('m'));
if ($m < 3 || $m == 12) {$i=0;}   //$m=12|1|2
elseif ($m < 6) {$i=1;}   //$m=3|4|5
elseif ($m < 9) {$i=2;}   //$m=6|7|8
else {$i=3;}  //$m=9|10|11
$inc = daily_inc($i, $S);

$hub_cost = $db->prepare("SELECT * FROM hub_cost");
$hub_cost->execute();
$hub_cost_data = $hub_cost->get_result();

if ($hub_cost_data->num_rows >= 1) {
    $data = $hub_cost_data->fetch_all(MYSQLI_ASSOC);
    foreach($data as $row){
        $P=intval($row['solargen'])*$diy;
		$hub_id=intval($row['hub_id']);
		daily_calc($i, $S, $inc, $P, $Y, $hub_id);
	}
}
?>