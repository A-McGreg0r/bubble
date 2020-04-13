<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateAddRoom(){
    global $db;
    $html = '';
    //GET INPUT VARIABLES
    $roomName = filter_input(INPUT_GET, "roomName", FILTER_SANITIZE_STRING);
    $error = filter_input(INPUT_GET, "error", FILTER_SANITIZE_NUMBER_INT);
    $success = filter_input(INPUT_GET, "success", FILTER_SANITIZE_NUMBER_INT);

    $errorString = "";
    //HANDLE ERRORS
    if(isset($error)){
        switch($error){
            case 0:
                $errorString = "Invalid room name or icon!";
            break;
            case 1:
                $errorString = "Cannot find hub! Are you logged in?";
            break;
            case 2:
                $errorString = "Room name already exists!";
            break;
            case 3:
                $errorString = "Room creation failed! Please try again";
            break;
        }
    }
    
    if(isset($success)){
        $html .= <<<pageHTML
        <div class="container">
            <div class="col-lg-12">
                <div class="row alter-display text-center align-middle">
                    <h4 class="room-title">Successfully added new room:</h4>
                    <div id="devicetext" style="width:100%">$roomName</div>
                </div>
            </div>
        </div>
pageHTML;
    } else {
        $html .= <<<pageHTML
        <div class="container">
            <div class="col-lg-12">
                <div class="row alter-display text-center align-middle">
                    <h4 class="room-title">Add a new room to your house</h4>
                    <div id="devicetext" style="width:100%"></div>
                </div>
                <div class="row alter-display align-middle reduce-space">
                    <form class="text-center" action="required/action_addRoom.php" method="POST">
                        $errorString
                        <!-- Room Name -->
                        <div class="md-form">
                            <label for="materialLoginFormName">Room Name</label>
                            <input type="text"
                                id="materialLoginFormName"
                                class="form-control form-control-sm"
                                name="roomName"
                                required size="3"
                                value="$roomName"/>
                                <small class="form-text text-muted mb-4" style="text-align:center">Room must have a unique name</small>
                        </div>

                        <!-- Icon dropdown -->
                        <div class="md-form">
                            <select name="icon" class="browser-default custom-select dropdown">
                                <option value="" disabled selected>Choose your icon</option>
pageHTML;
                                $stmt = $db->prepare("SELECT * FROM room_types");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $inc = 0;
                                while($row = $result->fetch_assoc()) {
                                    $inc++;
                                    $val = $row['type_description'];
                                    $html .= "<option value=\"$inc\">$val</option>";
                                }
                                $html .= <<<pageHTML

                            </select>
                        </div>

                        <!-- Submit button -->
                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Add Room</button>

                    </form>
                </div>
            </div>
        </div>
pageHTML;
    }
    return $html;
}

?>