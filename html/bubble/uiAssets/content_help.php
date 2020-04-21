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
                        <td onclick="openModalHelp('help5')">
                            What is the advice for?
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help5">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help5')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">What is the advice for?</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
                <div class="section-title"><h4>Room Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td onclick="openModalHelp('help6')">
                            Turn on a room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help6">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help6')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Turn on a room</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help7')">
                            Setting a timer
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help7">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help7')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Setting a timer</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help8')">
                            Adding a room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help8">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help8')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Adding a room</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help9')">
                            Removing a room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help9">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help9')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Removing a room</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title"><h4>Device Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td onclick="openModalHelp('help10')">
                            Setting a timer on a device
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help10">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help10')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Setting a timer</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help11')">
                            Review my device statistics
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help11">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help11')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Review my device statistics</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help12')">
                            Adding a device
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help12">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help12')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Adding a device</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help13')">
                            Moving a device to a different room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help13">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help13')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Moving a device to a different room</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td onclick="openModalHelp('help14')">
                            Removing a device
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help14">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help14')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Removing a device</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title"><h4>Acount</h4></div>
                <table class="helpTable">
                    <tr>
                        <td onclick="openModalHelp('help15')">
                            Change my account details
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help15">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" onclick="openModalHelp('help15')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Change my account details</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
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