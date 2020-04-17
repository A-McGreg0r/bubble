//------------------------Swipe Function----------------------------------------------------
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


$(document).ready(function(){
    //HIDE VALUES FOR REGISTER AND SIGN IN FORMS
    $("#loginErrorBox").hide();
    $("#registerErrorBox").hide();

    //SETUP ACCOUNT PAGE DEVICE MOVING
    $('select').change(function(){
        let url = "required/action_moveDevice.php";
        let value = $(this).val().split(".");
        let roomId = value[0];
        let deviceId = value[1];
        let roomName = value[2];

        $.ajax({
            type:'POST',
            url: url,
            data:{ room_id: roomId, device_id: deviceId},
            success:function(data){
                //PARSE RESPONSE JSON DATA
                var result = JSON.parse(data);

                //LOGIN ERROR, DISPLAY ERROR TO USER
                if(result.error){
                    alert("Failed to move device: "+result.error);
                }
                if(result.success){
                    // $('#moveDevice_'+deviceId).prop('selectedIndex', 0);

                    $("#currentRoom_"+deviceId).prop('selected', true);
                    $("#currentRoom_"+deviceId).html("Current Room: " + roomName);

                }
            },
            error: function(data){
                alert("Failed to change hub, please try again!");
            }
        });
    });
});

//------------------------Moving Hubs Function----------------------------------------------------

function changeHub(id) {
    let url = "required/action_changeHub.php";
    $.ajax({
        type:'POST',
        url: url,
        data:{ hub_id: id},
        success:function(data){
            //PARSE RESPONSE JSON DATA
            var result = JSON.parse(data);

            //LOGIN ERROR, DISPLAY ERROR TO USER
            if(result.error){
                alert("Failed to change hub, please try again!");
            }
            if(result.success){
                location.reload();
            }
        },
        error: function(data){
            alert("Failed to change hub, please try again!");
        }
    });
}


//------------------------Modal Function----------------------------------------------------
function openModalHome(id){
    event.stopPropagation();
    var id = document.getElementById(id);
    if (id.style.display == "flex") {
        id.style.display = "none";
    } else {
        id.style.display = "flex";
    }
}

