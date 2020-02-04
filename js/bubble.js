
function toggleRoom(room_id){
    var url = "/required/action_device.php?type=room&id="+room_id;
    var request = new XMLHttpRequest();
    request.open('POST', url, true);
    request.onload = function() { 
        
        console.log(request.responseText);
    };

    request.onerror = function() {

    };

    request.send(new FormData(event.target));
    event.preventDefault();
}


function toggleDevice(room_id){
    var url = "/required/action_device.php?type=device&id="+room_id;
    var request = new XMLHttpRequest();
    request.open('POST', url, true);
    request.onload = function() { 
        
        console.log(request.responseText);
    };

    request.onerror = function() {

    };

    request.send(new FormData(event.target));
    event.preventDefault();
}


function submitImage(){
    var url = "required/action_adddevice.php";
    var video = document.querySelector("#videoElement");
    var image = document.querySelector("#capturedimage");
    var loading = document.querySelector("#loading");
    var submitButton = document.querySelector("#submitImage");
    var devicetext = document.querySelector("#devicetext");

    var canvas = document.createElement("canvas");
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    var img = document.createElement("img");
    img.src = canvas.toDataURL();
    image.prepend(img);
    var dataQuery = canvas.toDataURL();
    video.style.visibility = "hidden";
    loading.style.visibility = "visible";
    submitButton.style.visibility = "hidden";

    $.ajax({
        type:'POST',
        url: url,
        data:{ photo: dataQuery},
        success:function(data){
            loading.style.visibility = "hidden";
            devicetext.innerHTML = "<p>"+data+"</p>";
        },
        error: function(data){
            video.style.visibility = "visible";
            loading.style.visibility = "hidden";
            submitButton.style.visibility = "visible";
            devicetext.innerHTML = "Unable to find a QR code, please try again!";

        }
    });
}

