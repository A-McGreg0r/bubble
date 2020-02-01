
function toggleRoom(room_id){
    var url = "/required/device.php?type=room&id="+room_id;
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
