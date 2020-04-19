
//------------------------DOCUMENT READY----------------------------------------------------
/**
 * THIS FUNCTION IS CALLED WHEN THE DOCUMENT IS SET TO A READY STATE.
 * THAT MEANS IT CAN BE USED TO EASILY ATTACH EVENT HANDLERS
 */
$(document).ready(function(){
    //HIDE VALUES FOR REGISTER AND SIGN IN FORMS
    $("#loginErrorBox").hide();
    $("#registerErrorBox").hide();

    //SETUP ACCOUNT PAGE DEVICE MOVING.
    /**
     * USE JQUERY SELECTORS TO FIND DROP DOWN BOXES THAT START WITH THE moveDevice NAME.
     * THEN, ATTACH EVENT LISTENER THAT TRIGGERS WHEN AN OPTION IS PICKED
     */
    $('select[name^="moveDevice_"]').change(function(){
        let url = "required/action_moveDevice.php";
        //GATHER DATA FROM THE DROPDOWN BOX
        let value = $(this).val().split(".");
        let roomId = value[0];
        let deviceId = value[1];
        let roomName = value[2];

        //CREATE AJAX CALL
        $.ajax({
            type:'POST',
            url: url,
            data:{ room_id: roomId, device_id: deviceId},
            success:function(data){
                //PARSE RESPONSE JSON DATA
                var result = JSON.parse(data);

                //ERROR, DISPLAY ERROR TO USER
                if(result.error){
                    alert("Failed to move device: "+result.error);
                }
                if(result.success){
                    //MOVE SUCCESS, CHANGE CURRENT ROOM SHOWN
                    $("#currentRoom_"+deviceId).prop('selected', true);
                    $("#currentRoom_"+deviceId).html("Current: " + roomName);
                }
            },
            error: function(data){
                alert("Failed to change hub, please try again!");
            }
        });
    });

    //HANDLE CLOSING THE CAMERA WHEN THE ADD DEVICE MODAL IS CLOSED
    $('#addDeviceModal').on('hidden.bs.modal', function () {
        closeCamera();
    });

});

//------------------------DOCUMENT READY----------------------------------------------------


//------------------------Swipe Function----------------------------------------------------

//Found with the help of http://www.javascriptkit.com/javatutors/touchevents2.shtml
function swipedetect(el, callback){
  
    var touchsurface = el,
    swipedir,
    startX,
    startY,
    distX,
    distY,
    threshold = 150, //required min distance traveled to be considered swipe
    restraint = 100, // maximum distance allowed at the same time in perpendicular direction
    allowedTime = 300, // maximum time allowed to travel that distance
    elapsedTime,
    startTime,
    handleswipe = callback || function(swipedir){}
  
    touchsurface.addEventListener('touchstart', function(e){
        var touchobj = e.changedTouches[0];
        swipedir = 'none';
        dist = 0;
        startX = touchobj.pageX;
        startY = touchobj.pageY;
        startTime = new Date().getTime(); // record time when finger first makes contact with surface
    }, false);
  
    touchsurface.addEventListener('touchend', function(e){
        var touchobj = e.changedTouches[0];
        distX = touchobj.pageX - startX; // get horizontal dist traveled by finger while in contact with surface
        distY = touchobj.pageY - startY; // get vertical dist traveled by finger while in contact with surface
        elapsedTime = new Date().getTime() - startTime; // get time elapsed
        if (elapsedTime <= allowedTime){ // first condition for awipe met
            if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint){ // 2nd condition for horizontal swipe met
                swipedir = (distX < 0)? 'left' : 'right'; // if dist traveled is negative, it indicates left swipe
            }
        }
        handleswipe(swipedir);
    }, false);
}

$( document ).on( "mobileinit", function() {
    $.mobile.loader.prototype.options.disabled = true;
    $.mobile.loadingMessage = false;
    $.mobile.loading().hide();
});

