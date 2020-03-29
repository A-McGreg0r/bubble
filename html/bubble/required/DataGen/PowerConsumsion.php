<?php








generatesConsumptionData(5,8,17,1,250);


function generatesConsumptionData($workingDays,$workStart, $workEnd, $travelTime,$maxConsumption) {
    $daysInWeek=7;//number of days in the week
    $dayCount=1;//start point for days in week
    $StartOfDay=1;//start point of hours loop
    $hoursInDay=2400;//number of hours in a day
    $sleepingHoursStart=2200;
    $sleepingHoursEnd=0600;
    $rollingToatl=array();

    //keeps track of current day
    while($dayCount <=$daysInWeek){

        //calclate working day consumsion
        while($dayCount<=$workingDays){
            //tracks time of day
            while ($StartOfDay <= $hoursInDay){

                if(($workStart-$travelTime) > $StartOfDay && ($workEnd+$travelTime) < $StartOfDay ){
                    $consumed =+ lowConsumption($maxConsumption);
                    $rollingToatl.array_push($consumed);
                    $dayCount++;
                }else if ($StartOfDay < $sleepingHoursStart && $StartOfDay > $sleepingHoursEnd){
                    $consumed =+ lowConsumption($maxConsumption);
                    $rollingToatl.array_push($consumed);
                }else{
                    $consumed =+ highConsumption($maxConsumption);
                    $rollingToatl.array_push($rollingToatl,$consumed);
                }
                $dayCount++;
            }
        }
        //calculate non-workingday consumsion
        while($dayCount<=$daysInWeek){
            //tracks time of day
            while ($StartOfDay <= $hoursInDay){

            }

            $dayCount++;
        }

    }
    return $rollingToatl;
}


function highConsumption($maxConsumption){
    return rand(0,$maxConsumption/2);
}
function lowConsumption($maxConsumption){
    return rand($maxConsumption/2,$maxConsumption);
}