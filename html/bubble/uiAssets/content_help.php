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
                        <td style="cursor:pointer" onclick="openModalHelp('help1')">
                            Turn off all devices in my home
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help1">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help1')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Turn off all devices in my home</h3>
                                </div>
                                <div class="modalBody">
                                    <div>To turn off all devices in your home, perhaps as you're leaving for work,
                                        there is a button on the home page labelled 'Turn off Home'. Clicking on this button
                                        will turn off all devices in your home. If you would like to set a timer that will
                                        automatically turn off your home, click on the clock icon in the top right of the button.
                                        The timer icon will only be visible if there is currently a device turned on.</div>
                                    <img src="img/turnOffHome.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help2')">
                            Change house
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help2">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help2')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Change Home</h3>
                                </div>
                                <div class="modalBody">
                                    <div>If you are connected to more than one hub, it is possible to switch between them by 
                                        clicking on the 'Change House' button on the home page. Clicking on this will open a list 
                                        of all of your homes, and by selecting one, you can view all of the statistics, rooms and
                                        devices associated with that hub.</div>
                                    <img src="img/changeHome.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help3')">
                            Change my budget, energy price or solar panel rating
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help3">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help3')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Change my budget, energy price or solar panel rating</h3>
                                </div>
                                <div class="modalBody">
                                    <div>If you would like to change your budget, current energy price, or solar panel rating, then
                                        click on the 'Change Costing' button on the home page. This will open a form that you can fill
                                        in to change the stored values of each. If you don't want to change one of the values, just 
                                        just leave that part of the form empty.</div>
                                    <img src="img/changeCosting.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                </table>
                <div class="section-title"><h4>Advice Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help5')">
                            What is the advice for?
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help5">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help5')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">What is the advice for?</h3>
                                </div>
                                <div class="modalBody">
                                    <div>Our advice page offers suggestions that could help you save energy and money.
                                        By looking at the weather, we can advise you on ways in which you could reduce
                                        your energy consumption in the current temperature. Bubble is dedicated to helping
                                        everyone save energy, save money, and tries to inspire a more eco-friendly outlook.</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help4')">
                            How do you know my location?
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help4">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help4')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">How do you know my location?</h3>
                                </div>
                                <div class="modalBody">
                                    <div>When you set up your hub, we store the IP address of the hub. The IP address is a numerical label
                                    assigned to a device that can be interpreted to find a nearby location. 
                                    Using this, we can determine the weather of the local area. This information is completely
                                    secure, stored on our secure database.</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title"><h4>Room Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help6')">
                            Turn on a room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help6">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help6')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Turn on a room</h3>
                                </div>
                                <div class="modalBody">
                                    <div>To turn on all of the devices in a room, click on your desired room. The button
                                        will turn yellow to indicate it is turning on, you will see
                                        a loading symbol as the devices are turned on, then a status to the right of the button
                                        saying 'on'. If there is just one device on in the room, it will be displayed as on, so will
                                        default to turning the room off.
                                        <br><br>Similarly, if you would like to turn off all of the devices in the room, 
                                        click the room. The button will turn grey to indicate it is turning off, the loading icon
                                        will appear, then the status will update to 'off'.</div>
                                    <img src="img/turnOnRoom.JPG" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help7')">
                            Setting a timer
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help7">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help7')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Setting a timer</h3>
                                </div>
                                <div class="modalBody">
                                    <div>If a room is currently on, a small clock icon will appear in the top right corner of the button.
                                        Clicking on this button will open up a small window that will allow you to set a timer that
                                        will schedule the devices in that room to turn off. It will only set timers for devices that
                                        are currently turned on, and any timer that has been set will be deleted if the room is turned off.</div>
                                    <img src="img/roomTimer.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help8')">
                            Adding a room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help8">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help8')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Adding a room</h3>
                                </div>
                                <div class="modalBody">
                                    <div>In order to add a new room, there is a button at the very top of the Room Tab. Clicking on this button
                                        will open up a small form in which you can input the name of the room and the icon you would like
                                        it to have. Click on 'Add Room' at the bottom, and the new room will be added to the list.</div>
                                    <img src="img/addRoom.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help9')">
                            Removing a room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help9">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help9')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Removing a room</h3>
                                </div>
                                <div class="modalBody">
                                    <div>To remove a room, click on the information button in the top left corner of the room button.
                                    This will open up the statistics popup for the room. At the bottom of this popup, there
                                    is a button that says 'Delete Room'. Click this button and another popup will appear asking for
                                    confirmation. Click 'Delete Room', and the room will be deleted from your account.</div>
                                    <img src="img/removeRoom.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title"><h4>Device Tab</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help10')">
                            Setting a timer on a device
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help10">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help10')"><i class="fas fa-times"></i></i></div>
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
                        <td style="cursor:pointer" onclick="openModalHelp('help11')">
                            Review my device statistics
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help11">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help11')"><i class="fas fa-times"></i></i></div>
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
                        <td style="cursor:pointer" onclick="openModalHelp('help12')">
                            Adding a device
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help12">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help12')"><i class="fas fa-times"></i></i></div>
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
                        <td style="cursor:pointer" onclick="openModalHelp('help13')">
                            Moving a device to a different room
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help13">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help13')"><i class="fas fa-times"></i></i></div>
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
                        <td style="cursor:pointer" onclick="openModalHelp('help14')">
                            Removing a device
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help14">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help14')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Removing a device</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help19')">
                            Why is my device red?
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help19">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help19')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Why is my device red?</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title"><h4>Account</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help15')">
                            Change my account details
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help15">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help15')"><i class="fas fa-times"></i></i></div>
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
                        <td style="cursor:pointer" onclick="openModalHelp('help16')">
                            Delete my account
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help16">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help16')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">Delete my account</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help17')">
                            How to logout
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help17">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help17')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">How to logout</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help18')">
                            How to unsubscribe from email notifications
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help18">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help18')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader">
                                    <h3 class="bold-title">How to unsubscribe from email notifications</h3>
                                </div>
                                <div class="modalBody">
                                    Hello
                                </div>
                            </div>
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