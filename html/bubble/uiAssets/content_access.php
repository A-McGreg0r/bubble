<?php
include_once dirname(__DIR__).'/required/config.php';

function generateAccessPage(){
    global $db;
    $html = '';
    session_start();

    //GET SESSION INFORMATION
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        //SANITIZE GIVEN AUTH KEY
        $auth_key = filter_input(INPUT_GET, "access", FILTER_SANITIZE_STRING);

        if($auth_key == FALSE){
            $html .= "Invalid request";
            return $html;
        }
        
        //GET ROW FROM HUB ACCESS REQUESTS TABLE
        $stmt = $db->prepare("SELECT * FROM hub_access_requests WHERE auth_key = ?");
        $stmt->bind_param("s", $auth_key);
        if(!$stmt->execute()){
            $html .= "Invalid key";
            $stmt->close();
            return $html;
        }

        $result = $stmt->get_result();

        //ENSURE THAT THE AUTH KEY IS VALID
        if($result->num_rows != 1){
            $html .= "Invalid key";
            $stmt->close();
            return $html;
        }

        $row = $result->fetch_assoc();
        $stmt->close();

        //GET REQUESTING USERS INFORMATION
        $stmtRequestUser = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
        $stmtRequestUser->bind_param("i", $row['request_user_id']);
        if(!$stmtRequestUser->execute()){
            $html .= "Invalid requesting user - Contact customer support.";
            $stmtRequestUser->close();
            return $html;
        }
        $resultRequestUser = $stmtRequestUser->get_result();
        $rowRequestUser = $resultRequestUser->fetch_assoc();
        $stmtRequestUser->close();
        $request_user_email = $rowRequestUser['email'];

        //GET HUB NAME
        $stmtHub = $db->prepare("SELECT hub_name FROM hub_info WHERE hub_id = ?");
        $stmtHub->bind_param("i",$hub_id);
        if(!$stmtHub->execute()){
            $html .= "Invalid hub.";
            $stmtHub->close();
            return $html;
        }
        $resultHub = $stmtHub->get_result();
        $rowHub = $resultHub->fetch_assoc();
        $stmtHub->close();
        $hub_name = $rowHub['hub_name'];

        //ENSURE THAT THE LOGGED IN USER IS THE ONE THAT WAS SENT THE EMAIL
        if($row['owner_user_id'] == $user_id){
            //ENSURE KEY IS WITHIN A VALID DATE
            if($row['expiry_date'] > time()){
                $html .= <<<html
                <div class="container">
                    <div class="col-lg-12">
                        <div class="row justify-content-center">
                            <div class="text-center align-middle">
                                <h3>User access request</h3>
                            </div>
                            <div class="align-middle">
                                <p><strong>$request_user_email</strong> has requested access to your hub, $hub_name. Do you wish to accept?
                            </div>
                        </div>
                    </div>
                </div>   
html;
            }else{
                $html .= "This key has expired, please ask the user to submit a new access request.";
                return $html;
            }
        }else{
            $html .= "You are not authorised to perform this action.";
            return $html;
        }
        

    }

    session_write_close();
    return $html;
}