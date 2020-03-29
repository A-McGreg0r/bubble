<?php








generatesConsumptionData(5,8,17,1);


function generatesConsumptionData($workingDays,$workStart, $workEnd, $travleTime) {

    $dayCount=1;//start point for main loop
    $daysInWeek=7;//endpoint for main loop
    $timeOfDay=1;
    $hoursInDay=24;//number of hurs in a day

    //keeps track of current day
    while($dayCount <=$daysInWeek){

        //calclate working day consumsion
        while($dayCount<=$workingDays){
            //tracks time of day
            while ($timeOfDay <= $hoursInDay){

                if(($workStart-$travleTime) > $timeOfDay && ($workEnd+$travleTime) < $timeOfDay ){
                    lowConsumption($timeOfDay);
                    $dayCount++;
                }else{
                    highConsumption($timeOfDay);
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


function highConsumption($time){
    $consumedPower=0;
    //do math

return $consumedPower;
}
function lowConsumption($time){
    $consumedPower=0;
    //do math
return $consumedPower;

}