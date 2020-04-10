<?php
echo "Starting \n";

require "../config.php";
global $db;

global $db;
echo "Starting ";
echo "Quarrying hub info";
$maxConsumption = 0;
$energy_usage = 0;

$stmt = $db->prepare("SELECT * FROM hub_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {
    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($all as $row) {
        $maxConsumption = 0;

        $stmt5 = $db->prepare("SELECT * FROM device_info WHERE hub_id = ?");
        echo "Quarrying device info";
        $stmt5->bind_param("i", $row['1']);
        $stmt5->execute();
        $result5 = $stmt5->get_result();
        echo "collected device info";
        if ($result5->num_rows >= 1) {
            $all5 = $result5->fetch_all(MYSQLI_ASSOC);

            foreach ($all5 as $row5) {
                $stmt4 = $db->prepare("SELECT * FROM device_types WHERE type_id = ?");
                echo "getting device consumption ";
                $stmt4->bind_param("i", $row5['device_type']);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                if ($result4->num_rows >= 1) {
                    $all4 = $result4->fetch_all(MYSQLI_ASSOC);
                    foreach ($all4 as $row4) {
                        $maxConsumption = $maxConsumption + $row4['energy_usage'];
                    }
                }
            }
        }
    }
}
generatesConsumptionData($maxConsumption, $db);

function generatesConsumptionData($maxConsumption, $postTo){
    echo "Starting DataGen\n";
    $day=1;
    $month=1;
    $year=2019;
    $maxMonths=12;

    if ($maxConsumption == 0) {
        $maxConsumption = 250;
    }//back up gor dataGeneration

    $hoursInDay = 24;//number of hours in a day
    $sleepingHoursStart = 22;
    $sleepingHoursEnd = 6;

    $workStart = 7;
    $workEnd = 17;
    $travelTime=1;
    $dayData=array();
    $monthData=array();
    $hub_id = 1;

    while($year<=2020)
    {
        while($month<=$maxMonths){
            $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
            //dayLoop
            $MonthTotal=0;
            while($day <= $d){
                $Name = date("D", mktime(0,0,0,$month,$day,$year));

                if($Name=="Mon"||$Name=="Tue"||$Name=="Wed"||$Name=="Thu"||$Name=="Fri"){
                    $passer =array_sum(GenWeekDay($maxConsumption, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd,$day));
                    array_push($dayData,$passer);
                }else if($Name =="Sat"||$Name=="Sun"){
                    $passer = array_sum(GenWeekEndDay($maxConsumption, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay,$day));
                    array_push($dayData,$passer);
                }else{echo"something has gone wrong";}

                array_push($monthData,array_sum($dayData));
                $dayArrayPointer=$day-1;
                $ArrayVal = $dayData[$dayArrayPointer];
                $MonthTotal = $MonthTotal + $ArrayVal;

                $stmt2 = $postTo->prepare("INSERT INTO daily_data (hub_id, entry_month, entry_day, energy_usage) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("iiid", $hub_id, $month, $day, $ArrayVal);
                $stmt2->execute();
                $stmt2->close();
                $day++;
            }
            $stmt3 = $postTo->prepare("INSERT INTO monthly_data (hub_id, entry_year, entry_month, energy_usage) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("iiid", $hub_id, $year, $month, $MonthTotal);
            $stmt3->execute();
            $stmt3->close();

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

//genScripts
function GenWeekDay($maxConsumption, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd,$day)
{
    $data = array();
    $consumed = 0;

    $hoursInDay = 24;
    $TimeOfDay=1;

    while ($TimeOfDay <= $hoursInDay) {

        if ($TimeOfDay > $workStart - $travelTime && $TimeOfDay < $workEnd + $travelTime) {
            $consumed = lowConsumption($maxConsumption);
            array_push($data, $consumed);

        } else if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd) {
            $consumed = $consumed + highConsumption($maxConsumption);
            array_push($data, $consumed);

        } else {
            $consumed = lowConsumption($maxConsumption);
            array_push($data, $consumed);

        }
        $TimeOfDay = +$TimeOfDay + 1;

    }
    return $data;
}

function GenWeekEndDay($maxConsumption, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay,$day){
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
}

function highConsumption($maxConsumption)
{
    $energy_used = 0;
    $energy_usage = 0;

    $numerator = rand(2,10);
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
    return rand(0, $maxConsumption / 3);
}