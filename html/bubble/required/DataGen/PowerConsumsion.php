<?php
$currentDate= 0;

$timeOfDay=0;





generatesConsumptionData(8,17,1);


function generatesConsumptionData($workStart, $workEnd, $travleTime) {

    $count=1;


    $workinghours=array( $workStart , $workEnd);
    $daysInWeek = array(true,true,true,true,true,false,false);//true == at work false not at work

    while($count <=7){

        if ($daysInWeek[$count]==true) {
            //get hours awake first

            if($workinghours[1] > $timeOfDay && $workinghours[2] < $timeOfDay ){
                lowConsumption($timeOfDay);
                $count++;
            }else{
                highConsumption($timeOfDay);
            }
        }
        if ($daysInWeek[$count]==false){
            //if awake
            //call highConsumption high else call lowConsumption

            $count++;
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