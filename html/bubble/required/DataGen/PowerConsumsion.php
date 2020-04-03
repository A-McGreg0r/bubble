<?php
echo "Starting \n";
global $db;

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

generatesConsumptionData($maxConsumption);
echo "func Called";
function generatesConsumptionData($maxConsumption){
    echo "Starting DataGen";
    $day=1;
    $month=1;
    $year=2019;
    $maxMonths=12;
    $dayCount = 1;//start point for days in week

    if ($maxConsumption == 0) {
        $maxConsumption = 250;
    }//back up gor dataGeanaration

    $hoursInDay = 24;//number of hours in a day
    $sleepingHoursStart = 22;
    $sleepingHoursEnd = 6;

    $workStart = 7;
    $workEnd = 17;
    $travelTime=1;
    $dayData=array();
    $monthData=array();

    while($year<=2020)
    {   //echo"\n$year :\t";
        while($month<=$maxMonths){
            $Name = date("M", mktime(0,0,0,$month,$day,$year));
            //echo"\n$month :$Name\n";
            $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
            //dayloop
            $MonthTotal=0;
            while($day <= $d){
                $Name = date("D", mktime(0,0,0,$month,$day,$year));
                //echo "\n$month\t$day :$Name\t\n";

                if($Name=="Mon"||$Name=="Tue"||$Name=="Wed"||$Name=="Thu"||$Name=="Fri"){
                    $passer =array_sum(GenWeekDay($maxConsumption, $dayCount, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd,$day));
                    array_push($dayData,$passer);
                }else if($Name =="Sat"||$Name=="Sun"){
                    $passer = array_sum(GenWeekEndDay($maxConsumption, $dayCount, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay,$day));
                    array_push($dayData,$passer);
                }else{echo"somthing has gone wrong";}

                array_push($monthData,array_sum($dayData));
                $dayArrayPointer=$day-1;
                $ArrayVal = $dayData[$dayArrayPointer];
                $MonthTotal = $MonthTotal + $ArrayVal;

                $stmt2 = $db->prepare("INSERT INTO daily_data (hub_id, entry_day, entry_hour, energy_usage) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("iiii", 1, $month, $day, $ArrayVal);
                $stmt2->execute();
                $stmt2->close();
                ///echo "$month\t$day\t$ArrayVal\n";//push to array day data
                $day++;
            }
            $stmt3 = $db->prepare("INSERT INTO monthly_data (hub_id, entry_day, entry_hour, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("iiii", 1, $year, $month, $MonthTotal);
            $stmt3->execute();
            $stmt3->close();
            echo "$year\t$month\t $MonthTotal\n\n";

            unset($dayData);
            $dayData=array();
            $day=1;
            $month++;

        }

        $maxMonths=3;
        $month=1;
        $year++;

    }
    echo "Ending DataGen";
}




//genscripts


function GenWeekDay($maxConsumption, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd,$day)
{
    $data = array();
    $consumed = 0;
    $workingHours = $workEnd - $workStart;
    $hoursInDay = 24;
    $TimeOfDay=1;

    while ($TimeOfDay <= $hoursInDay) {

        if ($TimeOfDay > $workStart - $travelTime && $TimeOfDay < $workEnd + $travelTime) {
            $consumed = lowConsumption($maxConsumption);
            echo "$day\t$TimeOfDay\t$consumed\n";
            array_push($data, $consumed);


        } else if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd) {

            $consumed = $consumed + highConsumption($maxConsumption);
            echo "$day\t$TimeOfDay\t$consumed\n";//push to array hour data
            array_push($data, $consumed);
        } else {
            $consumed = lowConsumption($maxConsumption);
            echo "$day\t$TimeOfDay\t$consumed\n";//push to array hour data
            array_push($data, $consumed);
        }

        $TimeOfDay = +$TimeOfDay + 1;

    }
    return $data;
}

function GenWeekEndDay($maxConsumption, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay,$day){
    $consumed = 0;
    $data = array();
    $TimeOfDay = 1;//start point of hours loop
    while ($TimeOfDay < $hoursInDay) {
        $TimeOfDay = +$TimeOfDay + 1;
        if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd) {
            $consumed = highConsumption($maxConsumption);
            echo "$day\t$TimeOfDay\t$consumed\n";//push to array hour data
            array_push($data, $consumed);
        } else {
            $consumed = lowConsumption($maxConsumption);
            echo "$day\t$TimeOfDay\t$consumed\n";//push to array hour data
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

}