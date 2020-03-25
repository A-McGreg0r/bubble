<?php
include_once dirname(__DIR__) . '/required/config.php';

function generateAddRoom(){
    global $db;
    $html = '';
    $roomName = "";
    $html .= <<<pageHTML
    <div class="container">
        <div class="col-lg-12">
            <div class="row alter-display text-center align-middle">
                <h4 class="room-title">Add a new room to your house</h4>
                <div id="devicetext" style="width:100%"></div>
            </div>
            <div class="row alter-display align-middle reduce-space">
                <form class="text-center" action="required/action_addRoom.php" method="POST">
                    <!-- Room Name -->
                    <div class="md-form">
                        <label for="materialLoginFormName">Room Name</label>
                        <input type="text"
                            id="materialLoginFormName"
                            class="form-control form-control-sm"
                            name="roomName"
                            required size="3"
                            value="$roomName"/>
                    </div>

                    <!-- Password -->
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

                    <!-- Sign in button -->
                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" value="submit">Add Room</button>

                </form>
            </div>
        </div>
    </div>
pageHTML;
    return $html;
}

?>