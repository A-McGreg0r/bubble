function propogate(id) {
    event.stopPropagation();
    openModal(id);
}

$( document ).on( "mobileinit", function() {
    $.mobile.loader.prototype.options.disabled = true;
    $.mobile.loadingMessage = false;
    $.mobile.loading().hide();
});

$(window).on("load", function(){
    $("#accordionEx194").on("swipeleft",function(){
        document.getElementById('home-attr').classList.remove("active");
        document.getElementById('advice-attr').classList.add("active");
        document.getElementById('home-tab-attr').classList.remove("active");
        document.getElementById('advice-tab-attr').classList.add("active");
    });
    $("#advice-encompass").on("swipeleft",function(){
        document.getElementById('advice-attr').classList.remove("active");
        document.getElementById('profile-attr').classList.add("active");
        document.getElementById('advice-tab-attr').classList.remove("active");
        document.getElementById('profile-tab-attr').classList.add("active");
    });
    $("#advice-encompass").on("swiperight",function(){
        document.getElementById('advice-attr').classList.remove("active");
        document.getElementById('home-attr').classList.add("active");
        document.getElementById('advice-tab-attr').classList.remove("active");
        document.getElementById('home-tab-attr').classList.add("active");
    });
    $("#room-encompass").on("swipeleft",function(){
        document.getElementById('profile-attr').classList.remove("active");
        document.getElementById('messages-attr').classList.add("active");
        document.getElementById('profile-tab-attr').classList.remove("active");
        document.getElementById('messages-tab-attr').classList.add("active");
    });
    $("#room-encompass").on("swiperight",function(){
        document.getElementById('profile-attr').classList.remove("active");
        document.getElementById('advice-attr').classList.add("active");
        document.getElementById('profile-tab-attr').classList.remove("active");
        document.getElementById('advice-tab-attr').classList.add("active");
    });
    $("#device-encompass").on("swiperight",function(){
        document.getElementById('messages-attr').classList.remove("active");
        document.getElementById('profile-attr').classList.add("active");
        document.getElementById('messages-tab-attr').classList.remove("active");
        document.getElementById('profile-tab-attr').classList.add("active");
    });
});



function openModal(id) {
    var modal = document.getElementById(id);
    if (modal && modal.style) {
        if (modal.style.display == "block") {
            modal.style.display = "none";
          } else {
            modal.style.display = "block";
          }
    }
}

function startTimer(id, hour_value, minute_value) {
    var hour = $('#' + hour_value).val();
    var minute = $('#' + minute_value).val();

    let url = "required/action_timer.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ device_id: id, hour: hour, minute: minute},
        success:function(){
            $('#profile-attr').load(document.URL + ' #profile-attr');
            $('#messages-attr').load(document.URL + ' #messages-attr');
        },
        error: function(data){
            alert("error!");
        }
    });
}

function toggleRoom(hub_id, room_id){
    let url = "required/action_device.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "room", hub_id: hub_id, id: room_id},
        success:function(){
            $('#profile-attr').load(document.URL + ' #profile-attr');
            $('#messages-attr').load(document.URL + ' #messages-attr');
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
        toggleDevice(hub_id, device_id);
    }
}

function toggleDevice(hub_id, device_id) {
    let url = "required/action_device.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "toggledevice", hub_id: hub_id, id: device_id},
        success:function(data){
            $('#profile-attr').load(document.URL + ' #profile-attr');
            $('#messages-attr').load(document.URL + ' #messages-attr');
        },
        error: function(data){
            alert("error!");
        }
    });
}

function scaleDevice(hub_id, device_id, scale) {
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
            $('#profile-attr').load(document.URL + ' #profile-attr');
            $('#messages-attr').load(document.URL + ' #messages-attr');
        },
        error: function(data){
            alert("error!");
        }
    });
}

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


