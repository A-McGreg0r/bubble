<?php
$currentDate= 0;

$timeOfDay=0;
$workStart =8;//8am
$workEnd = 17;//5pm
$workinghours=array( $workStart , $workEnd);
$daysInWeek = array(true,true,true,true,true,false,false);//true == at work false not at work


$Traveltime=1;

$count=1;

while($count <=7){

    if ($daysInWeek[$count]==true) {
        if($workinghours[1] > $timeOfDay && $workinghours[2] < $timeOfDay ){
            lowConsumption($timeOfDay);
            $count++;
        }else{
            highConsumption($timeOfDay);
        }

    }

    if ($daysInWeek[$count]==false){
        $count++;
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