<?php
include_once 'config.php';

function generateOnOff_room() {
    global $db;

    $status = $_SESSION['status'];
    $hub_id = $_SESSION['hub_id'];
    $room_id = $_SESSION['room_id'];
    $room_name = $_SESSION['room_name'];

    $set_device = 0;
    $on_or_off = 'off';

    if ($status == 0){
        $set_device = 1;
        $on_or_off = 'on';
    }

    $html = <<<html
    <div class="container">
        <div class="text-center">
            <div class="text-center confirmation">
                <img class="confirmation-logo" src="img/favicon.png" onload="load()">
                <p class="text-center">You have turned $on_or_off $room_name</p>
            </div>
        </div>

        <script>
    
        window.onload = function(){setTimeout(function(){ window.location = "index.php"; }, 1000)};

        </script>
    </div>   
html;

    $stmt = $db->prepare("SELECT * FROM device_info WHERE hub_id = ? AND room_id = ?");
    $stmt->bind_param("ii", $hub_id, $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows >= 1) {
        $all = $result->fetch_all(MYSQLI_ASSOC);
        foreach($all as $row){
            $device_id = $row['device_id'];
            $stmt2 = $db->prepare("UPDATE device_info SET device_status = ? WHERE device_id = ?");
            $stmt2->bind_param("ii", $set_device, $device_id);
            $stmt2->execute();
        }
    }

    return $html;
}

?>