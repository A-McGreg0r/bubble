if('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/sw.js')
        .then((reg) => console.log('Service Worker Registered', reg))
        .catch((err) => console.log('Service Worker Unavailable', err));
} else {
    console.warn('Push messaging not supported');
}





// function notify() {
//     // if (!("Notification" in window)) {
//     //     alert("This browser does not support desktop notification");
//     // }
    
//     else if (Notification.permission === "granted") {
//     // If it's okay let's create a notification
//         //push();
//         //alert("Granted already");
//     }
  
//     else if (Notification.permission !== "denied") {
//         Notification.requestPermission().then(function (permission) {
//             // If the user accepts, let's create a notification
//             if (permission === "granted") {
//                 //push();
//                 //alert("Granted");
//             }
//         });
//     }
// }

// function push() {
//     var notify = new Notification("Welcome back!");
// }