$(window).on("load", function(){
    var overview = document.getElementById('top-buttons');

    swipedetect(overview, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        if (swipedir =='left') {
            document.getElementById('home-attr').classList.remove("active");
            document.getElementById('advice-attr').classList.add("active");
            document.getElementById('home-tab-attr').classList.remove("active");
            document.getElementById('advice-tab-attr').classList.add("active");
        }
    });

    var overview = document.getElementById('overview');

    swipedetect(overview, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        if (swipedir =='left') {
            document.getElementById('home-attr').classList.remove("active");
            document.getElementById('advice-attr').classList.add("active");
            document.getElementById('home-tab-attr').classList.remove("active");
            document.getElementById('advice-tab-attr').classList.add("active");
        }
    });

    var graph = document.getElementById('graph');

    swipedetect(graph, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        if (swipedir =='left') {
            document.getElementById('home-attr').classList.remove("active");
            document.getElementById('advice-attr').classList.add("active");
            document.getElementById('home-tab-attr').classList.remove("active");
            document.getElementById('advice-tab-attr').classList.add("active");
        }
    });

    var swipe_advice = document.getElementById('advice-encompass');
    swipedetect(swipe_advice, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        if (swipedir =='left') {
            document.getElementById('advice-attr').classList.remove("active");
            document.getElementById('profile-attr').classList.add("active");
            document.getElementById('advice-tab-attr').classList.remove("active");
            document.getElementById('profile-tab-attr').classList.add("active");
        }
        if (swipedir =='right') {
            document.getElementById('advice-attr').classList.remove("active");
            document.getElementById('home-attr').classList.add("active");
            document.getElementById('advice-tab-attr').classList.remove("active");
            document.getElementById('home-tab-attr').classList.add("active");
        }
    });
    var swipe_room = document.getElementById('profile-attr');
    swipedetect(swipe_room, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        if (swipedir =='left') {
            document.getElementById('profile-attr').classList.remove("active");
            document.getElementById('messages-attr').classList.add("active");
            document.getElementById('profile-tab-attr').classList.remove("active");
            document.getElementById('messages-tab-attr').classList.add("active");
        }
        if (swipedir =='right') {
            document.getElementById('profile-attr').classList.remove("active");
            document.getElementById('advice-attr').classList.add("active");
            document.getElementById('profile-tab-attr').classList.remove("active");
            document.getElementById('advice-tab-attr').classList.add("active");
        }
    });

    
    var swipe_device = document.getElementById('messages-attr');
    swipedetect(swipe_device, function(swipedir){
        // swipedir contains either "none", "left", "right", "top", or "down"
        if (swipedir =='right') {
            document.getElementById('messages-attr').classList.remove("active");
            document.getElementById('profile-attr').classList.add("active");
            document.getElementById('messages-tab-attr').classList.remove("active");
            document.getElementById('profile-tab-attr').classList.add("active");
        }
    });
});
//------------------------Swipe Function----------------------------------------------------

//------------------------Moving Hubs Function----------------------------------------------------

function changeHub(id) {
    //MAKE AJAX REQUEST TO ACTION_CHANGEHUB
    let url = "required/action_changeHub.php";
    $.ajax({
        type:'POST',
        url: url,
        data:{ hub_id: id},
        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //CHANGE HUB ERROR, DISPLAY ERROR TO USER
            if(result.error){
                alert("Failed to change hub, please try again!");
            }
            //HUB CHANGE SUCCESSFUL, REFRESH PAGE
            if(result.success){
                location.reload();
            }
        },
        error: function(data){
            alert("Failed to change hub, please try again!");
        }
    });
}
//------------------------Moving Hubs Function----------------------------------------------------


//------------------------Modal Functions----------------------------------------------------
function openModalHome(id){
    //Prevent parent onclick events
    event.stopPropagation();

    //Change display of modal
    var id = document.getElementById(id);
    if (id.style.display == "flex") {
        id.style.display = "none";
    } else {
        id.style.display = "flex";
    }
}

function openModalRoom(id, close, open){
    //Prevent parent onclick events
    event.stopPropagation();

    //Change display of modal
    var id = document.getElementById(id);
    var close = document.getElementById(close);
    var open = document.getElementById(open);
    close.style.display = "none";
    open.style.display = "flex";
    if (id.style.display == "flex") {
        id.style.display = "none";
    } else {
        id.style.display = "flex";
    }
}

function openModal(id, x) {
    //Prevent parent onclick events
    event.stopPropagation();

    //Change display of modal
    var modal = document.getElementById(id);
    var x = document.getElementById(x);
    if (modal && modal.style) {
        if (modal.style.display == "flex") {
            modal.style.display = "none";
          } else {
            modal.style.display = "flex";
            x.style.display = "flex";
          }
    }
}
//------------------------Modal Function----------------------------------------------------

