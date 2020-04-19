<?php
include_once dirname(__DIR__).'/required/config.php';
include_once dirname(__DIR__).'/required/PepperedPasswords.php';

function generateAccessPage(){
    global $db, $pepper;
    $html = '';
    session_start();

    //GET SESSION INFORMATION
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $hub_id = $_SESSION['hub_id'];
        session_write_close();

        //SANITIZE GIVEN AUTH KEY
        $auth_key = filter_input(INPUT_GET, "key", FILTER_SANITIZE_STRING);

        if($auth_key == FALSE){
            $html .= "Invalid request";
            return $html;
        }
        
        //GET ROW FROM HUB ACCESS REQUESTS TABLE
        $stmt = $db->prepare("SELECT * FROM hub_access_requests WHERE owner_user_id = ?");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            $html .= "Invalid user";
            $stmt->close();
            return $html;
        }

        $result = $stmt->get_result();
        $hasher = new PepperedPasswords($pepper);

        while($row = $result->fetch_assoc()){
            if($hasher->verify($auth_key, $row['auth_key'])){
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
                $stmtHub->bind_param("i",$row['hub_id']);
                if(!$stmtHub->execute()){
                    $html .= "Invalid hub.";
                    $stmtHub->close();
                    return $html;
                }
                $resultHub = $stmtHub->get_result();
                $rowHub = $resultHub->fetch_assoc();
                $stmtHub->close();
                $hub_name = $rowHub['hub_name'];


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
                                    <button id="acceptRequestButton" type="button" class="btn btn-danger btn-rounded btn-sm my-0" data-toggle="modal" onclick="acceptAccessRequest($auth_key, $request_user_email)";>Accept</button>
                                </div>
                            </div>
                        </div>
                    </div>   
html;
                }else{
                    $html .= "This key has expired, please ask the user to submit a new access request.";
                    return $html;
                }
            }
        }
        $stmt->close();


    }

    session_write_close();
    return $html;
}
?>