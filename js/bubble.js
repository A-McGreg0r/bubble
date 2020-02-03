
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

    var canvas = document.createElement("canvas");
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    video.style.visibility = "hidden";
    var img = document.createElement("img");
    img.src = canvas.toDataURL();
    image.prepend(img);
    var dataQuery = canvas.toDataURL();
    loading.style.visibility = "visible";
    $.ajax({
        type:'POST',
        url: url,
        data:dataQuery,
        cache:false,
        processData: false,
        success:function(data){
            loading.style.visibility = "hidden";
            console.log(data);
        },
        error: function(data){
            console.log(data);
        }
    });
}

