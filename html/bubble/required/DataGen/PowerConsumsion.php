<?php








generatesConsumptionData(5,8,17,1,250);


function generatesConsumptionData($workingDays,$workStart, $workEnd, $travelTime,$maxConsumption) {
    $daysInWeek=7;//number of days in the week
    $dayCount=1;//start point for days in week
    $timeOfDay=1;//start point of hours loop
    $hoursInDay=24;//number of hours in a day


    //keeps track of current day
    while($dayCount <=$daysInWeek){

        //calclate working day consumsion
        while($dayCount<=$workingDays){
            //tracks time of day
            while ($timeOfDay <= $hoursInDay){

                if(($workStart-$travelTime) > $timeOfDay && ($workEnd+$travelTime) < $timeOfDay ){
                    lowConsumption($maxConsumption);
                    $dayCount++;
                }else{
                    highConsumption($maxConsumption);
                }
                $dayCount++;
            }
        }
        //calculate non-workingday consumsion
        while($dayCount<=$daysInWeek){
            //tracks time of day
            while ($timeOfDay <= $hoursInDay){

            }

            $dayCount++;
        }

    }
}


function highConsumption($maxConsumption){
    return rand(0,$maxConsumption/2);
}
function lowConsumption($maxConsumption){
    return rand($maxConsumption/2,$maxConsumption);
}