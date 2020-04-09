
function toggleRoom(hub_id, room_id, status, room_name){
    let url = "required/on_off_room_function.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "room", hubID: hub_id, id: room_id, stat: status, room_name: room_name},
        success:function(){
            $('#profile-attr').load(document.URL + ' #profile-attr');
            $('#messages-attr').load(document.URL + ' #messages-attr');
        },
        error: function(data){
            alert("error!");
        }
    });
}


function toggleDevice(hub_id, device_id, status, name) {
    let url = "required/on_off_device_function.php";
    
    $.ajax({
        type:'POST',
        url: url,
        data:{ type: "device", hubID: hub_id, id: device_id},
        success:function(data){
            var jsonData = JSON.parse(data);
            switch(jsonData.status){
                case 0:
                    $('#device_'+device_id).animate({backgroundColor: '!important'}, 'slow');
                    $('#device_1_'+device_id).animate({color: 'transparent!important'}, 'slow');
                    $('#device_2_'+device_id).animate({color: ''}, 'slow');
                    $('#device_3_'+device_id).animate({color: ''}, 'slow');

                break;
                case 1:
                    $('#device_'+device_id).animate({backgroundColor: 'rgb(226, 183, 28)!important'}, 'slow');
                    $('#device_1_'+device_id).animate({color: 'rgb(56,56,56)!important'}, 'slow');
                    $('#device_2_'+device_id).animate({color: 'transparent!important'}, 'slow');
                    $('#device_3_'+device_id).animate({color: 'rgb(56,56,56)!important'}, 'slow');
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


