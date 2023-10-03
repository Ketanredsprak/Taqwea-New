var timeinterval;
function getTimeRemaining(endtime){
    let endTime = moment.utc(endtime).local();
    let total = Date.parse(endTime) - Date.parse(new Date());
    let seconds = Math.floor( (total/1000) % 60 );
    let minutes = Math.floor( (total/1000/60) % 60 );
    let hours = Math.floor( (total/(1000*60*60)) % 24 );
    
    hours = (String(hours).length >= 2) ? hours : '0' + hours;
    minutes = (String(minutes).length >= 2) ? minutes : '0' + minutes;
    seconds = (String(seconds).length >= 2) ? seconds : '0' + seconds;
  
    return {
      total,
      hours,
      minutes,
      seconds
    };
}

function initializeClock(endtime) {
    const clock = document.getElementById('class-timer');
    timeinterval = setInterval(() => {
      const t = getTimeRemaining(endtime);
      clock.innerHTML = t.hours +  ':' + t.minutes + ':' + t.seconds;
      if (t.total <= 0) {
        clearInterval(timeinterval);
        completeBooking();
      }
    },1000);
}
initializeClock(endTime);

var whiteWebSdk = new WhiteWebSdk({
    appIdentifier: appIdentifier,
    region: region
});
function initializeWhiteBoard()
{  
    var joinRoomParams = {
        uuid: uuId,
        roomToken: roomToken,
        isWritable: false,
        disableDeviceInputs: false,
        disableCameraTransform: true
    };
            
    // Join the whiteboard room and display the whiteboard on the web page.
    whiteWebSdk.joinRoom(joinRoomParams).then(function(room) {
        room.bindHtmlElement(document.getElementById("whiteboard"));
        room.setViewMode('Follower');        
    }).catch(function(err) {
        console.error(err);
    });
}
$(function() {
    $('#whiteBox').hide();

    window.userAside = function() {
        $('.videoBox-right').addClass('open');
    }

    window.closeAside = function() {
        $('.videoBox-right').removeClass('open');
    }

    window.endcallModal = function() {
        $('#endcallModal').modal('show');
    }

    window.extrachargeModal = function() {
        $('#extrachargeModal').modal('show');
    }

    let rtc = {
        localAudioTrack: null,
        localVideoTrack: null,
        client: null,
        selectedMicrophoneId: null,
        selectedCameraId: null
    };
    
    let options = {
        appId: appId,
        channel: channelName,
        token: token,
        uid: uid
    };

    let tutor = {
        name: "",
        profile_image: ""
    }

    let otherStudent = {
        id: null,
        name: "",
        profile_image: "",
        hasStream: false
    }

    let hosts = {
        tutor: {
            tutor_id: tutorId,
            has_video: true,
            has_audio: true
        },
        student: {
            student_id: null,
            has_video: false,
            has_audio: false
        },
        class_id: classId
    };
    
    function getUserProfile(userId, addToParticipants = true)
    {
        $.ajax({
            url: process.env.MIX_APP_URL + "/users/"+userId,
            type: "GET",
            success: function (response) {
                if (addToParticipants) {
                    addUserIntoParticipants(response.data);
                } else {
                    otherStudent.id = response.data.id;
                    otherStudent.name = response.data.name;
                    otherStudent.profile_image = response.data.profile_image_url;
                    otherStudent.hasStream = true;
                }
            },
            error: function (data) {
                
            },
        });
    }

    function updateUsersCount()
    {
        let connectedUsers = rtc.client.remoteUsers.length + 1;
        $('.participant-count').text(connectedUsers);
    }

    function addUserIntoParticipants(user)
    {
        let userName = user.name;
        if (user.id == uid) {
            userName = user.name + '(Me)';
        }
        if (user.id == tutorId) {
            tutor.name = userName;
            userName = user.name + '('+Lang.get("labels.tutor")+')';
            tutor.profile_image = user.profile_image_url;
        } 

        let nameCard = '<li id="list-item'+ user.id +'">'+
            '<a href="javascript:void(0);" class="d-flex align-items-center participantList-item">'+
                '<div class="participantList-item_img">'+
                    '<img src="'+ user.profile_image_url +'" alt="">'+
                '</div>'+
                '<span class="font-bd participantList-item_name text-truncate">'+ userName +'</span>'+
            '</a>'+
        '</li>';

        if (user.id == tutorId) {
            $('#participantsList').prepend(nameCard);
        } else {
            $('#participantsList').append(nameCard);
        }

        $("#participantsList").getNiceScroll().resize();
        updateUsersCount();
    }

    function removeUserFromParticipants(userId)
    {
        $('#list-item'+userId).remove();
        $("#participantsList").getNiceScroll().resize();
        updateUsersCount();
    }
    
    // Create an AgoraRTCClient object.
    rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });

    // Listen for the "user-published" event, from which you can get an AgoraRTCRemoteUser object.
    rtc.client.on("user-published", async (user, mediaType) => {
        // Subscribe to the remote user when the SDK triggers the "user-published" event
        
            await rtc.client.subscribe(user, mediaType);
            console.log("subscribe success");

            // If the remote user publishes a video track.
            if (mediaType === "video") {
                // Get the RemoteVideoTrack object in the AgoraRTCRemoteUser object.
                const remoteVideoTrack = user.videoTrack;
                // Dynamically create a container in the form of a DIV element for playing the remote video track.
                const remotePlayerContainer = document.createElement("div");
                // Specify the ID of the DIV container. You can use the uid of the remote user.
                remotePlayerContainer.id = user.uid.toString();
                //remotePlayerContainer.textContent = "Remote user " + user.uid.toString();
                remotePlayerContainer.style.width = "100%";
                remotePlayerContainer.style.height = "100%";

                if (user.uid == tutorId) {
                    $("#remote-video").html(remotePlayerContainer);
                    $("#tutorImageScreen").hide();
                    $("#remote-video").show();
                    hosts.tutor.has_video = true;
                } else {
                    getUserProfile(user.uid, false);
                    $("#local-video").html(remotePlayerContainer);
                    $("#local-video").show();
                    $("#studentImageScreen").hide();
                    hosts.student.student_id = user.uid;
                    hosts.student.has_video = true;
                }
                remoteVideoTrack.play(remotePlayerContainer);
            }

            // If the remote user publishes an audio track.
            if (mediaType === "audio") {
                const remoteAudioTrack = user.audioTrack;
                remoteAudioTrack.play();
                if (user.uid == tutorId) {
                    tutorUnMuted();
                    hosts.tutor.has_audio = true;
                } else {
                    otherStudentUnMuted(user.uid);
                    hosts.student.has_audio = true;
                }
            }
    });

    rtc.client.on("user-info-updated", (uid, msg) => {
        if (uid == tutorId) {
            if (msg === "mute-audio") {
                tutorMuted();
                hosts.tutor.has_audio = false;
            }
            if (msg === "mute-video") {
                $("#tutorImageScreen").show();
                $("#remote-video").hide();
                hosts.tutor.has_video = false;
            }
        } else {
            if (otherStudent.hasStream && otherStudent.id == uid) {
                if (msg === "mute-audio") {
                    otherStudentMuted(uid);
                    hosts.student.has_audio = false;
                }
                if (msg === "mute-video") {
                    $("#local-video").hide();
                    showDefaultStudentImage(otherStudent.profile_image);
                    $("#studentImageScreen").show();
                    hosts.student.has_video = false;
                }
            }
        }
    });

    rtc.client.on("user-joined", async (user) => {
        if (user.uid == tutorId) {
            $('#whiteBox').hide();
            tutorJoined();
        }
        getUserProfile(user.uid);
        if (otherStudent.id){
            hosts.student.student_id = otherStudent.id;
        }
        sendVideoProfiles();
    });

    rtc.client.on("user-left", async (user, reason) => {
        removeUserFromParticipants(user.uid);
        if (user.uid == tutorId) {
            $("#videoBox").show();
            $("#tutorImageScreen").show();
            $("#remote-video").hide();
            $('#whiteBox').hide();
            $(".tutor_offline").show();
            if (reason === 'Quit' && hasRaiseHandRequest && hasRaiseHandRequest.student.id == uid && hasRaiseHandRequest.status == 'accept') {
                updateRequest(hasRaiseHandRequest.id, 'complete');
            }
        }

        if (otherStudent.id && otherStudent.id == user.uid) {
            hosts.student.student_id = null;
        }
    });

    rtc.client.on('connection-state-change', async (curState, prevState) => {
        if (curState == 'CONNECTED' && prevState == 'RECONNECTING') {
            if (hasRaiseHandRequest) {
                updateRequest(hasRaiseHandRequest.id, 'complete');
            }
        }
    });

    function tutorMuted(){
        setTimeout(function(){
            $("#list-item"+tutorId+" div.participantList-item_img").addClass('mic-off');
        }, 1000);
    }

    function tutorUnMuted(){
        $("#list-item"+tutorId+" div.participantList-item_img").removeClass('mic-off');
    }

    function otherStudentMuted(uid){
        setTimeout(function(){
            $("#list-item"+uid+" div.participantList-item_img").addClass('mic-off');
        }, 1000);
    }

    function otherStudentUnMuted(uid){
        $("#list-item"+uid+" div.participantList-item_img").removeClass('mic-off');
    }

    function tutorJoined(){
        Swal.fire(Lang.get("labels.tutor_is_online"));
        $(".tutor_offline").hide();
    }

    AgoraRTC.getDevices()
    .then(devices => {
      const audioDevices = devices.filter(function(device){
          return device.kind === "audioinput";
      });
      const videoDevices = devices.filter(function(device){
          return device.kind === "videoinput";
      });
      rtc.selectedMicrophoneId = audioDevices ? audioDevices[0].deviceId : null;
      rtc.selectedCameraId = (videoDevices && videoDevices.length) ? videoDevices[0].deviceId : null;
    });

    (async () => {
        getUserProfile(options.uid);
        // Join an RTC channel.
        await rtc.client.join(options.appId, options.channel, options.token, options.uid);
    })();

    async function publishStream(){
        rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack({
            encoderConfig: "high_quality_stereo",
            microphoneId: rtc.selectedMicrophoneId 
        }).catch(error => {
            errorToaster(Lang.get("error.microphone_not_found"));
            $('.mute').trigger('click');
        });
        // Create a local video track from the video captured by a camera.
        rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack({
            //optimizationMode: "detail",
            //encoderConfig: "480p_1",
            cameraId: rtc.selectedCameraId
        }).catch(error => {
            errorToaster(Lang.get("error.camera_not_found"));
            $('.video-off').trigger('click');
        });
        // Publish the local audio and video tracks to the RTC channel.
        //await rtc.client.publish([rtc.localAudioTrack]);
        // Dynamically create a container in the form of a DIV element for playing the local video track.
        const localPlayerContainer = document.createElement("div");
        // Specify the ID of the DIV container. You can use the uid of the local user.
        localPlayerContainer.id = options.uid;
        //localPlayerContainer.textContent = "test";
        localPlayerContainer.style.width = "200px";
        localPlayerContainer.style.height = "200px";
        $("#local-video").html(localPlayerContainer);
        showVideoAudio();
        // Play the local video track.
        // Pass the DIV container and the SDK dynamically creates a player in the container for playing the local video track.
        if (rtc.localVideoTrack) {
            await rtc.client.publish(rtc.localVideoTrack);
            rtc.localVideoTrack.play(localPlayerContainer);
            await rtc.localVideoTrack.setEnabled(false);
        }
        if (rtc.localAudioTrack) {
            await rtc.client.publish(rtc.localAudioTrack);
            await rtc.localAudioTrack.setEnabled(false);
        }
        $('.video-off').trigger('click');
        $('.mute').trigger('click');
        sendVideoProfiles();
    }

    AgoraRTC.onMicrophoneChanged = async (changedDevice) => {
        // When plugging in a device, switch to a device that is newly plugged in.
        if (changedDevice.state === "ACTIVE") {
            rtc.localAudioTrack.setDevice(changedDevice.device.deviceId);
            $('.mute').trigger('click');
        } else {
            const oldMicrophones = await AgoraRTC.getMicrophones();
            if (oldMicrophones && oldMicrophones.length) {
                if (changedDevice.device.label === rtc.localAudioTrack.getTrackLabel()) {
                  // Switch to an existing device when the current device is unplugged.
                   rtc.localAudioTrack.setDevice(oldMicrophones[0].deviceId);
                } 
            } else{
                $('.mute').trigger('click');
            }
        }
    }

    AgoraRTC.onCameraChanged = async (changedDevice) => {
        // When plugging in a device, switch to a device that is newly plugged in.
        if (changedDevice.state === "ACTIVE") {
          rtc.localVideoTrack.setDevice(changedDevice.device.deviceId);
          $('.video-off').trigger('click');
        } else {
            const cameras = await AgoraRTC.getCameras();
            if (cameras && cameras.length) {
                if (changedDevice.device.label === rtc.localVideoTrack.getTrackLabel()) {
                  // Switch to an existing device when the current device is unplugged.
                   rtc.localVideoTrack.setDevice(cameras[0].deviceId);
                } 
            } else{
                $('.video-off').trigger('click');
            }
        }
    }

    async function unpublishStream(){
        if (rtc.localAudioTrack) {
            await rtc.client.unpublish(rtc.localAudioTrack);
        }
        if (rtc.localVideoTrack) {
            await rtc.client.unpublish(rtc.localVideoTrack);
        }
        $("#local-video").html('');
        $("#hideDefaultStudentImage").hide();
    }
 
    try {
        var socket = io.connect(socketUrl, {
            transports: ['websocket'],
            reconnection: true,
            reconnectionDelay: 1000,
            reconnectionDelayMax: 5000,
            reconnectionAttempts: Infinity
        });

        socket.on("connect", () => {
            socket.emit(
                'join',
                {
                    'class_id': classId,
                    'uid': uid,
                    'user_type': 'student' 
                }
            );

            socket.on(
                'raise_hand_accepted',
                function (data) {
                    if (data.uid == uid) {
                        hasRaiseHandRequest.status = 'accept';
                        successToaster(Lang.get("message.request_status_updated", {'status':Lang.get("labels.accepted")}));
                        publishStream();
                    } else {
                        rtc.client.unpublish([rtc.localVideoTrack, rtc.localAudioTrack]);
                    }
                }
            );

            socket.on(
                'raise_hand_rejected',
                function (data) {
                    console.log('in rejected');
                    if (data.uid == uid) {
                        successToaster(Lang.get("message.request_status_updated", {'status':Lang.get("labels.rejected")}));
                        hasRaiseHandRequest = null;
                        $('#raise-hand-btn').removeClass('active');
                    } 
                }
            );

            socket.on(
                'class_completed',
                function(data){
                    if (rtc.localAudioTrack){
                        rtc.localAudioTrack.close();
                    }
                    if (rtc.localVideoTrack) {
                        rtc.localVideoTrack.close();
                    }
                    // Leave the channel.
                    rtc.client.leave();
                    successToaster(Lang.get("message.class_end"));
                    setTimeout(function(){
                        window.location.href = process.env.MIX_APP_URL + '/student/feedback/' + classId;
                    }, 5000);
                    
                }     
            );

            socket.on(
                'raise_hand_completed',
                function(data){
                    if (uid == data.uid) {
                        successToaster(Lang.get("message.request_status_updated", {'status':Lang.get("labels.completed")}));
                        unpublishStream();
                        hideVideoAudio();
                        hideDefaultStudentImage(); 
                        hasRaiseHandRequest = null;
                        $('#raise-hand-btn').removeClass('active');
                    }
                    if (otherStudent && otherStudent.id) {
                        otherStudent.hasStream = false;
                        hosts.student.student_id = null;
                        otherStudentUnMuted(otherStudent.id);
                        hideDefaultStudentImage();  
                        otherStudent.id = null;
                        sendVideoProfiles();
                    }
                }     
            );

            socket.on(
                'extra_hour_request',
                function(data){
                    $('.tutor_name').text(data.tutor_name);
                    $('.extra_hour_amount').text(data.extra_hour_charge);
                    $('.extra_hour_duration').text(data.extra_duration/60);
                    $('#extrachargeModal').modal('show');                
                }     
            );
            socket.on(
                'show_whiteboard',
                function(data){
                    if(data.is_show){
                        $('#whiteBox').show('slow');
                        $('#videoBox').hide('slow');
                    }else{
                        $('#whiteBox').hide('slow');
                        $('#videoBox').show('slow');
                    }
                }     
            );
        });
    }
    catch(err) {
        console.log(err);
    }

    function sendVideoProfiles(){
        hosts.student.has_audio = rtc.localAudioTrack ? true : false;
        hosts.student.has_video = rtc.localVideoTrack ? true : false;
        socket.emit(
            'video_profiles',
            hosts
        );
    }

    function hideVideoAudio(){
        $('.video').hide();
        $('.audio').hide();
    }

    function showVideoAudio(){
        $('.audio').children('span').addClass('icon-mic');
        $('.video').children('span').addClass('icon-video-camera');
        $('.video').show();
        $('.audio').show();
    }

    function showDefaultStudentImage(profile_image){
        $('#studentImageScreen img').attr('src', profile_image);
        $("#studentImageScreen").addClass('img-bg');
        $('#studentImageScreen').show();
    }

    function hideDefaultStudentImage(){
        $('#studentImageScreen img').attr('src', '');
        $("#studentImageScreen").removeClass('img-bg');
        $('#studentImageScreen').hide();
    }
       
    $('.mute').on('click', async function(){
        let isMuted = $(this).children('span').hasClass('icon-mic');
        if (!isMuted) {
            $(this).children('span').removeClass('icon-mute_white');
            $(this).children('span').addClass('icon-mic');
        } else {
            $(this).children('span').removeClass('icon-mic');
            $(this).children('span').addClass('icon-mute_white');
        }
        if (rtc.localAudioTrack) {
            await rtc.localAudioTrack.setEnabled(!isMuted);
        }
    });

    $('.video-off').on('click', async function(){
        let isVideoAllowed = $(this).children('span').hasClass('icon-video-camera');
        if (!isVideoAllowed) {
            $(this).children('span').removeClass('icon-video_off_white');
            $(this).children('span').addClass('icon-video-camera');
            hideDefaultStudentImage();
            $("#local-video").show();
        } else {
            $(this).children('span').removeClass('icon-video-camera');
            $(this).children('span').addClass('icon-video_off_white');
            showDefaultStudentImage(profile_image)
            $("#local-video").hide();
        }
        if (rtc.localVideoTrack) {
            await rtc.localVideoTrack.setEnabled(!isVideoAllowed);
        }
    });

    $(document).on('click', '.extra_hour_reject', function(user){
        acceptRejectRequest('rejected');
    });

    $(document).on('click', '.extra_hour_accept',function(){
        acceptRejectRequest('accepted');
    });

    $(document).on('click', '.close', function(){
        $('#extra-hour-btn').show();
    });

    $('#raise-hand-btn').on('click', function(){
        $(this).addClass('active');
    });

    window.endCall = function endCall(bookingId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-primary mr-2',
              cancelButton: 'btn btn-light ripple-effect-dark' 
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({  
            title: Lang.get('labels.are_you_sure'),
            text: Lang.get("labels.end_this_call"),
            showCancelButton: true,
            confirmButtonText: Lang.get("labels.yes_end_call"),
            cancelButtonText: Lang.get('labels.cancel'),
        }).then((result) => {
            if (result.value) {
                var redirectUrl = process.env.MIX_APP_URL + '/student/classes';
                if (classType == 'webinar') {
                    redirectUrl = process.env.MIX_APP_URL + '/student/webinars';
                }
                window.location.href = redirectUrl;
            }
        });
    };

    window.raiseHand = function raiseHand(classId) {
        if (hasRaiseHandRequest) {
            errorToaster(Lang.get("error.have_active_raise_hand_request")); 
            return false;
        }
        var url = process.env.MIX_APP_URL + '/student/raise-hand';
        $.ajax({
            type: "post",
            url: url,
            data: {
                class_id: classId
            },
            success: function (data) {
                let sendData = data.data;
                successToaster(Lang.get("message.request_status_updated", {'status':Lang.get("labels.sent")}));
                sendData.class_id = classId;
                socket.emit(
                    'raise_hand',
                    sendData
                );
                hasRaiseHandRequest = sendData;
                $('#raise-hand-btn').addClass('active');
            },
            error: function (err) {
                handleError(err);
            }
        });
    }

    function acceptRejectRequest(status)
    {
        let url = process.env.MIX_APP_URL + '/student/update-extra-hour-request/';
        var actionLabel = Lang.get('labels.reject');
        if (status == 'accepted') {
            actionLabel = Lang.get('labels.accept');
        } 
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-primary mr-2',
              cancelButton: 'btn btn-light ripple-effect-dark' 
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({  
            title: Lang.get('labels.are_you_sure'),
            text: Lang.get('labels.want_to_request', {'status':actionLabel}),
            showCancelButton: true,
            confirmButtonText: Lang.get('labels.yes_status',{'status':actionLabel}),
            cancelButtonText: Lang.get('labels.cancel'),
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "put",
                    url: url,
                    data: {class_id: classId, student_id:uid, status: status},
                    success: function (response) {
                        console.log(response);
                        successToaster(Lang.get("message.request_status_updated", {'status':actionLabel}));
                        $('#extrachargeModal').modal('hide');
                        $('#extra-hour-btn').hide();
                        if (status == 'accepted') {
                            socket.emit(
                                'extra_hour_request_accepted',
                                {
                                    class_id:classId,
                                    duration: response.data.extra_duration
                                }
                            );
                            let newEndTime = moment.utc(endTime).add(response.data.extra_duration, 'minutes').toISOString();
                            clearInterval(timeinterval);
                            initializeClock(newEndTime);
                        }
                    },
                    error: function (err) {
                        handleError(err);
                    }
                });
            }
        });
    }

    window.completeBooking = function ()
    {
        var url = process.env.MIX_APP_URL + '/student/complete-booking/' + bookingId;
        $.ajax({
            type: "get",
            url: url,
            success: function (data) {
                if (rtc.localAudioTrack){
                    rtc.localAudioTrack.close();
                }
                if (rtc.localVideoTrack) {
                    rtc.localVideoTrack.close();
                }
                // Leave the channel.
                rtc.client.leave();
                successToaster(data.message);
                setTimeout(function(){
                    window.location.href = process.env.MIX_APP_URL + '/student/feedback/' + classId;
                }, 2000);
            },
            error: function (err) {
                handleError(err);
            }
        });
    }

    window.updateRequest = function (id, status) {
        let url = process.env.MIX_APP_URL + '/student/update-raise-hand-request/' + id;
        var actionLabel = Lang.get("labels.completed");
        $.ajax({
            type: "put",
            url: url,
            data: { status: status },
            success: function(response) {
                successToaster(Lang.get("message.request_status_updated", { 'status': actionLabel }));
                console.log(response.data);
                unpublishStream();
                hideVideoAudio();
                hasRaiseHandRequest = null;
                $('#raise-hand-btn').removeClass('active');
                socket?.emit(
                    'raise_hand_complete', {
                        'class_id': classId,
                        'uid': response.data.student.id
                    }
                );
            },
            error: function(err) {
                handleError(err);
            }
        });
    }
    initializeWhiteBoard();
});