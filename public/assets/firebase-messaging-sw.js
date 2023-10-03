importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: 'AIzaSyAOlJ4guaKg8g-5d4a2tS_0YCUrSGhyPWY',
    projectId: 'taqwea',
    messagingSenderId: '405827243165',
    appId: '1:405827243165:web:ccbfeff8107409a221d874',
});
  
const messaging =  firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});