//------------------------Timer Function----------------------------------------------------
function startTimer(id, hour_value, minute_value) {
    //Get value from hour : minute form
    var hour = $('#' + hour_value).val();
    var minute = $('#' + minute_value).val();

    let url = "required/action_timer.php";
    
    //Call timer script
    $.ajax({
        type:'POST',
        url: url,
        data:{ device_id: id, hour: hour, minute: minute},
        success:function(){
            //Animation for tick
            document.getElementById('time_button_text_' + id).style.display = "none";
            document.getElementById('timer-tick-' + id).style.display = "block";
            document.getElementById('timer-tick-' + id).classList.add('animated');
            document.getElementById('timer-tick-' + id).classList.add('slow');
            document.getElementById('timer-tick-' + id).classList.add('zoomIn');
            //Wait 2 seconds until animation is over, then reset timer
            setTimeout(function() {
                document.getElementById('timer-tick-' + id).classList.remove('zoomIn');
                document.getElementById('time_button_text_' + id).style.display = "block";
                document.getElementById('timer-tick-' + id).style.display = "none";
                $('#timer_end_' + id).load(document.URL + ' #timer_end_' + id);
            }, 2000);
        },
        error: function(data){
            alert("error!");
        }
    });
}
//------------------------Timer Function----------------------------------------------------

//------------------------Device switch Functions----------------------------------------------------
function styleHome() {
    //Set loader spinning on click and set background colour
    document.getElementById('home_button_text').style.display = "none";
    document.getElementById('home_loader').style.display = "inline-block";
    document.getElementById('home_devices').style.backgroundColor = "rgb(226, 183, 28)";
}

function styleHomeTimer() {
    //Animate tick when timer set
    document.getElementById('timer_none').style.display = "none";
    document.getElementById('timer-tick').style.display = "block";
    document.getElementById('timer-tick').classList.add('animated');
    document.getElementById('timer-tick').classList.add('slow');
    document.getElementById('timer-tick').classList.add('zoomIn');
    //Wait two seconds for animation then reset timer
    setTimeout(function() {
        document.getElementById('timer-tick').classList.remove('zoomIn');
        document.getElementById('timer_none').style.display = "block";
        document.getElementById('timer-tick').style.display = "none";
        $('#modal_timer_home').load(document.URL + ' #content_timer_home');
    }, 2000);
}

function styleRoomTimer(id) {
    //Animate tick when timer set
    document.getElementById('time_button_room_text_' + id).style.display = "none";
    document.getElementById('timer-tick-room-' + id).style.display = "block";
    document.getElementById('timer-tick-room-' + id).classList.add('animated');
    document.getElementById('timer-tick-room-' + id).classList.add('slow');
    document.getElementById('timer-tick-room-' + id).classList.add('zoomIn');
    //Wait two seconds for animation then reset timer
    setTimeout(function() {
        document.getElementById('timer-tick-room-' + id).classList.remove('zoomIn');
        document.getElementById('time_button_room_text_' + id).style.display = "block";
        document.getElementById('timer-tick-room-' + id).style.display = "none";
        $('#modal_room_' + id).load(document.URL + ' #content_room_timer_' + id);
    }, 2000);
}

function toggleRoom(hub_id, room_id){
    document.getElementById('room_setting_'+room_id).style.display = "none";
    document.getElementById('room_loader_'+room_id).style.display = "block";

    //Set background colour to match new setting
    if (document.getElementById(room_id).style.backgroundColor != "rgb(226, 183, 28)"){
        document.getElementById(room_id).style.backgroundColor = "rgb(226, 183, 28)";
    } else {
        document.getElementById(room_id).style.backgroundImage = "linear-gradient(to right, rgb(110, 110, 110) 0%, rgb(110, 110, 110) 100%, transparent 100%)";
    }
    let url = "required/action_device.php";
    
    //Call action device to toggle room
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "room", hub_id: hub_id, id: room_id},
        success:function(){
            
        },
        error: function(data){
            alert("error!");
        }
    });
}

function alterDevice(hub_id, device_id, device_type, current_state){
    //If fad switch send to scale device, if not then toggle device
    if(device_type == 2 || device_type == 4){
        scaleDevice(hub_id, device_id, current_state);
    } else {
        toggleDevice(hub_id, device_id, current_state);
    }
}

function refreshRoom(room_id) {
    //Refresh room
    $('#room_reload_' + room_id).load(document.URL + ' #room_reload_' + room_id);
}

function refreshDevice(device_id) {
    //Refresh device
    $('#reload_' + device_id).load(document.URL + ' #reload_' + device_id);
}

function refreshDevices() {
    //Refresh device
    $('#device-encompass').load(document.URL + ' #device-encompass');
}


