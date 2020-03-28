<?php



include_once dirname(__DIR__) . '/required/config.php';

function checkRemainingBuget(){
    global $db;

    $stmt1 = $db->prepare("SELECT * FROM test_data WHERE hub_id = ?");
    $stmt1->bind_param("i", $hub_id);
    $stmt1->execute();
    $result2 = $stmt1->get_result();

    if ($result2->num_rows === 1) {
        $row2 = $result2->fetch_assoc();
        $cost_day = $row2['cost_day'];
        $cost_month = $row2['cost_month'];
        $cost_total = $row2['cost_total'];

    }
    $budget=100;
    if ($cost_month > (($budget*100)/$cost_month)){
    //send email

    }}