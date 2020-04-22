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

                <div class="pageHeader" style="padding-top:15px">Hi $first_name, what can we help you with?</div>
                <hr style="width:100%!important;margin-left:0!important;margin-right:0!important;">
                <ul style="text-align:center;list-style-type:none;padding-left:0;margin-bottom:0;">
                    <li><a href="#homeHelp" style="font-size:22px;padding:5px;">Home</a></li>
                    <li><a href="#roomsHelp" style="font-size:22px;padding:5px;">Rooms</a></li>
                    <li><a href="#deviceHelp" style="font-size:22px;padding:5px;">Devices</a></li>
                    <li><a href="#adviceHelp" style="font-size:22px;padding:5px;">Advice</a></li>
                    <li><a href="#accountHelp" style="font-size:22px;padding:5px;">Account</a></li>
                </ul>
                <hr style="width:100%!important;margin-left:0!important;margin-right:0!important;margin-bottom:40px;">

                <div class="section-title" id="homeHelp"><h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Home</h4></div>
                <table class="helpTable">
                    
                    
                    <div class="card helpCard">
                    
                    
                    </div>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help1', 'arrow1')">
                            Turn off all devices in my home<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow1"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help1">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help1', 'arrow1')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Turn off all devices in my home</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                        <div>
                                            To turn off all devices in your home, perhaps as you're leaving for work,
                                            there is a button on the home page labelled 'Turn off Home'. Clicking on this button
                                            will turn off all devices in your home. If you would like to set a timer that will
                                            automatically turn off your home, click on the clock icon in the top right of the button.
                                            The timer icon will only be visible if there is currently a device turned on.
                                         </div>
                                        <br>
                                    <img src="img/turnOffHome.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help2', 'arrow2')">
                            Change house <div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow2"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help2">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help2', 'arrow2')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Change house</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                        <div>If you are connected to more than one hub, it is possible to switch between them by 
                                            clicking on the 'Change House' button on the home page. Clicking on this will open a list 
                                            of all of your homes, and by selecting one, you can view all of the statistics, rooms and
                                            devices associated with that hub.
                                        </div>
                                    <br>
                                    <img src="img/changeHome.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help3', 'arrow3')">
                            Change costings: my budget, energy price or solar panel rating<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow3"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help3">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help3', 'arrow3')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Change costings: my budget, energy price or solar panel rating</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>If you would like to change your budget, current energy price, or solar panel rating, then
                                        click on the 'Change Costing' button on the home page. This will open a form that you can fill
                                        in to change the stored values of each. If you don't want to change one of the values, just 
                                        just leave that part of the form empty.</div>
                                    <br><img src="img/changeCosting.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help21', 'arrow21')">
                            What do all of the statistics mean?<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow21"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help21">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help21', 'arrow21')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">What do all of the statistics mean?</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>At the top of the home page, underneath the buttons, there is a cost overview that
                                    tells you how much energy you have used over the past day, month and year. It also provides
                                    a costing estimate based on the energy cost set up on the hub. Under the monthly section,
                                    it tells you what is left of your budget.
                                    <br><img src="img/overview.png" style="max-width:90%;"/><br><br>
                                    Below the cost overview, there is the expenditure section. Here you will see how much of your
                                    daily, monthyl and yearly budget is remaining. You can scroll between the charts to see your desired
                                    timeframe
                                    <br><img src="img/pie.png" style="max-width:90%;"/><br><br>
                                    At the bottom, there is a line chart that shows you a history of your energy use. This is an easy
                                    way to compare your energy usage with the amount you've used previously. The grey line shows the
                                    energy consumption, which is directly affected by the devices you have on, and the yellow line shows
                                    the energy generated by solar panels.</div>
                                    <br><img src="img/graph.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                </table>
                <div class="section-title" id="roomsHelp"><h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Rooms</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help6', 'arrow6')">
                            Turn on a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow6"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help6">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help6', 'arrow6')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Turn on a room</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To turn on all of the devices in a room, click on your desired room. The button
                                        will turn yellow to indicate it is turning on, you will see
                                        a loading symbol as the devices are turned on, then a status to the right of the button
                                        saying 'on'. If there is just one device on in the room, it will be displayed as on, so will
                                        default to turning the room off.
                                        <br><br>Similarly, if you would like to turn off all of the devices in the room, 
                                        click the room. The button will turn grey to indicate it is turning off, the loading icon
                                        will appear, then the status will update to 'off'.</div>
                                    <br><img src="img/turnOnRoom.JPG" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help7', 'arrow7')">
                            Setting a timer on a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow7"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help7">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help7', 'arrow7')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Setting a timer on a room</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>If a room is currently on, a small clock icon will appear in the top right corner of the button.
                                        Clicking on this button will open up a small window that will allow you to set a timer that
                                        will schedule the devices in that room to turn off. It will only set timers for devices that
                                        are currently turned on, and any timer that has been set will be deleted if the room is turned off.</div>
                                    
                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help22', 'arrow22')">
                            Review the statistics of a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow22"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help22">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help22', 'arrow22')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Review the statistics of a room</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To review your room's statistics, click on the information button in the top left corner of the room button.
                                    This will open up the statistics popup for the room. At the top there is a pie chart diplaying
                                    a comparison between the amount this device is costing you against all of the other devices
                                    put together. It is also displayed below the chart, along with the percentage of this device
                                    against all others.<br><br>
                                    The second section shows a costing overview for the selected room, with the previous hour, day, month
                                    and year statistics all displayed with their estimated costing.</div>
                                    <br><img src="img/removeRoom.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help8', 'arrow8')">
                            Adding a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow8"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help8">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help8', 'arrow8')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Adding a room</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>In order to add a new room, there is a button at the very top of the Room Tab. Clicking on this button
                                        will open up a small form in which you can input the name of the room and the icon you would like
                                        it to have. Click on 'Add Room' at the bottom, and the new room will be added to the list.</div>
                                    <br><img src="img/addRoom.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help9', 'arrow9')">
                            Removing a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow9"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help9">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help9', 'arrow9')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Removing a room</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To remove a room, click on the information button in the top left corner of the room button.
                                    This will open up the statistics popup for the room. At the bottom of this popup, there
                                    is a button that says 'Delete Room'. Click this button and another popup will appear asking for
                                    confirmation. Click 'Delete Room', and the room will be deleted from your account.</div>
                                    <br><img src="img/removeRoom.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title" id="deviceHelp"><h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Device</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help20', 'arrow20')">
                            Turn on a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow20"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help20">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help20', 'arrow20')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Turn on a device</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To turn on a device, simply click on the device you would like to turn on.
                                        A loading symbol will appear and the device button will refresh with it's new status.
                                        If a device button is yellow, then it is turned on. If it is grey, then it is turned off.
                                        <br><br>
                                        Some devices, such as heaters and air conditioners, have dimmer switches. A dimmer switch
                                        will display their current setting in sections of yellow, as seen below. The status to the right of the
                                        button will display the current setting of the device, which varies between 0 and 4. Clicking
                                        on these buttons will increase the setting of the device by one, then drop back down to 0.</div>
                                        <br><img src="img/turnOnDevice.JPG" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help10', 'arrow10')">
                            Setting a timer on a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow10"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help10">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help10', 'arrow10')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Setting a timer</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>When a device is turned on, a clock icon will appear in the top right corner of the button.
                                        Clicking on this button will open up a small popup in which you can set a timer to turn off your device.
                                        The time that the device is scheduled to turn off will appear. If the device is turned off before
                                        the timer turns it off, the timer will be cancelled.</div>
                                    <br><img src="img/deviceTimer.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help11', 'arrow11')">
                            Review my device statistics<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow11"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help11">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help11', 'arrow11')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Review my device statistics</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To access the statistics of a device, click on the information icon in the top left of the button.
                                        Opening this popup, you will see a pie chart that shows a comparison between the amount this device
                                        is costing you compared to all other devices put together. Underneath, you will see the numbers laid
                                        out along with a percentage for this device.
                                        <br><br>
                                        Underneath, there is an energy usage section that shows the energy consumption of the device over 
                                        the past hour, day, month and year, and how much each has cost you.</div>
                                    <br><img src="img/deviceStats.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help12', 'arrow12')">
                            Adding a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow12"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help12">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help12', 'arrow12')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Adding a device</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To add a new device, click on the 'Add new device' button at the top of the devics tab.
                                        This will open up a popup, and, assuming you have allowed access to your camera, will show
                                        the view from your camera. Scan the QR code that came with your device, and the device will
                                        automatically be linked to your account. That's all there is to it!</div>
                                    <br><img src="img/addDevice.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help13', 'arrow13')">
                            Moving a device to a different room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow13"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help13">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help13', 'arrow13')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Moving a device to a different room</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To move a device to a different room, click on the information icon in the top left
                                        of the device button. This will open the statistics popup. If you scroll to the very 
                                        bottom of this popup, there is a button that says 'Move Device'. Clicking on this
                                        will open a dropdown menu that allows you to select the room you'd like to move the 
                                        device to, click 'Save Changes' and your device will be moved.</div>
                                    <br><img src="img/deviceStats.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help14', 'arrow14')">
                            Removing a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow14"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help14">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help14', 'arrow14')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Removing a device</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To remove a device, click on the information icon in the top left
                                    of the device button. This will open the statistics popup. If you scroll to the very 
                                    bottom of this popup, there is a button that says 'Delete Device'. Click on this and
                                    the app will ask for confirmation. Click on 'Delete Device' and your device will be remved
                                    from your account.</div>
                                    <br><img src="img/deviceStats.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help19', 'arrow19')">
                            Why is my device red?<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow19"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help19">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help19', 'arrow19')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Why is my device red?</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>If a device appears as red with the status set to 'Fault', this means that there is an
                                        issue with your device. To rectify this, you will either need to replace the faulty device
                                        or contact us at bubblehome.care@gmail.com to enquire about a repair.</div>
                                    <br><img src="img/redButton.JPG" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title" id="adviceHelp"><h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Advice</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help5', 'arrow5')">
                            What is the advice for? <div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow5"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help5">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help5', 'arrow5')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">What is the advice for?</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>Our advice page offers suggestions that could help you save energy and money.
                                        By looking at the weather, we can advise you on ways in which you could reduce
                                        your energy consumption in the current temperature. Bubble is dedicated to helping
                                        everyone save energy, save money, and tries to inspire a more eco-friendly outlook.</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help4', 'arrow4')">
                            How do you know my location?<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow4"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help4">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help4', 'arrow4')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">How do you know my location?</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>When you set up your hub, we store the IP address of the hub. The IP address is a numerical label
                                    assigned to a device that can be interpreted to find a nearby location. 
                                    Using this, we can determine the weather of the local area. This information is completely
                                    secure, stored on our secure database.</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="section-title" id="accountHelp"><h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Account</h4></div>
                <table class="helpTable">
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help15', 'arrow15')">
                            Change my account details<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow15"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help15">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help15', 'arrow15')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Change my account details</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To update your account, navigate to the account page, found at the top of the screen
                                    on laptops and desktops, or in the dropdown menu on mobile or tablet. Here, you will be able
                                    to view your current details. By pressing the 'Update Account' button at the bottom, a popup
                                    will open where you can enter your new details. If you wish for part of your account details to
                                    remain the same, just leave the field blank. Press 'Update', and you're account details will update.</div>
                                    <br><img src="img/updateAccount.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help16', 'arrow16')">
                            Delete my account<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow16"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help16">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help16', 'arrow16')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">Delete my account</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;">
                                    <div>To delete your account, navigate to the account page, found at the top of the screen
                                    on laptops and desktops, or in the dropdown menu on mobile or tablet. Here, you will be able
                                    to view your current details. By pressing the 'Delete Account' button at the bottom, you will open a popup
                                    that will ask for confirmation. If you wish to delete your accout, select 'Yes: Delete Account'. This
                                    will permanently delete your details, and, should you wish to access the app again, you will need to 
                                    create a new one. We'd be sad to see you go!</div>
                                    <br><img src="img/deleteAccount.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help17', 'arrow17')">
                            How to logout<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow17"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help17">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help17', 'arrow17')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">How to logout</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                    <div>To logout, the button can be found at the top of the screen
                                    on laptops and desktops, or in the dropdown menu on mobile or tablet. Here, you will be able
                                    to select the logout button, and you will be returned to the login page.</div>
                                    <br><img src="img/logout.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="cursor:pointer" onclick="openModalHelp('help18', 'arrow18')">
                            How to unsubscribe from email notifications<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow18"></i>
                        </td>
                    </tr>
                    <tr style="display:none!important" id="help18">
                        <td>
                            <div class="modalStats" style="border: 1px solid black;" >
                                <div class="x-adjust"><i class="stats_icon_x " id="" style="display:block" style="cursor:pointer" onclick="openModalHelp('help18', 'arrow18')"><i class="fas fa-times"></i></i></div>
                                <div class="modalHeader helpHeader">
                                    <h3 class="bold-title">How to unsubscribe from email notifications</h3>
                                </div>
                                <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                                <div>To update your account, navigate to the account page, found at the top of the screen
                                    on laptops and desktops, or in the dropdown menu on mobile or tablet. Here, you will be able
                                    to view your current details. By pressing the 'Update Account' button at the bottom, a popup
                                    will open where you can enter your new details. Here, there is the option to change whether or
                                    not you receive email notifications. Press 'Update', and you're account details will update.</div>
                                    <br><img src="img/updateAccount.png" style="max-width:90%;"/>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        