function refreshHomeButton() {
    //Refresh home button and reset background colour
    $('#home_devices').load(document.URL + ' #home_off_content', function(){
        document.getElementById('home_devices').style.backgroundColor = "rgb(110, 110, 110)";
    });
}

//Function to turn devices on/off
function toggleDevice(hub_id, device_id, state) {

    //If device has fault return alert
    if(state == -1){
        alert("Your device seems to have a fault. Seek repairs or replace device.");
    } else {
        
        let url = "required/action_device.php";
        document.getElementById('device_1_'+device_id).style.display = "none";
        document.getElementById('loader_'+device_id).style.display = "block";

        //Style device button to match new setting
        if (state == 0){
            document.getElementById('device_'+device_id).style.backgroundColor = "rgb(226, 183, 28)";
        } 
        
        if (state == 4) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(110, 110, 110) 0%, rgb(110, 110, 110) 100%, transparent 100%)";
            $('#modal_' + device_id).load(document.URL + ' #content_timer_' + device_id);
        }
        
        //Call action_device to toggle device
        $.ajax({
            type:'POST',
            url: url,
            data:{ type: "toggledevice", hub_id: hub_id, id: device_id, state: state},
            success:function(data){
                
            },
            error: function(data){
                alert("error!");
            }
        });
    }
}

function scaleDevice(hub_id, device_id, state) {

    //If device has fault then return alert
    if(state == -1){
        alert("Your device seems to have a fault. Seek repairs or replace device.");
    } else {
        document.getElementById('device_1_'+device_id).style.display = "none";
        document.getElementById('loader_'+device_id).style.display = "block";

        //Style button to match new setting
        if (state == 0){
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 25%, rgb(56,56,56) 25%, rgb(56,56,56) calc(25% + 1px), transparent calc(25% + 1px))";
        }
        if (state == 1) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 50%, rgb(56,56,56) 50%, rgb(56,56,56) calc(50% + 1px), transparent calc(50% + 1px))";
        } 
        if (state == 2) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 75%, rgb(56,56,56) 75%, rgb(56,56,56) calc(75% + 1px), transparent calc(75% + 1px))";
        }
        if (state == 3) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 100%, transparent 100%)";
        }
        if (state == 4) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(110, 110, 110) 0%, rgb(110, 110, 110) 100%, transparent 100%)";
            $('#modal_' + device_id).load(document.URL + ' #content_timer_' + device_id);
        }

        let url = "required/action_device.php";
        //Set new state
        if (state < 4){
            state = state + 1;
        } else {
            state = 0;
        }

        //Call action_device to toggle fade device
        $.ajax({
            type:'POST',
            url: url,
            data:{ type: "scaledevice", hub_id: hub_id, id: device_id, state: state},
            success:function(data){
                
            },
            error: function(data){
                alert("error!");
            }
        });
    }
}
//------------------------Device switch Functions----------------------------------------------------

//------------------------ROOM RELATED FUNCTIONS----------------------------------------------------
function addRoomModalSubmit(){
    //CHANGE DISPLAY TO BE WAITING
    $("#roomErrorDisplay").html("");
    $("#roomFormName").attr("disabled", true);
    $("#roomFormIcon").attr("disabled", true);

    //GATHER REQUIRED DATA
    let url = "required/action_addRoom.php";
    var room_name = $("#roomFormName").val();
    var roomIcon = $("#roomFormIcon").val();

    //SEND AJAX REQUEST
    $.ajax({
        type:'POST',
        url: url,
        data:{ roomName: room_name, icon: roomIcon},
        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //ADD ROOM ERROR, DISPLAY ERROR TO USER
            if(result.error){
                $("#roomErrorDisplay").html(result.error);
                $("#roomFormName").removeAttr("disabled");
                $("#roomFormIcon").removeAttr("disabled");
            }
            //ADD ROOM SUCCESS
            if(result.success){
                $('#room-encompass').load(document.URL + ' #room-encompass');
                $('#addRoomModal').modal("hide");
                $("#roomFormName").removeAttr("disabled");
                $("#roomFormIcon").removeAttr("disabled");
                $("#roomFormName").val("");
                $("#roomFormIcon").val("");
            }
        },
        error: function(data){
            //INTERNAL SERVER ERROR HAS OCCURRED
            $("#roomErrorDisplay").html("An unexpected error has occurred, please try again");
            $("#roomFormName").removeAttr("disabled");
            $("#roomFormIcon").removeAttr("disabled");
        }
    });
}

