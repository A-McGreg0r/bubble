<?php 

include_once dirname(__DIR__) . '/required/config.php';

function generateHelpPage() {
    global $db;
    $hub_id = $_SESSION['hub_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("SELECT * FROM user_info WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        extract($result->fetch_assoc());

        $html = <<<html
        <div class="container justify-content-center">
            <div class="card justify-content-center" style="border:none!important">

                <div class="pageHeader">Hi $first_name, how can we help?</div>
                <hr style="width:100%!important;margin-left:0!important;margin-right:0!important;">

                <div class="section-title"><h4>Home Tab</h4></div>
                <table class="helpTable">
                    
                    <tr>
                        <td onclick="openModalHelp('help1')">
                            Turn off all devices in my home
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help1">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help1')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Turn off all devices in my home</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help2')">
                            Change house
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help2">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help2')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Change Home</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help3')">
                            Change my budget, energy price or solar panel rating
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help3">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help3')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Change my budget, energy price or solar panel rating</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                </table>
                <div class="section-title"><h4>Advice Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td onclick="openModalHelp('help4')">
                            How do you know my location?
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help4">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help4')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">How do you know my location?</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            What is the advice for?
                        </td>
                    </tr>

                </table>
                <div class="section-title"><h4>Room Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td>
                            Turn on a room
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Setting a timer
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Adding a room
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Removing a room
                        </td>
                    </tr>
                </table>
                <div class="section-title"><h4>Device Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td>
                            Setting a timer
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Review my device statistics
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Adding a device
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Moving a device to a different room
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Removing a device
                        </td>
                    </tr>
                    
                </table>
                <div class="section-title"><h4>Acount</h4></div>
                <table class="helpTable">
                    <tr>
                        <td>
                            Change my account details
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Delete my account
                        </td>
                    </tr>
                    <tr>
                        <td>
                            How to logout
                        </td>
                    </tr>
                    <tr>
                        <td>
                            How to unsubscribe from email notifications
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
html;
        return $html;
    }
}

?>