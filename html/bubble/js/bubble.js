
function toggleRoom(room_id){
    let url = "/required/action_device.php?type=room&id=" + room_id;
    let request = new XMLHttpRequest();
    request.open('POST', url, true);
    request.onload = function () {
        
        console.log(request.responseText);
    };

    request.onerror = function () {

    };

    request.send(new FormData(event.target));
    event.preventDefault();
}


function toggleDevice(device_id) {
    alert("Hello! I am an alert box!!");
    let url = "/required/action_device.php?type=device&id=" + device_id;
    let request = new XMLHttpRequest();
    request.open('POST', url, true);
    request.onload = function () {

        console.log(request.responseText);
    };

    request.onerror = function () {

    };

    request.send(new FormData(event.target));
    event.preventDefault();
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