function confirmDeleteRoomModalConfirm(room_id){
    //CHANGE DISPLAY TO BE WAITING
    $("#confirmDeleteRoomModalButton").attr("disabled", true);

    //GATHER REQUIRED DATA
    let url = "required/action_removeRoom.php";

    //SEND AJAX REQUEST
    $.ajax({
        type:'POST',
        url: url,
        data:{ roomId: room_id},
        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //REMOVE ROOM ERROR, DISPLAY ERROR TO USER
            if(result.error){
                alert(result.error);
                $("#confirmDeleteRoomModalButton").removeAttr("disabled");
            }
            //REMOVE ROOM SUCCESS
            if(result.success){
                $("#confirmDeleteRoomModalButton").removeAttr("disabled");
                $('#confirmDeleteRoom_'+room_id).modal("hide");
                $('#room-encompass').load(document.URL + ' #room-encompass');
            }
        },
        error: function(data){
            //INTERNAL SERVER ERROR HAS OCCURRED
            alert("An unexpected error has occured, please try again");
            $("#confirmDeleteRoomModalButton").removeAttr("disabled");
        }
    });
}

//------------------------\ROOM RELATED FUNCTIONS----------------------------------------------------


//------------------------DEVICE RELATED FUNCTIONS----------------------------------------------------

function confirmDeleteDeviceModalConfirm(device_id){
    //CHANGE DISPLAY TO BE WAITING
    $("#confirmDeleteDeviceModalButton").attr("disabled", true);

    //GATHER REQUIRED DATA
    let url = "required/action_removeDevice.php";

    //SEND AJAX REQUEST
    $.ajax({
        type:'POST',
        url: url,
        data:{ deviceId: device_id},
        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //REMOVE DEVICE ERROR, DISPLAY ERROR TO USER
            if(result.error){
                alert(result.error);
                $("#confirmDeleteDeviceModalButton").removeAttr("disabled");
            }
            //REMOVE DEVICE SUCCESS
            if(result.success){
                $("#confirmDeleteDeviceModalButton").removeAttr("disabled");
                $('#confirmDeleteDevice_'+device_id).modal().hide();
                $('#device-encompass').load(document.URL + ' #device-encompass');
                $('#deviceList').load(document.URL + ' #deviceList');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
        },
        error: function(data){
            //INTERNAL SERVER ERROR HAS OCCURRED
            alert("An unexpected error has occured, please try again");
            $("#confirmDeleteDeviceModalButton").removeAttr("disabled");
        }
    });
}

//------------------------\DEVICE RELATED FUNCTIONS----------------------------------------------------


//------------------------Login functions----------------------------------------------------

function sendLoginRequest(){
    //CHANGE DISPLAY TO BE WAITING
    $("#loginErrorBox").hide();
    $("#materialLoginFormEmail").attr("disabled", true);
    $("#materialLoginFormPassword").attr("disabled", true);

    //GATHER REQUIRED DATA
    let url = "required/action_login.php";
    var userEmail = $("#materialLoginFormEmail").val();
    var userPassword = $("#materialLoginFormPassword").val();

    //SEND AJAX REQUEST
    $.ajax({
        type:'POST',
        url: url,
        data:{ email: userEmail, password: userPassword},
        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //LOGIN ERROR, DISPLAY ERROR TO USER
            if(result.error){
                $("#materialLoginFormPassword").val("");
                $("#loginErrorDisplay").html(result.error);
                $("#loginErrorBox").hide().fadeIn(500);
                $("#materialLoginFormEmail").removeAttr("disabled");
                $("#materialLoginFormPassword").removeAttr("disabled");
            }
            //LOGIN SUCCESS
            if(result.success){
                location.reload();
            }
        },
        error: function(data){
            //INTERNAL SERVER ERROR HAS OCCURRED
            $("#loginErrorDisplay").html("An unexpected error has occurred, please try again");
            $("#loginErrorBox").hide().fadeIn(500);
            $("#materialLoginFormEmail").removeAttr("disabled");
            $("#materialLoginFormPassword").removeAttr("disabled");
        }
    });
}

