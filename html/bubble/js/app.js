
    if('serviceWorker' in navigator && 'PushManager' in window) {
        navigator.serviceWorker.register('/sw.js')
            .then((reg) => console.log('Service Worker Registered', reg))
            .catch((err) => console.log('Service Worker Unavailable', err));
    } else {
        console.warn('Push messaging not supported');
    }

    function registrationEmail(recipient, name) {
        Email.send({
        Host: "smtp.gmail.com",
        Username : "bubblehome.care@gmail.com",
        Password : "TeamBubble6!",
        To : recipient.toString(),
        From : "bubblehome.care@gmail.com",
        Subject : "Welcome to Bubble!",
        Body : "<html><p><strong>Dear "+name.toString()+"</strong></p><p>Welcome to Bubble, the simple smart home!</p><p>Kind Regards,<br/>The Bubble Team</html>",
        }).then(
            message => alert("mail sent successfully")
        );
    }

/*
 function notify() {
      if (!("Notification" in window)) {
          alert("This browser does not support desktop notification");
      }
    
     else if (Notification.permission === "granted") {
      //If it's okay let's create a notification
     push();
   alert("Granted already");
     }
  
     else if (Notification.permission !== "denied") {
         Notification.requestPermission().then(function (permission) {
             // If the user accepts, let's create a notification
             if (permission === "granted") {
                 push();
                 alert("Granted");
             }
         });
     }
 }

 function push() {
     let notify = new Notification("Welcome back!");
 }
function displayNotification() {
    if (Notification.permission == 'granted') {
        navigator.serviceWorker.getRegistration().then(function(reg) {
            let options = {
                body: 'Here is a notification body!',
                icon: 'images/example.png',
                vibrate: [100, 50, 100],
                data: {
                    dateOfArrival: Date.now(),
                    primaryKey: 1
                },
                actions: [
                    {action: 'explore', title: 'Explore this new world',
                        icon: 'images/checkmark.png'},
                    {action: 'close', title: 'Close notification',
                        icon: 'images/xmark.png'},
                ]
            };
            reg.showNotification('Hello world!', options);
        });
    }
}
*/
