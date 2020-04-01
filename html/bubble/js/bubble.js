
function toggleRoom(hub_id, room_id, status){
    let url = "required/action_device.php";

    var on_or_off = "on";
    if(status == 1) {
        on_or_off = "off";
    }
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "room", hubID: hub_id, id: room_id, stat: status},
        success:function(){
            alert(room_id + "turned " + on_or_off)
        },
        error: function(data){
            alert("error!");
        }
    });
}


function toggleDevice(hub_id, device_id) {
    let url = "required/action_device.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "device", hubID: hub_id, id: device_id},
        success:function(data){
            var jsonData = JSON.parse(data);
            switch(jsonData.status){
                case 0:
                    $('#device_'+device_id).animate({backgroundColor: ''}, 'slow');

                break;
                case 1:
                    $('#device_'+device_id).animate({backgroundColor: '#e2b71c'}, 'slow');

                break;
            }
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


