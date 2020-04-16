<?php
echo "Starting \n";
require "../config.php";

function _main($Y, $anual_power_gen) {
	
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

    function daily_calc($case, $S, $I, $P, $Y) {
        $inc = $I[$case]; //total inc for the season
        $sum = $S[$case]; //sum of days in season
        $mid = round(($sum/2),0); //nth day = total days / 2
        $previous_max_days=0; //sum of previous moths days
		$even=$sum % 2 == 0;
		$watts_sum=0;

		global $db;
		$inst_monthly_gen = $db->prepare("INSERT INTO monthly_gen (entry_id, hub_id, entry_year, entry_month, energy_gen) VALUES (?, ?, ?, ?, ?)");
		$inst_monthly_gen->bind_param("iiiid", $default, $hub_id, $Y, $m, $watts_sum);
		
		$inst_daily_gen = $db->prepare("INSERT INTO daily_gen (entry_id, hub_id, entry_month, entry_day, energy_gen) VALUES (?, ?, ?, ?, ?)");
		$inst_daily_gen->bind_param("iiiid", $default, $hub_id, $m, $d, $watts);
		
		$hub_id=1;

        switch ($case) {
            case 0:
                $m=12;
				$pointer=$mid; //warm to cold - cooling
				$x=-1; //decrument initially
                echo "winter<br>";
                break;
            case 1:
                $m=3;
				$pointer=1; //cold to warm - warming
				$x=1; //incrument initially
                echo "<br>spring<br>";
                break;
            case 2:
                $m=6;
                $pointer=1; //warm to hot - warming
				$x=1; //incrument initially
                echo "<br>summer<br>";
                break;
            case 3:
                $m=9;
                $pointer=$mid; //hot to warm - cooling
				$x=-1; //decrument initially
                echo "<br>fall<br>";
                break;
            default:
                echo "Invalid Season.";
            }

		$max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
		
		for ($d=1; $d <= $sum; $d++) {
			$dim = $d-$previous_max_days;	//days into month
			
			if ($dim > $max_days) {
				$inst_monthly_gen->execute();
				$previous_max_days=$previous_max_days+$max_days;
				if ($m==12){$m=1;}
				else{$m++;}
				$max_days=cal_days_in_month(CAL_GREGORIAN, $m, $Y);
				$dim = 1;
				$watts_sum=0;
			}
			
			echo "day[ $d ] :: ";

			if ($d == $mid) {
				$x=$x*(-1);
				if (!$even) {$pointer=$pointer+$x;}
			}
			else {$pointer=$pointer+$x;}
			$percentage=$pointer*$inc/100;
			$watts=$percentage*$P;
            echo "$watts <br>";
			$watts_sum=$watts_sum+$watts;
			$inst_daily_gen->execute();
			hourly_calc($case, $percentage, $P, $dim, $m);			

        }
		$inst_monthly_gen->execute();
    }

    function hourly_calc($case, $percentage, $P, $d, $m) {
        $S=0;
        switch ($case) {
            case 0:
                //Winter
                //Daylight hours::9
                //8-5
                $rise=8;
                $set=16;
                break;
            case 1:
                //Spring
                //Daylight hours::12
                //7-9
                $rise=7;
                $set=21;
                break;
            case 2:
                //Summer
                //Daylight hours::14
                //6-9 nice
                $rise=6;
                $set=22;
                break;
            case 3:
                //Fall
                //Daylight hours::12
                //7-8
                $rise=7;
                $set=21;
                break;
            default:
                echo "Invalid Season.";
        }
        //from rise to set, allocate percentage
        $daylight_hours = ($set-$rise);
        //$midday = $rise + ($daylight_hours/2);
        //if (is_float(//$midday)){//$midday=round(//$midday,0)-1;}
        //echo $daylight_hours;echo " DLH<br>";

        if (is_float($peak=$daylight_hours/2)) {$peak=round($daylight_hours/2, 0);$repeat=true;}
        else{$peak=(round($daylight_hours/2, 0)+1);$repeat=false;}
        $barlength=50;
        //echo $peak;echo " PEAK<br>";
        for ($i=0; $i <= $barlength; $i++) {echo '-';}
        echo "<br>";
        $watts_sum=0;
        $N=0;
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
        
        global $db;
		$inst_hourly_gen = $db->prepare("INSERT INTO hourly_gen (entry_id, hub_id, entry_month, entry_day, entry_hour, energy_gen) VALUES (?, ?, ?, ?, ?, ?)");
		$inst_hourly_gen->bind_param("iiiiid", $default, $hub_id, $m, $d, $h, $watts);
		$hub_id=1;
        for ($h=$rise; $h <= $set; $h++) {
            //INSERT INTO TABLE
            $i=$h-$rise;
            if ($i < $peak) {$N++;}
            elseif ($repeat){$repeat=false;}
            else {$N--;}
            $watts = $N * $qV * $P;
            $watts_sum = $watts_sum + $watts;
            echo "| * $N * | ";
            echo "hour[ $h ]::";
            echo $watts;echo "<br>";
			$inst_hourly_gen->execute();
        }

        for ($i=0; $i <= $barlength; $i++) {echo '-';}
        echo "<br>";
        echo round($watts_sum, 2);echo ":: $d day into month<br><br>";
        
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

//_main(intval(2019), 2500000.0)
?>