function sendRegisterRequest(){
    //CHANGE DISPLAY TO BE WAITING
    $("#registerErrorBox").hide();

    //GATHER REQUIRED DATA
    let url = "required/action_register.php";

    var userEmail = $("#materialRegisterFormEmail").val();
    var userFirstName = $("#materialRegisterFormFirstName").val();
    var userLastName = $("#materialRegisterFormLastName").val();
    var userAddress1 = $("#materialRegisterFormAddress_l1").val();
    var userAddress2 = $("#materialRegisterFormAddress_l2").val();
    var userPostcode = $("#materialRegisterFormPostcode").val();
    var userPassword1 = $("#materialRegisterFormPassword1").val();
    var userPassword2 = $("#materialRegisterFormPassword2").val();
    var userEnergyCost = $("#registerFormEnergyCost").val();
    var userBudget = $("#registerFormBudget").val();
    var userAllowEmails = $("#registerFormAllowEmails").val();

    //SEND AJAX REQUEST
    $.ajax({
        type:'POST',
        url: url,
        data:{ email: userEmail, first_name: userFirstName, last_name: userLastName, address_l1: userAddress1, 
            address_l2: userAddress2, postcode: userPostcode, pass1: userPassword1, pass2: userPassword2,
            energy_cost: userEnergyCost, budget: userBudget, allow_emails: userAllowEmails},

        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //LOGIN ERROR, DISPLAY ERROR TO USER
            if(result.error){
                $("#registerErrorDisplay").html(result.error);
                $("#registerErrorBox").hide().fadeIn(500);
            }
            if(result.success){
                $("#modalUserName").html("Hi " + userFirstName + "!");
                $("#registrationSuccessModal").modal();
            }
        },
        error: function(data){
            //INTERNAL SERVER ERROR HAS OCCURRED
            $("#registerErrorDisplay").html("An unexpected error has occurred, please try again");
            $("#registerErrorBox").hide().fadeIn(500);
        }
    });
}



//------------------------Login functions----------------------------------------------------

//------------------------Qr code functions----------------------------------------------------

function openCamera(){
    //GET PAGE ELEMENTS FOR USE LATER
    var video = document.querySelector("#videoElement");
    var loading = document.querySelector("#loading");
    var submitButton = document.querySelector("#submitImage");
    var devicetext = document.querySelector("#devicetext");
    
    devicetext.innerText = "";
    video.style.visibility = "visible";
    loading.style.visibility = "hidden";
    submitButton.style.visibility = "visible";

    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia(
            { video: true }
        ).then(function (stream) {
            video.srcObject = stream;
        })
        .catch(function (err) {
        console.log("Something went wrong!");
        });
    }
}

function closeCamera(){
    var video = document.querySelector("#videoElement");

    video.srcObject.getTracks()[0].stop();
}

function submitImage(){
    //SUBMIT IMAGE FROM ADD DEVICE PAGE
    var url = "required/action_addDevice.php";
    
    //GET PAGE ELEMENTS FOR USE LATER
    var video = document.querySelector("#videoElement");
    var loading = document.querySelector("#loading");
    var submitButton = document.querySelector("#submitImage");
    var devicetext = document.querySelector("#devicetext");

    //GET THE CURRENT PIXELS FROM THE CANVAS(THE VIDEO FEED)
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    
    //STORE IMAGE DATA IN BASE64 STRING, THIS STRING WILL BE SENT TO SERVER
    var dataQuery = canvas.toDataURL();
    
    //SET PAGE FEATURES TO INVISIBLE/SHOWN, TELL USER THEIR IMAGE IS BEING PROCESSED AND TO WAIT
    video.style.visibility = "hidden";
    loading.style.visibility = "visible";
    submitButton.style.visibility = "hidden";
    devicetext.innerText = "";

    //CREATE AJAX CALL
    $.ajax({
        type:'POST',
        url: url,
        data:{ photo: dataQuery},
        success:function(data){
            //SENDING DATA WAS SUCCESSFUL, BUT CHECK WHAT SERVER SAID ABOUT IMAGE
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            if(result.error){
                //CANNOT FIND QR CODE INSIDE IMAGE
                video.style.visibility = "visible";
                loading.style.visibility = "hidden";
                submitButton.style.visibility = "visible";
                devicetext.innerText = result.error;
            }
            if(result.success){
                //FOUND QR CODE, DISPLAY RESULT TO USER.
                loading.style.visibility = "hidden";
                devicetext.innerText = result.success;
                closeCamera();
                refreshHomeButton();
                refreshDevices();
            }
        },
        error: function(data){
            //THERE WAS A SERVER ERROR OR COMMUNICATION ERROR, TRY AGAIN
            video.style.visibility = "visible";
            loading.style.visibility = "hidden";
            submitButton.style.visibility = "visible";
            devicetext.innerText = "Unable to find a QR code, please try again";

        }
    });
}
