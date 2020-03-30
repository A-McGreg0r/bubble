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
generatesConsumptionData(5, 800, 1700, 100, $maxConsumption);

function generatesConsumptionData($workingDays, $workStart, $workEnd, $travelTime, $maxConsumption)
{
    echo "Func Called \n";
    $daysInWeek = 7;//number of days in the week
    $dayCount = 1;//start point for days in week

    $hoursInDay = 2400;//number of hours in a day
    $sleepingHoursStart = 2200;
    $sleepingHoursEnd = 600;
    $weeklyData = array();
    $consumed = 0;

    while ($dayCount <= $daysInWeek) {
        $TimeOfDay = 100;//start point of hours loop
        while ($dayCount <= $workingDays) {
            GenWeekDay($maxConsumption, $dayCount, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd, $TimeOfDay);
            $dayCount++;
        }
        while ($dayCount <= $daysInWeek) {
            GenWeekendDay($maxConsumption, $dayCount, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay);
            $dayCount++;
        }
    }
    //print_r($weeklyData);
}

function GenWeekDay($maxConsumption, $dayCount, $workStart, $workEnd, $travelTime, $sleepingHoursStart, $sleepingHoursEnd, $TimeOfDay)
{
    echo "\nWorking-Day :$dayCount \n";
    $data = array();
    $consumed = 0;
    $workingHours = $workEnd - $workStart;
    $hoursInDay = 2400;
    echo "Working hours: $workingHours \n";
    while ($TimeOfDay <= $hoursInDay) {
        if ($TimeOfDay == $workStart) {
            echo "\nStartingWork\n";
        }

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

function GenWeekendDay($maxConsumption, $dayCount, $sleepingHoursStart, $sleepingHoursEnd, $hoursInDay)
{
    echo "func test\n";
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