function openModalRoom(id, close, open){
    event.stopPropagation();
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
    event.stopPropagation();
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
    var hour = $('#' + hour_value).val();
    var minute = $('#' + minute_value).val();

    let url = "required/action_timer.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ device_id: id, hour: hour, minute: minute},
        success:function(){
            document.getElementById('time_button_text_' + id).style.display = "none";
            document.getElementById('timer-tick-' + id).style.display = "block";
            document.getElementById('timer-tick-' + id).classList.add('animated');
            document.getElementById('timer-tick-' + id).classList.add('slow');
            document.getElementById('timer-tick-' + id).classList.add('zoomIn');
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
    document.getElementById('home_button_text').style.display = "none";
    document.getElementById('home_loader').style.display = "inline-block";
    document.getElementById('home_devices').style.backgroundColor = "rgb(226, 183, 28)";
}

function styleHomeTimer() {
    document.getElementById('timer_none').style.display = "none";
    document.getElementById('timer-tick').style.display = "block";
    document.getElementById('timer-tick').classList.add('animated');
    document.getElementById('timer-tick').classList.add('slow');
    document.getElementById('timer-tick').classList.add('zoomIn');
    setTimeout(function() {
        document.getElementById('timer-tick').classList.remove('zoomIn');
        document.getElementById('timer_none').style.display = "block";
        document.getElementById('timer-tick').style.display = "none";
        $('#modal_timer_home').load(document.URL + ' #content_timer_home');
    }, 2000);
}

function styleRoomTimer(id) {
    document.getElementById('time_button_room_text_' + id).style.display = "none";
    document.getElementById('timer-tick-room-' + id).style.display = "block";
    document.getElementById('timer-tick-room-' + id).classList.add('animated');
    document.getElementById('timer-tick-room-' + id).classList.add('slow');
    document.getElementById('timer-tick-room-' + id).classList.add('zoomIn');
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

    if (document.getElementById(room_id).style.backgroundColor != "rgb(226, 183, 28)"){
        document.getElementById(room_id).style.backgroundColor = "rgb(226, 183, 28)";
    } else {
        document.getElementById(room_id).style.backgroundImage = "linear-gradient(to right, rgb(110, 110, 110) 0%, rgb(110, 110, 110) 100%, transparent 100%)";
    }
    let url = "required/action_device.php";
    
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
    if(device_type == 2 || device_type == 4){
        scaleDevice(hub_id, device_id, current_state);
    } else {
        toggleDevice(hub_id, device_id, current_state);
    }
}

function refreshRoom(room_id) {
    $('#room_reload_' + room_id).load(document.URL + ' #room_reload_' + room_id);
}

function refreshDevice(device_id) {
    $('#reload_' + device_id).load(document.URL + ' #reload_' + device_id);
}

function refreshHomeButton() {
    $('#home_devices').load(document.URL + ' #home_off_content', function(){
        document.getElementById('home_devices').style.backgroundColor = "rgb(110, 110, 110)";
    });
}

function toggleDevice(hub_id, device_id, state) {

    if(state == -1){
        alert("Your device seems to have a fault. Seek repairs or replace device.");
    } else {
        let url = "required/action_device.php";
        document.getElementById('device_1_'+device_id).style.display = "none";
        document.getElementById('loader_'+device_id).style.display = "block";

        if (state == 0){
            document.getElementById('device_'+device_id).style.backgroundColor = "rgb(226, 183, 28)";
        } 
        
        if (state == 4) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(110, 110, 110) 0%, rgb(110, 110, 110) 100%, transparent 100%)";
            $('#modal_' + device_id).load(document.URL + ' #content_timer_' + device_id);
        }
        
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

function scaleDevice(hub_id, device_id, scale) {
    if(scale == -1){
        alert("Your device seems to have a fault. Seek repairs or replace device.");
    } else {
        document.getElementById('device_1_'+device_id).style.display = "none";
        document.getElementById('loader_'+device_id).style.display = "block";

        if (scale == 0){
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 25%, rgb(56,56,56) 25%, rgb(56,56,56) calc(25% + 1px), transparent calc(25% + 1px))";
        }
        if (scale == 1) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 50%, rgb(56,56,56) 50%, rgb(56,56,56) calc(50% + 1px), transparent calc(50% + 1px))";
        } 
        if (scale == 2) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 75%, rgb(56,56,56) 75%, rgb(56,56,56) calc(75% + 1px), transparent calc(75% + 1px))";
        }
        if (scale == 3) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(226, 183, 28) 0%, rgb(226, 183, 28) 100%, transparent 100%)";
        }
        if (scale == 4) {
            document.getElementById('device_'+device_id).style.backgroundImage = "linear-gradient(to right, rgb(110, 110, 110) 0%, rgb(110, 110, 110) 100%, transparent 100%)";
            $('#modal_' + device_id).load(document.URL + ' #content_timer_' + device_id);
        }

        let url = "required/action_device.php";
        if (scale < 4){
            scale = scale + 1;
        } else {
            scale = 0;
        }
        $.ajax({
            type:'POST',
            url: url,
            data:{ type: "scaledevice", hub_id: hub_id, id: device_id, scale: scale},
            success:function(data){
                
            },
            error: function(data){
                alert("error!");
            }
        });
    }
}
//------------------------Device switch Functions----------------------------------------------------



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


function submitImage(){
    var url = "required/action_adddevice.php";
    var video = document.querySelector("#videoElement");
    var loading = document.querySelector("#loading");
    var submitButton = document.querySelector("#submitImage");
    var devicetext = document.querySelector("#devicetext");

    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    var dataQuery = canvas.toDataURL();
    video.style.visibility = "hidden";
    loading.style.visibility = "visible";
    submitButton.style.visibility = "hidden";
    devicetext.innerText = "";

    $.ajax({
        type:'POST',
        url: url,
        data:{ photo: dataQuery},
        success:function(data){
            if(!data || data == "\n"){
                video.style.visibility = "visible";
                loading.style.visibility = "hidden";
                submitButton.style.visibility = "visible";
                devicetext.innerText = "Unable to find a QR code, please try again!";
            }else{
                loading.style.visibility = "hidden";
                devicetext.innerText = data;
            }
        },
        error: function(data){
            video.style.visibility = "visible";
            loading.style.visibility = "hidden";
            submitButton.style.visibility = "visible";
            devicetext.innerText = "Unable to find a QR code, please try again!";

        }
    });
}


