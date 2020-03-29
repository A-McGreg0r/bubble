<?php
echo "Starting \n";
//http://sandbox.onlinephpfunctions.com/code/d078a008a274c3d0a8ca40ff897dc7457c929e72
generatesConsumptionData(5,800,1700,100,250);

function generatesConsumptionData($workingDays,$workStart, $workEnd, $travelTime,$maxConsumption) {
    echo "Func Called \n";
    $daysInWeek=7;//number of days in the week
    $dayCount=1;//start point for days in week

    $hoursInDay=2400;//number of hours in a day
    $sleepingHoursStart=2200;
    $sleepingHoursEnd=600;
    $weeklyData=array($daylayData=array());
    $consumed=0;

    while($dayCount <=$daysInWeek){
        $TimeOfDay=100;//start point of hours loop
        while($dayCount<=$workingDays){
            echo "\n Working-Day :$dayCount \n";
            $TimeOfDay=100;//start point of hours loop
            $dayCount++;

            while ($TimeOfDay <= $hoursInDay){
                if($TimeOfDay==$workStart){echo"\nStartingWork\n";}

                if($TimeOfDay > $workStart-$travelTime && $TimeOfDay < $workEnd+$travelTime){
                    $consumed =$consumed+lowConsumption($maxConsumption);
                    echo "\tWorking-Hour: $TimeOfDay\tPowerCounsumed: $consumed\n";

                    //bug
                }else if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd){
                    $consumed =$consumed+highConsumption($maxConsumption);
                    echo "\tHOME-Hour: $TimeOfDay\t\tPowerCounsumed: $consumed\n";
                }else{
                    $consumed =$consumed+lowConsumption($maxConsumption);
                    echo "\tSlepping-Hour: $TimeOfDay\tPowerCounsumed: $consumed\n";
                }

                $TimeOfDay=+$TimeOfDay+100;
            }
            $consumed=0;
        }
        while($dayCount <= $daysInWeek){
            echo "WeekendDay :$dayCount\n";
            $TimeOfDay=100;//start point of hours loop
            while ($TimeOfDay < $hoursInDay){

                $TimeOfDay=+$TimeOfDay+100;
                if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd){
                    $consumed =$consumed+highConsumption($maxConsumption);
                    echo "\tHOME-Hour: $TimeOfDay\t\tPowerCounsumed: $consumed\n";
                }else{
                    $consumed =$consumed+lowConsumption($maxConsumption);
                    echo "\tSlepping-Hour: $TimeOfDay\tPowerCounsumed: $consumed\n";
                }
            }
            $dayCount++;
        }
    }

}


function highConsumption($highConsumption){
    return rand($highConsumption,($highConsumption/3)*2);
}
function lowConsumption($lowConsumption){
    return rand(0,$lowConsumption/2);
}