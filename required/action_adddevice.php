<?php
    //////////////////////////////////////////////////////////// ADD DEVICE ACTION///////////////////////////////////////////////////
    /**
     * THIS FILE DOES A MAJORITY OF THE HEAVY LIFTING TO DO WITH QR CODES
     * QR CODES MUST TAKE THIS FORMAT
     * FIRST 3 CHARACTERS ARE DEVICE TYPE, E.G. A HUB IS 000
     * REMAINING CHARACTERS ARE AUTHCODE, THE UNIQUE IDENTIFIER IN THE DEVICE DATABASE
     */
    //LOAD QR CODE READING LIBRARY
    require dirname(__DIR__) . "/vendor/autoload.php";
    include_once dirname(__DIR__).'/required/config.php';
    use Zxing\QrReader;

    //GET PHOTO FROM POST BASE64 DATA
    $imageURI = $_POST['photo'];
    $imageURI = str_replace(' ', '+', $imageURI);
	$imageURI = str_replace('data:image/png;base64,', '', $imageURI);

    //DECODE BASE 64, BASE64_DECODE HAS TROUBLE DEALING WITH BASE64>5000 CHARACTERS, SO DO IT IN CLUMPS
    $decoded = "";
    for ($i=0; $i < ceil(strlen($imageURI)/256); $i++)
        $decoded = $decoded . base64_decode(substr($imageURI,$i*256,256));    
    //BEGIN SESSION
    session_start();
    $user_id = $_SESSION['user_id'];
    //END SESSION
    session_write_close();
    //PUT CONTENTS INTO FILE, THIS IS REQUIRED FOR QRCODE READER
    file_put_contents(dirname(__DIR__).'/upload/'.$user_id.".png",$decoded);
    //LOAD FILE AGAIN
    $image = dirname(__DIR__).'/upload/'.$user_id.".png";


    //SCAN IMAGE FOR QR CODE
    $qrcode = new QrReader($image);

    //GET TEXT FROM QR CODE IF IT EXISTS
    $qrText = $qrcode->text();
    if(!empty($qrText)){
        //GET DATA FROM QR CODE TEXT
        $deviceType = (int)substr($qrText, 0, 3);
        $auth_key = substr($qrText, 3);
        
        switch($deviceType){
            case 0: //HUB
                //FIND HUB IN TABLE WITH SPESIFIED AUTH_KEY
                $stmt = $db->prepare("SELECT * FROM hub_info WHERE auth_key = ?");
                $stmt->bind_param("s", $auth_key);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    //INSERT LINK IN HUB_USERS BETWEEN NEWLY ADDED HUB AND USER_ID FROM LOGGED IN SESSION
                    $row = $result->fetch_assoc();
                    $hub_id = $row['hub_id'];
                    $stmt1 = $db->prepare("INSERT INTO hub_users (user_id, hub_id) VALUES (?, ?)");
                    $stmt1->bind_param("ii", $user_id, $hub_id);
                    if (!$stmt1->execute()) {
                        echo "Sucessfully registered your new hub!\nNavigate to <a href=\"index.php\">Home</a> to view your newly added Hub!";
                    }else{
                        echo "Hmm, something went wrong, please refresh the page and try again";
                    }
                    $stmt1->close();

                } else {
                    echo "This Hub doesnt appear registered with us yet. Ensure the device has a green flashing LED on the top. For more troubleshooting, see <a href=\"index.php?action=troubleshooting\"Our Troubleshooting Tips</a>";
                }
                $stmt->close();

            break;
            default: //OTHER DEVICE



            break;
        }

    }


?>