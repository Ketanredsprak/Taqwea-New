var firebaseConfig = {
    apiKey: apiKey,
    projectId: projectId,
    messagingSenderId: senderId,
    appId: appId,
};
// Initialize Firebase
if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
 }else {
    firebase.app(); // if already initialized, use that one
 }

const messaging = firebase.messaging();

function initFirebaseMessagingRegistration() {
    navigator.serviceWorker.register(swUrl)
    .then(function(registration) {
        messaging.requestPermission().then(function () {
            return messaging.getToken({
                serviceWorkerRegistration: registration
            });
        }).then(function(token) {
            axios.post(process.env.MIX_APP_URL + '/users/'+userId+'/update-token',{
                _method:"PATCH",
                token
            }).then(({data})=>{
                console.log(data)
            }).catch(({response:{data}})=>{
                console.error(data)
            })
        }).catch(function (err) {
            console.log(`Token Error :: ${err}`);
        });
    });
}
if (!deviceId) {
    initFirebaseMessagingRegistration();
}

messaging.onMessage(function(data){
   // userId
    if(data.data.user_id == userId) {
        $(".chat-header").addClass('chat-info');
    } else {
        $('#notiDrop').addClass('status-info');
    }
    new Notification(
        data.notification.title,
        {
            body:data.notification.body,
            data: data,
            icon: process.env.MIX_APP_URL+"/assets/images/logo-frontend.png",
        }
    ).onclick = function(event) {
        if(event.target.data.data.url) {
            window.location.href = event.target.data.data.url
        }
        
    };
});

