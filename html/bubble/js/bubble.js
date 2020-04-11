function propogate(id) {
    event.stopPropagation();
    openModal(id);
}

function openModal(id) {
    var modal = document.getElementById(id);
    if (modal && modal.style) {
        if(modal.style.display == 'none'){
            modal.style.display = 'block';
            setTimeout(function () {
                modal.style.maxHeight = '100%';
            }, 1);
        } else {
            modal.style.display = 'none';
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