<!--Andrew's Testing-->



<div class="container justify-content-center" style="max-width: 1200px">

    
    <!--Section :1-->       
    <div class="section-title" id="homeHelp"><h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Home</h4></div>
      <!--Accordion wrapper-->
      <div class="accordion md-accordion bot-mar helpCard" id="accordionEx" role="tablist" aria-multiselectable="true">
    
        <!-- Accordion card :1 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingOne1">
            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
              aria-controls="collapseOne1">
              <h5 class="mb-0 helpDrop" style="text-align: center" onclick='arrow("arrow1")'>
              Turn off all devices in my home<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow1"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseOne1" class="collapse" role="tabpanel" aria-labelledby="headingOne1"
            data-parent="#accordionEx">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Turn off all devices in my home</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">   
                To turn off all devices in your home, perhaps as you're leaving for work,
                there is a button on the home page labelled 'Turn off Home'. Clicking on this button
                will turn off all devices in your home. If you would like to set a timer that will
                automatically turn off your home, click on the clock icon in the top right of the button.
                The timer icon will only be visible if there is currently a device turned on.               
                <br>
                <img src="img/turnOffHome.png" style="max-width:90%;"/>
             </div>     
          </div>
    
        </div>
        <!-- Accordion card :1 -->
        
        
        <!-- Accordion card :2 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingTwo2">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
              aria-expanded="false" aria-controls="collapseTwo2">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Change house <div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow2"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
          <div class="modalHeader helpHeader">
            <h3 class="bold-title">Change House</h3>
        </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                    If you are connected to more than one hub, it is possible to switch between them by 
                    clicking on the 'Change House' button on the home page. Clicking on this will open a list 
                    of all of your homes, and by selecting one, you can view all of the statistics, rooms and
                    devices associated with that hub.
                <br>
                <img src="img/changeHome.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :2 -->
    
        <!-- Accordion card :3 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingThree3">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
              aria-expanded="false" aria-controls="collapseThree3">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Change costings: my budget, energy price or solar panel rating<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow3"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
            data-parent="#accordionEx">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Change costings: my budget, energy price or solar panel rating</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                    If you would like to change your budget, current energy price, or solar panel rating, then
                    click on the 'Change Costing' button on the home page. This will open a form that you can fill
                    in to change the stored values of each. If you don't want to change one of the values, just 
                    just leave that part of the form empty.
                
                <br>
                <img src="img/changeCosting.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :3 -->
        
         <!-- Accordion card :4 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFour4">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseFour4"
              aria-expanded="false" aria-controls="collapseThree3">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              What do all of the statistics mean?<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow21"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFour4" class="collapse" role="tabpanel" aria-labelledby="headingFour4"
            data-parent="#accordionEx">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">What do all of the statistics mean?</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                At the top of the home page, underneath the buttons, there is a cost overview that
                tells you how much energy you have used over the past day, month and year. It also provides
                a costing estimate based on the energy cost set up on the hub. Under the monthly section,
                it tells you what is left of your budget.
                <br>
                <img src="img/overview.png" style="max-width:90%;"/><br>
                Below the cost overview, there is the expenditure section. Here you will see how much of your
                daily, monthyl and yearly budget is remaining. You can scroll between the charts to see your desired
                timeframe
                <br>
                <img src="img/pie.png" style="max-width:90%;"/><br><br>
                At the bottom, there is a line chart that shows you a history of your energy use. This is an easy
                way to compare your energy usage with the amount you've used previously. The grey line shows the
                energy consumption, which is directly affected by the devices you have on, and the yellow line shows
                the energy generated by solar panels.
                <br>
                <img src="img/graph.png" style="max-width:90%;"/>         
            </div>
          </div>
    
        </div>
        <!-- Accordion card :3 -->
    
      </div>
      <!-- Accordion wrapper -->

    <!--Section :1--> 
    
    
    
    <!--Section :2-->      
    <div class="section-title" id="roomsHelp">
        <h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Rooms</h4>
    </div>
      <!--Accordion wrapper-->
      <div class="accordion md-accordion bot-mar helpCard" id="accordionExGroup2" role="tablist" aria-multiselectable="true">
    
       <!-- Accordion card :1 -->
        <div class="card helpCard">
            <!-- Card header -->
                <div class="card-header helpHead" role="tab" id="headingOne1Group2">
                    <a data-toggle="collapse" data-parent="#accordionExGroup2" href="#collapseOne1Group2" aria-expanded="true"
                    aria-controls="collapseOne1Group2">
                        <h5 class="mb-0 helpDrop" style="text-align: center">
                        Turn on a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow6"></i>
                        </h5>
                    </a>
                </div>
            <!-- Card header -->
            
            <!-- Card body -->
            <div id="collapseOne1Group2" class="collapse" role="tabpanel" aria-labelledby="headingOne1Group2" data-parent="#accordionExGroup2">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Turn on a room</h3>
            </div>
                    <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">
                        To turn on all of the devices in a room, click on your desired room. The button
                        will turn yellow to indicate it is turning on, you will see
                        a loading symbol as the devices are turned on, then a status to the right of the button
                        saying 'on'. If there is just one device on in the room, it will be displayed as on, so will
                        default to turning the room off.
                        <br><br>
                        Similarly, if you would like to turn off all of the devices in the room, 
                        click the room. The button will turn grey to indicate it is turning off, the loading icon
                        will appear, then the status will update to 'off'.
                        <br>
                    <img src="img/turnOnRoom.JPG" style="max-width:90%;"/>    
                </div>
            </div>
            <!-- Card body -->
        </div>
        <!-- Accordion card :1 -->
        
        
        <!-- Accordion card :2 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingTwo2Group2">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup2" href="#collapseTwo2Group2"
              aria-expanded="false" aria-controls="collapseTwo2Group2">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Setting a timer on a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow7"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseTwo2Group2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2Group2" data-parent="#accordionExGroup2">
          <div class="modalHeader helpHeader">
            <h3 class="bold-title">Setting a timer on a room</h3>
        </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
            If a room is currently on, a small clock icon will appear in the top right corner of the button. 
            Clicking on this button will open up a small window that will allow you to set a timer that will schedule the devices in that room to turn off.
             It will only set timers for devices that are currently turned on, and any timer that has been set will be deleted if the room is turned off.
            
            <br>
            <br>
            <img src="img/roomTimer.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :2 -->
    
        <!-- Accordion card :3 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingThree3Group2">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup2" href="#collapseThree3Group2"
              aria-expanded="false" aria-controls="collapseThree3Group2">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Review the statistics of a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow22"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseThree3Group2" class="collapse" role="tabpanel" aria-labelledby="headingThree3Group2"
            data-parent="#accordionExGroup2">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Review the statistics of a room</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
            <div>To review your room's statistics, click on the information button in the top left corner of the room button.
            This will open up the statistics popup for the room. At the top there is a pie chart diplaying
            a comparison between the amount this device is costing you against all of the other devices
            put together. It is also displayed below the chart, along with the percentage of this device
            against all others.<br><br>
            The second section shows a costing overview for the selected room, with the previous hour, day, month
            and year statistics all displayed with their estimated costing.</div>
            <br><img src="img/removeRoom.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :3 -->
        
         <!-- Accordion card :4 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFour4Group2">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup2" href="#collapseFour4Group2"
              aria-expanded="false" aria-controls="collapseFour4Group2">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Adding a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow8"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFour4Group2" class="collapse" role="tabpanel" aria-labelledby="collapseFour4Group2"
            data-parent="#accordionExGroup2">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Adding a room</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                In order to add a new room, there is a button at the very top of the Room Tab.
                 Clicking on this button will open up a small form in which you can input the name of the room and the icon you would like it to have.
                  Click on 'Add Room' at the bottom, and the new room will be added to the list.
                <br>
               
                <img src="img/addRoom.png" style="max-width:90%;"/>         
            </div>
          </div>
    
        </div>
        <!-- Accordion card :4 -->
        
        
        <!-- Accordion card :5 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFiveGroup2>
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup2" href="#collapseFive5Group2"
              aria-expanded="false" aria-controls="collapseFive5Group2">
              <h5 class="mb-0 helpDrop" style="text-align: center">
                Removing a room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow9"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFive5Group2" class="collapse" role="tabpanel" aria-labelledby="headingFive5Group2"
            data-parent="#accordionExGroup2">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Removing a room</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                To remove a room, click on the information button in the top left corner of the room button.
                 This will open up the statistics popup for the room. At the bottom of this popup, there is a button that says 'Delete Room'.
                  Click this button and another popup will appear asking for confirmation. Click 'Delete Room', and the room will be deleted from your account.
                <br>
               
                <img src="img/removeRoom.png" style="max-width:90%;"/>         
            </div>
          </div>
    
        </div>
        <!-- Accordion card :5 -->
    
      </div>
      <!-- Accordion wrapper -->
    
    <!--Section :3--> 



    <!--Section :4-->      
    <div class="section-title" id="roomsHelp">
        <h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Devices</h4>
    </div>
      <!--Accordion wrapper-->
      <div class="accordion md-accordion bot-mar helpCard" id="accordionExGroup3" role="tablist" aria-multiselectable="true">
    
       <!-- Accordion card :1 -->
        <div class="card helpCard">
            <!-- Card header -->
                <div class="card-header helpHead" role="tab" id="headingOne1Group3">
                    <a data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseOne1Group3" aria-expanded="true"
                    aria-controls="collapseOne1Group3">
                        <h5 class="mb-0 helpDrop" style="text-align: center">
                        Turn on a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow20"></i>
                        </h5>
                    </a>
                </div>
            <!-- Card header -->
            
            <!-- Card body -->
            <div id="collapseOne1Group3" class="collapse" role="tabpanel" aria-labelledby="headingOne1Group3" data-parent="#accordionExGroup3">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Turn on a device</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">
                        To turn on a device, simply click on the device you would like to turn on.
                         A loading symbol will appear and the device button will refresh with it's new status. If a device button is yellow, then it is turned on.
                          If it is grey, then it is turned off.
                        <br><br>
                        Some devices, such as heaters and air conditioners, have dimmer switches.
                         A dimmer switch will display their current setting in sections of yellow, as seen below. 
                         The status to the right of the button will display the current setting of the device, which varies between 0 and 4.
                          Clicking on these buttons will increase the setting of the device by one, then drop back down to 0.
                        <br>
                    <img src="img/turnOnDevice.JPG" style="max-width:90%;"/> 
                </div>   
            </div>
            <!-- Card body -->
        </div>
        <!-- Accordion card :1 -->
        
        
        <!-- Accordion card :2 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingTwo2Group3">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseTwo2Group3"
              aria-expanded="false" aria-controls="collapseTwo2Group3">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Setting a timer on a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow10"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseTwo2Group3" class="collapse" role="tabpanel" aria-labelledby="headingTwo2Group3" data-parent="#accordionExGroup3">
          <div class="modalHeader helpHeader">
                <h3 class="bold-title">Setting a timer</h3>
            </div>  
          <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
            When a device is turned on, a clock icon will appear in the top right corner of the button.
            Clicking on this button will open up a small popup in which you can set a timer to turn off your device.
            The time that the device is scheduled to turn off will appear. If the device is turned off before the timer turns it off, the timer will be cancelled.
            <br><br>
            
            <img src="img/deviceTimer.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :2 -->
    
        <!-- Accordion card :3 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingThree3Group3">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseThree3Group3"
              aria-expanded="false" aria-controls="collapseThree3Group3">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Review my device statistics<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow11"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseThree3Group3" class="collapse" role="tabpanel" aria-labelledby="headingThree3Group3"
            data-parent="#accordionExGroup3">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Review my device statistics</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                    To access the statistics of a device, click on the information icon in the top left of the button.
                     Opening this popup, you will see a pie chart that shows a comparison between the amount this device is costing you compared to all other devices put together.
                      Underneath, you will see the numbers laid out along with a percentage for this device.

                    <br>
                    Underneath, there is an energy usage section that shows the energy consumption of the device over the past hour,
                    day, month and year, and how much each has cost you.
                <br>
                <img src="img/deviceStats.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :3 -->
        
         <!-- Accordion card :4 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFour4Group3">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseFour4Group3"
              aria-expanded="false" aria-controls="collapseFour4Group3">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Adding a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow12"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFour4Group3" class="collapse" role="tabpanel" aria-labelledby="collapseFour4Group3"
            data-parent="#accordionExGroup3">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Adding a device</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                To add a new device, click on the 'Add new device' button at the top of the devics tab.
                This will open up a popup, and, assuming you have allowed access to your camera, will show the view from your camera. Scan the QR code that came with your device,
                 and the device will automatically be linked to your account. That's all there is to it!
                <br>
               
                <img src="img/addDevice.png" style="max-width:90%;"/>         
            </div>
          </div>
    
        </div>
        <!-- Accordion card :4 -->
        
        <!-- Accordion card :5 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFiveGroup8>
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseFive5Group8"
              aria-expanded="false" aria-controls="collapseFive5Group8">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Moving a device to a different room<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow13"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFive5Group8" class="collapse" role="tabpanel" aria-labelledby="headingFive5Group8"
            data-parent="#accordionExGroup3">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Moving a device to a different room</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
            <div>To move a device to a different room, click on the information icon in the top left
            of the device button. This will open the statistics popup. If you scroll to the very 
            bottom of this popup, there is a button that says 'Move Device'. Clicking on this
            will open a dropdown menu that allows you to select the room you'd like to move the 
            device to, click 'Save Changes' and your device will be moved.</div>
        <br><img src="img/deviceStats.png" style="max-width:90%;"/>        
            </div>
          </div>
    
        </div>
        <!-- Accordion card :5 -->

        <!-- Accordion card :5 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFiveGroup3>
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup2" href="#collapseFive5Group3"
              aria-expanded="false" aria-controls="collapseFive5Group3">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Removing a device<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow14"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFive5Group3" class="collapse" role="tabpanel" aria-labelledby="headingFive5Group3"
            data-parent="#accordionExGroup3">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Removing a device</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                To remove a device, click on the information icon in the top left of the device button. This will open the statistics popup.
                 If you scroll to the very bottom of this popup, there is a button that says 'Delete Device'. Click on this and the app will ask for confirmation. 
                 Click on 'Delete Device' and your device will be remved from your account.
                <br>
               
                <img src="img/deviceStats.png" style="max-width:90%;"/>         
            </div>
          </div>
    
        </div>
        <!-- Accordion card :5 -->
        
        
        
        <!-- Accordion card :6 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingSixGroup3>
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseSix6Group3"
              aria-expanded="false" aria-controls="collapseSix6Group2">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Why is my device red?<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow19"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseSix6Group3" class="collapse" role="tabpanel" aria-labelledby="headingSix6Group3"
            data-parent="#accordionExGroup3">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Why is my device red?</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                    <div>If a device appears as red with the status set to 'Fault', this means that there is an
                    issue with your device. To rectify this, you will either need to replace the faulty device
                    or contact us at bubblehome.care@gmail.com to enquire about a repair.</div>
                <br><img src="img/redButton.JPG" style="max-width:90%;"/>        
            </div>
          </div>
    
        </div>
        <!-- Accordion card :6 -->
    
      </div>
      <!-- Accordion wrapper -->
    
    <!--Section :4-->
  
  
  
  <!--Section :5-->      
    <div class="section-title" id="roomsHelp">
        <h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Advice</h4>
    </div>
      <!--Accordion wrapper-->
      <div class="accordion md-accordion bot-mar helpCard" id="accordionExGroup4" role="tablist" aria-multiselectable="true">
    
       <!-- Accordion card :1 -->
        <div class="card helpCard">
            <!-- Card header -->
                <div class="card-header helpHead" role="tab" id="headingOne1Group5">
                    <a data-toggle="collapse" data-parent="#accordionExGroup4" href="#collapseOne1Group5" aria-expanded="true"
                    aria-controls="collapseOne1Group5">
                        <h5 class="mb-0 helpDrop" style="text-align: center">
                        What is the advice for? <div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow5"></i>
                        </h5>
                    </a>
                </div>
            <!-- Card header -->
            
            <!-- Card body -->
            <div id="collapseOne1Group5" class="collapse" role="tabpanel" aria-labelledby="headingOne1Group5" data-parent="#accordionExGroup4">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">What is the advice for?</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">
        <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                    <div>Our advice page offers suggestions that could help you save energy and money.
                        By looking at the weather, we can advise you on ways in which you could reduce
                        your energy consumption in the current temperature. Bubble is dedicated to helping
                        everyone save energy, save money, and tries to inspire a more eco-friendly outlook.</div>
                </div>  
                </div> 
            </div>
            <!-- Card body -->
        </div>
        <!-- Accordion card :1 -->
        
        
        <!-- Accordion card :2 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingTwo2Group5">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup3" href="#collapseTwo2Group5"
              aria-expanded="false" aria-controls="collapseTwo2Group5">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              How do you know my location?<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow4"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseTwo2Group5" class="collapse" role="tabpanel" aria-labelledby="headingTwo2Group5" data-parent="#accordionExGroup3">
          <div class="modalHeader helpHeader">
            <h3 class="bold-title">How do you know my location?</h3>
        </div>  
          <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
        
            <div class="modalBody" style="text-align:justify!important;text-align-last:center!important;"">
                <div>When you set up your hub, we store the IP address of the hub. The IP address is a numerical label
                assigned to a device that can be interpreted to find a nearby location. 
                Using this, we can determine the weather of the local area. This information is completely
                secure, stored on our secure database.</div>
            </div>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :2 -->
    
      </div>
      <!-- Accordion wrapper -->
    
    <!--Section :5-->
    
    
    <!--Section :6-->      
    <div class="section-title" id="roomsHelp">
        <h4 style="color:rgb(226, 183, 28);font-weight:600!important;">Account</h4>
    </div>
      <!--Accordion wrapper-->
      <div class="accordion md-accordion bot-mar helpCard" id="accordionExGroup4" role="tablist" aria-multiselectable="true">
    
       <!-- Accordion card :1 -->
        <div class="card helpCard">
            <!-- Card header -->
                <div class="card-header helpHead" role="tab" id="headingOne1Group4">
                    <a data-toggle="collapse" data-parent="#accordionExGroup4" href="#collapseOne1Group4" aria-expanded="true"
                    aria-controls="collapseOne1Group4">
                        <h5 class="mb-0 helpDrop" style="text-align: center">
                        Change my account details<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow15"></i>
                        </h5>
                    </a>
                </div>
            <!-- Card header -->
            
            <!-- Card body -->
            <div id="collapseOne1Group4" class="collapse" role="tabpanel" aria-labelledby="headingOne1Group4" data-parent="#accordionExGroup4">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">Change my account details</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">
                        To update your account, navigate to the account page, found at the top of the screen on laptops and desktops,
                         or in the dropdown menu on mobile or tablet. Here, you will be able to view your current details. By pressing the 'Update Account' button at the bottom,
                          a popup will open where you can enter your new details. If you wish for part of your account details to remain the same, just leave the field blank. Press 'Update', and you're 
                          account details will update.

                        <br>
                    <img src="img/updateAccount.png" style="max-width:90%;"/>
                </div>    
            </div>
            <!-- Card body -->
        </div>
        <!-- Accordion card :1 -->
        
        
        <!-- Accordion card :2 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingTwo2Group4">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup4" href="#collapseTwo2Group4"
              aria-expanded="false" aria-controls="collapseTwo2Group4">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              Delete my account<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow16"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseTwo2Group4" class="collapse" role="tabpanel" aria-labelledby="headingTwo2Group4" data-parent="#accordionExGroup4">
          <div class="modalHeader helpHeader">
            <h3 class="bold-title">Delete my account</h3>
        </div>  
          <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
            To delete your account, navigate to the account page, found at the top of the screen on laptops and desktops, or in the dropdown menu on mobile or tablet.
             Here, you will be able to view your current details. By pressing the 'Delete Account' button at the bottom, you will open a popup that will ask for confirmation. If you wish to delete your accout, select 'Yes: Delete Account'.
              This will permanently delete your details, and, should you wish to access the app again, you will need to create a new one. We'd be sad to see you go!

            <br><br>
            
            <img src="img/deleteAccount.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :2 -->
    
        <!-- Accordion card :3 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingThree3Group4">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup4" href="#collapseThree3Group4"
              aria-expanded="false" aria-controls="collapseThree3Group4">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              How to logout<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow17"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseThree3Group4" class="collapse" role="tabpanel" aria-labelledby="headingThree3Group4"
            data-parent="#accordionExGroup4">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">How to logout</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                    To logout, the button can be found at the top of the screen on laptops and desktops, or in the dropdown menu on mobile or tablet.
                     Here, you will be able to select the logout button, and you will be returned to the login 
                <br>
                <br>
                <img src="img/logout.png" style="max-width:90%;"/>
            </div>
          </div>
    
        </div>
        <!-- Accordion card :3 -->
        
         <!-- Accordion card :4 -->
        <div class="card helpCard">
    
          <!-- Card header -->
          <div class="card-header helpHead" role="tab" id="headingFour4Group4">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordionExGroup4" href="#collapseFour4Group4"
              aria-expanded="false" aria-controls="collapseFour4Group4">
              <h5 class="mb-0 helpDrop" style="text-align: center">
              How to unsubscribe from email notifications<div style="height:0px;margin-bottom:-2px;"></div><i class="arrow down" id="arrow18"></i>
              </h5>
            </a>
          </div>
    
          <!-- Card body -->
          <div id="collapseFour4Group4" class="collapse" role="tabpanel" aria-labelledby="collapseFour4Group4"
            data-parent="#accordionExGroup4">
            <div class="modalHeader helpHeader">
                <h3 class="bold-title">How to unsubscribe from email notifications</h3>
            </div>
            <div class="card-body helpBody" style="text-align:justify!important;text-align-last:center!important;">  
                To unsubscribe from email notifications, navigate to the account page, found at the top of the screen on laptops and desktops, 
                or in the dropdown menu on mobile or tablet. Here, you will be able to view your current details. By pressing the 'Update Account' button at the bottom, a popup will open where you can enter your new details.
                 Here, there is the option to change whether or not you receive email notifications. Press 'Update', and you're account details will update.

                <br>
               
                <img src="img/updateAccount.png" style="max-width:90%;"/>         
            </div>
          </div>
    
        </div>
        <!-- Accordion card :4 -->
    
      </div>
      <!-- Accordion wrapper -->
    
    <!--Section :6-->
    


</div>

</div>
<!--Andrew's Testing-->

html;
        return $html;
    }
}

?>