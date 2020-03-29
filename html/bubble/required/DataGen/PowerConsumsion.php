<?php
//http://sandbox.onlinephpfunctions.com/code/daf82f88cf7be7bf39c4eaa2b98111ccff8e3977 online tester
echo "Starting \n";
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
                if($TimeOfDay==$workStart){echo"\n StartingWork\n";}

                if($TimeOfDay > $workStart-$travelTime && $TimeOfDay < $workEnd+$travelTime){
                    $consumed =$consumed+lowConsumption($maxConsumption);
                    echo "\t Working-Hour: $TimeOfDay \t PowerCounsumed: $consumed \n";

                    //bug
                }else if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd){
                    $consumed =$consumed+highConsumption($maxConsumption);
                    echo "\t HOME-Hour: $TimeOfDay \t PowerCounsumed: $consumed \n";
                }else{
                    $consumed =$consumed+lowConsumption($maxConsumption);
                    echo "\t Slepping-Hour: $TimeOfDay \t PowerCounsumed: $consumed \n";
                }

                $TimeOfDay=+$TimeOfDay+100;
            }
            $consumed=0;
        }
        while($dayCount <= $daysInWeek){
            echo "WeekendDay :$dayCount\n";
            $TimeOfDay=100;//start point of hours loop
            while ($TimeOfDay <= $hoursInDay){

                $TimeOfDay=+$TimeOfDay+100;
                if ($TimeOfDay < $sleepingHoursStart && $TimeOfDay > $sleepingHoursEnd){
                    $consumed =$consumed+highConsumption($maxConsumption);
                    echo "\t HOME-Hour: $TimeOfDay \t PowerCounsumed: $consumed \n";
                }else{
                    $consumed =$consumed+lowConsumption($maxConsumption);
                    echo "\t Slepping-Hour: $TimeOfDay \t PowerCounsumed: $consumed \n";
                }
            }
            $dayCount++;
        }
    }

}


function highConsumption($highConsumption){
    return rand($highConsumption,$highConsumption/2);
}
function lowConsumption($lowConsumption){
    return rand(0,$lowConsumption/4);
}