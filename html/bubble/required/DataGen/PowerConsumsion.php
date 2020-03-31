<?php
echo "Starting \n";
global $db;

$maxConsumption = 0;
$energy_usage = 0;

$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($all as $row) {
        $energy_used = 0;
        $maxConsumption = 0;

        $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        $stmt5->bind_param("i", $row['hub_id']);
        $stmt5->execute();
        $result5 = $stmt5->get_result();
        if ($result5->num_rows >= 1) {
            $all5 = $result5->fetch_all(MYSQLI_ASSOC);
            foreach ($all5 as $row5) {

                $stmt4 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                $stmt4->bind_param("i", $row5['device_type']);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                if ($result4->num_rows >= 1) {
                    $all4 = $result4->fetch_all(MYSQLI_ASSOC);
                    foreach ($all4 as $row4) {
                        $maxConsumption = $energy_used + $row4['energy_usage'];
                        $energy_usage = $row4['energy_usage'];
                    }
                }
            }
        }
    }
}
generatesConsumptionData();


function generatesConsumptionData(){
    $day=1;
    $month=1;
    $year=2019;
    $maxMonths=12;
    $daysInWeek = 7;//number of days in the week
    $dayCount = 1;//start point for days in week

    $maxConsumption=250;

    $hoursInDay = 2400;//number of hours in a day
    $sleepingHoursStart = 2200;
    $sleepingHoursEnd = 600;

    $workStart = 700;
    $workEnd = 1700;
    $travelTime=100;
    $dayData=array();
    $monthData=array();

    while($year<=2020)
    {   echo"\n$year :\t";
        while($month<=$maxMonths){
            $Name = date("M", mktime(0,0,0,$month,$day,$year));
            echo"\n$month :$Name\n";
            $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
            //dayloop
            while($day <= $d){
                $Name = date("D", mktime(0,0,0,$month,$day,$year));
                echo "\n$day :$Name\t";

                if($Name=="Mon"||$Name=="Tue"||$Name=="Wed"||$Name=="Thu"||$Name=="Fri"){
                    echo "Weekday";
                    array_push($dayData,array_sum(GenWeekDay($maxConsumption, $dayCount, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd)));
                }else if($Name =="Sat"||$Name=="Sun"){
                    echo "weekend";
                    array_push($dayData,array_sum(GenWeekEndDay($maxConsumption, $dayCount, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay)));
                }else{echo"somthing has gone wrong";}
                $day++;
            }
            array_push($monthData,array_sum($dayData));
            $day=1;
            $month++;
        }
        $maxMonths=3;
        $month=1;
        $year++;
    }
}



//genscripts


function GenWeekDay($maxConsumption, $dayCount, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd)
{
    echo "\nWorking-Day :$dayCount \n";
    $data = array();
    $consumed = 0;
    $workingHours = $workEnd - $workStart;
    $hoursInDay = 2400;
    $TimeOfDay=100;

    while ($TimeOfDay <= $hoursInDay) {

        if ($TimeOfDay > $workStart - $travelTime && $TimeOfDay < $workEnd + $travelTime) {
            $consumed = lowConsumption($maxConsumption);
            echo "\tWorking-Hour: $TimeOfDay\tPowerCounsumed: $consumed\n";
            array_push($data, $consumed);


        } else if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd) {

            $consumed = $consumed + highConsumption($maxConsumption);
            echo "\tHOME-Hour: $TimeOfDay\t\tPowerCounsumed: $consumed\n";
            array_push($data, $consumed);
        } else {
            $consumed = lowConsumption($maxConsumption);
            echo "\tSlepping-Hour: $TimeOfDay\tPowerCounsumed: $consumed\n";
            array_push($data, $consumed);
        }

        $TimeOfDay = +$TimeOfDay + 100;

    }
    return $data;
}

function GenWeekEndDay($maxConsumption, $dayCount, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay){
    $consumed = 0;
    $data = array();
    echo "WeekendDay :$dayCount\n";
    $TimeOfDay = 100;//start point of hours loop
    while ($TimeOfDay < $hoursInDay) {
        $TimeOfDay = +$TimeOfDay + 100;
        if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd) {
            $consumed = highConsumption($maxConsumption);
            echo "\tHOME-Hour: $TimeOfDay\t\tPowerCounsumed: $consumed\n";
            array_push($data, $consumed);
        } else {
            $consumed = lowConsumption($maxConsumption);
            echo "\tSlepping-Hour: $TimeOfDay\tPowerCounsumed: $consumed\n";
            array_push($data, $consumed);
        }
    }
    return $data;
    //post to DB
}

function highConsumption($maxConsumption)
{
    $energy_used = 0;
    $energy_usage = 0;

    $numerator = rand(2, 10);
    $denominator = rand(3, 10);
    while ($numerator > $denominator) {
        $numerator = rand(2, 10);
        $denominator = rand(3, 10);
    }

    $idle_energy = rand(0, $maxConsumption / 3);
    $energy_usage = $energy_usage / $denominator * $numerator;
    $energy_used = $energy_used + $idle_energy;
    return $energy_used;
}

function lowConsumption($maxConsumption)
{
    $energy_used = rand(0, $maxConsumption / 3);
    return $energy_used;
}