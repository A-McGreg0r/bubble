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

    var swipe_room = document.getElementById('room-encompass');
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

    var swipe_device = document.getElementById('device-encompass');
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


