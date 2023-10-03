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

window.extraHourRequestModal = function() {
    $('#extraHourRequestModal').modal('show');
}

$('#extra-hour-btn').on('click', function() {
    $("#extraHourRequestModal").modal('show');
});
var whiteWebSdk = new WhiteWebSdk({
    // Pass in your App Identifier.
    appIdentifier: appIdentifier,
    // Set the data center as Silicon Valley, US.
    region: region
});

function initializeWhiteBoard() {
    var joinRoomParams = {
        uuid: classUuid,
        roomToken: classRoomToken,
        limit: 1,
        disableCameraTransform: true,
        floatBar: true,
    };
    // Join the whiteboard room and display the whiteboard on the web page.
    whiteWebSdk.joinRoom(joinRoomParams).then(function(room) {
        room.bindHtmlElement(document.getElementById("whiteboard"));
        room.setMemberState({
            strokeColor: [0, 0, 0],
            strokeWidth: 4,
            textSize: 22
        });
        room.disableSerialization = false;
        room.setViewMode('Broadcaster');
        var toolbar = document.getElementById("toolbarUl");
        var toolNames = ["selector", "laserPointer", "arrow", "hand", "straight", "eraser", "text", "pencil", "shape"];

        for (var idx in toolNames) {
            var toolName = toolNames[idx];

            switch (toolName) {
                case 'selector':
                    var list = document.createElement("li");

                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-near-me" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Select"></em>';
                    break;
                    // case 'clicker':
                    //     var list = document.createElement("li");

                    //     var listItem = list.appendChild(document.createElement("a"));
                    //     listItem.setAttribute("id", toolName);
                    //     listItem.setAttribute("class", "nav-link");
                    //     listItem.innerHTML = '<em class="icon-pointer" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Select"></em>';
                    //     break;
                case 'laserPointer':
                    var list = document.createElement("li");

                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-pointer" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Select"></em>';
                    break;
                case 'pencil':
                    var list = document.createElement("li");
                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-pen" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Text"></em>';
                    break;
                    // case 'hand':
                    //     var list = document.createElement("li");

                    //     var listItem = list.appendChild(document.createElement("a"));
                    //     listItem.setAttribute("id", toolName);
                    //     listItem.setAttribute("class", "nav-link");
                    //     listItem.innerHTML = '<em class="icon-back_hand_black" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Select"></em>';
                    //     break;
                case 'straight':
                    var list = document.createElement("li");
                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-linexpand" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Line"></em>';
                    break;
                case 'arrow':
                    var list = document.createElement("li");
                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-a1" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Arrow"></em>';
                    break;
                case 'eraser':
                    var list = document.createElement("li");
                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-eraser_inactive" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Eraser"></em>';
                    break;
                case 'text':
                    var list = document.createElement("li");
                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("id", toolName);
                    listItem.setAttribute("class", "nav-link");
                    listItem.innerHTML = '<em class="icon-text" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Text"></em>';
                    break;
                case 'shape':
                    var list = document.createElement("li");
                    // list.setAttribute("id",toolName);
                    list.setAttribute("class", "dropdown");
                    var listItem = list.appendChild(document.createElement("a"));
                    listItem.setAttribute("class", "dropdown-toggle nav-link");
                    listItem.setAttribute("href", "#");
                    listItem.setAttribute("data-toggle", "dropdown");
                    listItem.setAttribute("aria-haspopup", "true");
                    listItem.setAttribute("aria-expanded", "false");
                    listItem.setAttribute("id", "dropdownMenuLink" + toolName);
                    listItem.innerHTML = '<em class="icon-dubble-shape" data-id="' + toolName + '" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Shape"></em>';
                    var childDiv = list.appendChild(document.createElement("div"));
                    childDiv.setAttribute("class", "dropdown-menu shapeDropdown");
                    childDiv.setAttribute("aria-labelledby", "dropdownMenuLink" + toolName);

                    var childListItem = childDiv.appendChild(document.createElement("a"));
                    childListItem.setAttribute("id", 'rectangle');
                    childListItem.setAttribute("class", "dropdown-item");
                    childListItem.innerHTML = '<em class="icon-square-outline" data-id="rectangle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Rectangle"></em>';

                    var childListItem = childDiv.appendChild(document.createElement("a"));
                    childListItem.setAttribute("id", 'ellipse');
                    childListItem.setAttribute("class", "dropdown-item");
                    childListItem.innerHTML = '<em class="icon-circle-outline" data-id="ellipse" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ellipse"></em>';

                    // Triangle Icon
                    var childListItem = childDiv.appendChild(document.createElement("a"));
                    childListItem.setAttribute("id", 'shape');
                    childListItem.setAttribute("class", "dropdown-item");
                    childListItem.innerHTML = '<em class="icon-triangle-outline" data-id="shape"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Triangle"></em>';

                    // Star Icon
                    var childListItem = childDiv.appendChild(document.createElement("a"));
                    childListItem.setAttribute("id", 'shape');
                    childListItem.setAttribute("class", "dropdown-item");
                    childListItem.innerHTML = '<em class="icon-star-outline" data-id="shape" data-type="pentagram" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pentagram"></em>';
                    // Dimond Icon
                    var childListItem = childDiv.appendChild(document.createElement("a"));
                    childListItem.setAttribute("id", 'shape');
                    childListItem.setAttribute("class", "dropdown-item");
                    childListItem.innerHTML = '<em class="icon-fontagon-outline" data-id="shape" data-type="rhombus" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Rhombus"></em>';

                    break;

                default:
                    break;
            }

            // Listen for the event of clicking a button.
            list.addEventListener("click", function(obj) {
                var ele = obj.target;
                let shapeName = ele.getAttribute("data-type");
                $('a.nav-link').removeClass('active');
                $(ele).parent('a.nav-link').addClass('active');
                room.setMemberState({
                    currentApplianceName: ele.getAttribute("data-id"),
                    shapeType: shapeName
                });
            });
            toolbar.appendChild(list);
        }
        $("#pencil").addClass('active');
        $('#undo').on('click', function() {
            room.undo();
        });
        $('#redo').on('click', function() {
            room.redo();
        });
        $('#duplicate').on('click', function() {
            room.duplicate();
        });
        $('#delete').on('click', function() {
            room.delete();
        });
        $('#update-stroke').on('change', function() {
            let size = $(this).val();
            console.log(size);
            room.setMemberState({
                strokeWidth: size,
            });
        });
        $('.selectedColor').on('click', function() {
            let color = $(this).data('color');
            room.setMemberState({
                strokeColor: color,
            });
        });
        var memberState = room.memberState();
        $("#update-stroke").val(memberState.strokeWidth);
        var activeColor = memberState.strokeColor;
        $(".selectedColor").each(function(index) {
            var color = $(this).data('color');
            if (JSON.stringify(activeColor) == JSON.stringify(color)) {
                $(this).addClass('active');
            }
        });
    }).catch(function(err) {
        console.error(err);
    });
}

$(function() {
    initializeWhiteBoard();

    $('[data-toggle="tooltip"]').tooltip({
        animation: false
    });

    $('#whiteBox').hide();

    $("#sidebar ul li>.nav-link").click(function() {
        $("#sidebar ul li>.nav-link").removeClass("active");
        $(this).addClass("active");
    });

    $("#sidebar ul li .dropdown-menu .dropdown-item").click(function() {
        $("#sidebar ul li .dropdown-menu .dropdown-item").removeClass("active");
        $("#sidebar ul li .fileUpload label").removeClass("active");
        $(this).addClass("active");
    });

    $("#sidebar ul li .dropdown-menu .selectedColor").click(function() {
        $("#sidebar ul li .dropdown-menu .selectedColor").removeClass("active");
        $(this).addClass("active");
    });

    $("#sidebar ul li .fileUpload label").on('click', function() {
        $("#sidebar ul li .fileUpload label").removeClass("active");
        $(this).addClass("active");
    });

    var timeinterval;

    function getTimeRemaining(endtime) {
        let endTime = moment.utc(endtime).local();
        let total = Date.parse(endTime) - Date.parse(new Date());
        let seconds = Math.floor((total / 1000) % 60);
        let minutes = Math.floor((total / 1000 / 60) % 60);
        let hours = Math.floor((total / (1000 * 60 * 60)) % 24);

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
            clock.innerHTML = t.hours + ':' + t.minutes + ':' + t.seconds;
            if (t.minutes <= 9 && hasExtraHourRequest == 0) {
                $("#extra-hour-btn").show();
            }
            if (t.total <= 0) {
                clearInterval(timeinterval);
                completeClass();
            }
        }, 1000);
    }
    initializeClock(endTime);

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
                'join', {
                    'class_id': classId,
                    'uid': uid,
                    'user_type': 'tutor'
                }
            );

            socket.on(
                'raise_hand_request',
                (data) => {
                    successToaster(Lang.get("message.request_status_updated", { 'status': Lang.get("labels.received") }));
                    addRequest(data);
                }
            );

            socket.on(
                'extra_hour_request_accepted',
                function(data) {
                    if ($('#extra-hour-btn').length) {
                        successToaster(Lang.get("message.time_extended"));
                        $('#extra-hour-btn').remove();
                        let newEndTime = moment.utc(endTime).add(data.duration, 'minutes').toISOString();
                        clearInterval(timeinterval);
                        initializeClock(newEndTime);
                    }
                }
            );
        });
    } catch (err) {
        console.log(err);
    }

    let rtc = {
        localAudioTrack: null,
        localVideoTrack: null,
        localScreenTrack: null,
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

    let student = {
        id: null,
        name: "",
        profile_image: ""
    }

    let hosts = {
        tutor: {
            tutor_id: uid,
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

    function getUserProfile(userId, addInList = true) {
        $.ajax({
            url: process.env.MIX_APP_URL + "/users/" + userId,
            type: "GET",
            success: function(response) {
                if (addInList) {
                    addUserIntoParticipants(response.data);
                } else {
                    student.id = response.data.id;
                    student.name = response.data.name;
                    student.profile_image = response.data.profile_image_url;
                }

            },
            error: function(data) {

            },
        });
    }

    function updateUsersCount() {
        let connectedUsers = rtc.client.remoteUsers.length + 1;
        $('.participant-count').text(connectedUsers);
    }

    function updateRequestCount() {
        $('.raise-hand-count').text($('#raisHandList li').length);
        if (!$('#raisHandList li').length) {
            $('#raisHandList').html('<li class="no_data"><div class="alert alert-danger">' + Lang.get("message.no_raise_hand_request_found") + '</li></div>');
        }
    }

    function addUserIntoParticipants(user) {
        let userName = user.name;
        if (user.id == uid) {
            userName = user.name + '(Me)';
        }
        let nameCard = '<li id="list-item' + user.id + '">' +
            '<a href="javascript:void(0);" class="d-flex align-items-center participantList-item">' +
            '<div class="participantList-item_img">' +
            '<img src="' + user.profile_image_url + '" alt="">' +
            '</div>' +
            '<span class="font-bd participantList-item_name text-truncate">' + userName + '</span>' +
            '</a>' +
            '</li>';
        if (user.id == uid) {
            $('#participantsList').prepend(nameCard);
        } else {
            $('#participantsList').append(nameCard);
        }

        $("#participantsList").getNiceScroll().resize();
        updateUsersCount();
    }

    function removeUserFromParticipants(userId) {
        $('#list-item' + userId).remove();
        $("#participantsList").getNiceScroll().resize();
        updateUsersCount();
    }

    function addRequest(requestData) {
        if ($('#raisHandList').find('#raise-hand-' + requestData.student.id).length == 0) {
            let RequestCard = '<li id="raise-hand-' + requestData.student.id + '" data-raise-hand-id="' + requestData.id + '">' +
                '<a href="javascript:void(0);" class="d-flex align-items-center justify-content-between participantList-item flex-wrap">' +
                '<div class="participantList__left">' +
                '<div class="d-flex align-items-center">' +
                '<div class="participantList-item_img">' +
                '<img src="' + requestData.student.profile_image_url + '" alt="">' +
                '</div>' +
                '<span class="font-bd participantList-item_name text-truncate">' + requestData.student.name + '</span>' +
                '</div>' +
                '</div>' +
                '<div id="raise-hand-actions-' + requestData.student.id + '" class="participantList__right">' +
                '<button type="button" data-id="' + requestData.id + '" class="btn btn-light btn-sm ripple-effect reject">' + Lang.get('labels.reject') + '</button>' +
                '<button type="button" data-id="' + requestData.id + '" class="btn btn-primary btn-sm ripple-effect accept">' + Lang.get('labels.accept') + '</button>' +
                '</div>' +
                '</a>' +
                '</li>';

            if ($('#raisHandList li.no_data').length) {
                $('#raisHandList').html(RequestCard);
            } else {
                $('#raisHandList').append(RequestCard);
            }
            $("#raisHandList").getNiceScroll().resize();
            updateRequestCount();
        }
    }

    function removeRequest(data, isRejected = false) {
        data.class_id = classId;
        $('#raise-hand-' + data.student.id).remove();
        $("#raisHandList").getNiceScroll().resize();
        updateRequestCount();
        if (isRejected) {
            socket?.emit(
                'raise_hand_reject', {
                    'class_id': classId,
                    'uid': data.student.id
                }
            );
            if (hasRaiseHandRequest && hasRaiseHandRequest.id == data.id) {
                hasRaiseHandRequest = null;
            }
        } else {
            hasRaiseHandRequest = null;
        }
        hideDefaultStudentImage();
    }

    function requestAccept(data) {
        if (hasRaiseHandRequest) {
            errorToaster(Lang.get("error.have_active_raise_hand_request"));
            return false;
        }
        socket?.emit(
            'raise_hand_accept', {
                'class_id': classId,
                'uid': data.student.id
            }
        );
        console.log(data);
        $('#raise-hand-actions-' + data.student.id).html(
            '<button type="button" data-id="' + data.id + '" class="btn btn-primary btn-sm ripple-effect end-request">' + Lang.get('labels.complete') + '</button>'
        );
        data.profile_image = data.student.profile_image_url;
        showDefaultStudentImage(data);
        hasRaiseHandRequest = data;
    };

    function requestComplete(data) {
        socket?.emit(
            'raise_hand_complete', {
                'class_id': classId,
                'uid': data.student.id
            }
        );
        removeRequest(data);
        hosts.student.student_id = null;
        student.id = null;
        setTimeout(function() {
            hideDefaultStudentImage();
        }, 3000);
    }

    // Create an AgoraRTCClient object.
    rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });

    AgoraRTC.getDevices()
        .then(devices => {
            const audioDevices = devices.filter(function(device) {
                return device.kind === "audioinput";
            });
            const videoDevices = devices.filter(function(device) {
                return device.kind === "videoinput";
            });
            rtc.selectedMicrophoneId = audioDevices ? audioDevices[0].deviceId : null;
            rtc.selectedCameraId = (videoDevices && videoDevices.length) ? videoDevices[0].deviceId : null;
        });

    (async() => {
        // Join an RTC channel.
        await rtc.client.join(options.appId, options.channel, options.token, options.uid);
        getUserProfile(options.uid);
        // Create a local audio track from the audio sampled by a microphone.
        rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack({ 
            encoderConfig: "high_quality_stereo",
            microphoneId: rtc.selectedMicrophoneId 
        }).catch(error => {
            errorToaster(Lang.get("error.microphone_not_found"));
            $('.mute').trigger('click');
        });
        // Create a local video track from the video captured by a camera.
        rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack({
            optimizationMode: "detail",
            //encoderConfig: "480p_1",
            cameraId: rtc.selectedCameraId
        }).catch(error => {
            errorToaster(Lang.get("error.camera_not_found"));
            $('.video-off').trigger('click');
        });

        const localPlayerContainer = document.createElement("div");
        // Specify the ID of the DIV container. You can use the uid of the local user.
        localPlayerContainer.id = options.uid;
        localPlayerContainer.style.width = "100%";
        localPlayerContainer.style.height = "100%";
        $("#local-video").html(localPlayerContainer);

        // Play the local video track.
        // Pass the DIV container and the SDK dynamically creates a player in the container for playing the local video track.
        if (rtc.localVideoTrack) {
            await rtc.client.publish(rtc.localVideoTrack);
            rtc.localVideoTrack.play(localPlayerContainer, {mirror: false});
            await rtc.localVideoTrack.setEnabled(false);
        }

        if (rtc.localAudioTrack) {
            await rtc.client.publish(rtc.localAudioTrack);
            await rtc.localAudioTrack.setEnabled(false);
        }
        $('.video-off').trigger('click');
        $('.mute').trigger('click');
    })();

    rtc.client.on("user-joined", async(user) => {
        getUserProfile(user.uid);
        showHideWhiteBoxEvent(!$('#whiteBox').is(':hidden'));
        if (student.id) {
            hosts.student.student_id = student.id;
        }
        sendVideoProfiles();
    });

    rtc.client.on('connection-state-change', async(curState, prevState) => {
        if (curState == 'CONNECTED' && prevState == 'RECONNECTING') {
            if (hasRaiseHandRequest) {
                console.log(hasRaiseHandRequest);
                hosts.student.student_id = null;
                requestComplete(hasRaiseHandRequest);
            }
        }
    });

    // Listen for the "user-published" event, from which you can get an AgoraRTCRemoteUser object.
    rtc.client.on("user-published", async(user, mediaType) => {
        getUserProfile(user.uid, false);
        // Subscribe to the remote user when the SDK triggers the "user-published" event
        await rtc.client.subscribe(user, mediaType);

        // If the remote user publishes a video track.
        if (mediaType === "video") {
            hideDefaultStudentImage();
            // Get the RemoteVideoTrack object in the AgoraRTCRemoteUser object.
            const remoteVideoTrack = user.videoTrack;
            // Dynamically create a container in the form of a DIV element for playing the remote video track.
            const remotePlayerContainer = document.createElement("div");
            // Specify the ID of the DIV container. You can use the uid of the remote user.
            remotePlayerContainer.id = user.uid.toString();
            //remotePlayerContainer.textContent = "Remote user " + user.uid.toString();
            remotePlayerContainer.style.width = "100%";
            remotePlayerContainer.style.height = "100%";
            $("#remote-video").html(remotePlayerContainer);

            // Play the remote video track.
            // Pass the DIV container and the SDK dynamically creates a player in the container for playing the remote video track.
            remoteVideoTrack.play(remotePlayerContainer,{mirror:true});
            hosts.student.has_video = true;

            // Or just pass the ID of the DIV container.
            // remoteVideoTrack.play(playerContainer.id);
        }

        // If the remote user publishes an audio track.
        if (mediaType === "audio") {
            // Get the RemoteAudioTrack object in the AgoraRTCRemoteUser object.
            const remoteAudioTrack = user.audioTrack;
            // Play the remote audio track. No need to pass any DOM element.
            remoteAudioTrack.play();
            studentUnMuted(user.uid);
            hosts.student.has_audio = true;
        }

    });

    rtc.client.on("user-unpublished", (user, mediaType) => {
        if (student && user.uid == student.id) {
            if (mediaType === "video" && hasRaiseHandRequest) {
                showDefaultStudentImage(student);
                hosts.student.has_video = false;
            }
            if (mediaType === "audio" && hasRaiseHandRequest) {
                studentMuted(user.uid);
                hosts.student.has_audio = false;
            }
        }
    });

    rtc.client.on("user-left", async(user, reason) => {
        removeUserFromParticipants(user.uid);
        let requestId = $("#raise-hand-" + user.uid).data('raise-hand-id');
        if (requestId) {
            updateRequest(requestId, 'complete');
        }
        if (student.id && student.id == user.uid) {
            hosts.student.has_audio = false;
            hosts.student.has_video = false;
            hosts.student.student_id = null;
            student.id = null;
        }
    });

    function showDefaultStudentImage(student) {
        $('#studentImageScreen img').attr('src', student.profile_image);
        $("#studentImageScreen").addClass('img-bg');
        $('#studentImageScreen').show();
    }

    function hideDefaultStudentImage() {
        $('#studentImageScreen img').attr('src', '');
        $("#studentImageScreen").removeClass('img-bg');
        $('#studentImageScreen').hide();
    }

    function studentMuted(studentId) {
        $("#raise-hand-" + studentId + " div.participantList-item_img").addClass('mic-off');
    }

    function studentUnMuted(studentId) {
        $("#raise-hand-" + studentId + " div.participantList-item_img").removeClass('mic-off');
    }

    AgoraRTC.onMicrophoneChanged = async(changedDevice) => {
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
            } else {
                $('.mute').trigger('click');
            }
        }
    }

    AgoraRTC.onCameraChanged = async(changedDevice) => {
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
            } else {
                $('.video-off').trigger('click');
            }
        }
    }

    $('.mute').on('click', async function() {
        let isMuted = $(this).children('span').hasClass('icon-mic');
        if (!isMuted) {
            $(this).children('span').removeClass('icon-mute_white');
            $(this).children('span').addClass('icon-mic');
            hosts.tutor.has_audio = true;
        } else {
            $(this).children('span').removeClass('icon-mic');
            $(this).children('span').addClass('icon-mute_white');
            hosts.tutor.has_audio = false;
        }
        console.log(rtc.localAudioTrack);
        if (rtc.localAudioTrack) {
            await rtc.localAudioTrack.setEnabled(!isMuted);
        }
    });

    $('.video-off').on('click', async function() {
        let isVideoAllowed = $(this).children('span').hasClass('icon-video-camera');
        if (!isVideoAllowed) {
            $(this).children('span').removeClass('icon-video_off_white');
            $(this).children('span').addClass('icon-video-camera');
            $("#tutorImageScreen").hide();
            $("#local-video").show();
            hosts.tutor.has_video = true;
        } else {
            $(this).children('span').removeClass('icon-video-camera');
            $(this).children('span').addClass('icon-video_off_white');
            $("#tutorImageScreen").show();
            $("#local-video").hide();
            let isShared = $(this).children('span').hasClass('icon-close');
            if (isShared) {
                hosts.tutor.has_video = true;
               
            } else {
                hosts.tutor.has_video = false;
            }
            
        }
        if (rtc.localVideoTrack) {
            await rtc.localVideoTrack.setEnabled(!isVideoAllowed);
        }
    });
    

    function sendVideoProfiles() {
        setTimeout(function() {
            socket?.emit(
                'video_profiles',
                hosts
            );
        }, 1000);
    }

    $(document).on('click', '.reject', function(user) {
        let id = $(this).data('id');
        acceptRejectRequest(id, 'reject');
    });

    $(document).on('click', '.accept', function() {
        let id = $(this).data('id');
        acceptRejectRequest(id, 'accept');
    });

    $(document).on('click', '.end-request', function() {
        let id = $(this).data('id');
        acceptRejectRequest(id, 'complete');
    });

    $('#extraHourRequestModal').on('hidden.bs.modal', function() {
        $('input').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        showButtonLoader($('#extra-hour-submit'), Lang.get('labels.request'), 'enabled');
        $('#durationOfClass').val('').trigger('change');
    });

    function acceptRejectRequest(id, status) {
        if (status == 'reject') {
            var statusLang = Lang.get('labels.reject');
        } else if (status == 'accept') {
            var statusLang = Lang.get('labels.accept');
        } else if (status == 'complete') {
            var statusLang = Lang.get('labels.complete');
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
            text: Lang.get('labels.want_to_request', {'status':statusLang}),
            showCancelButton: true,
            confirmButtonText: Lang.get('labels.yes_status',{'status':statusLang}),
            cancelButtonText: Lang.get('labels.cancel'),
        }).then((result) => {
            if (result.value) {
                updateRequest(id, status);
            }
        });
    }

    function updateRequest(id, status) {
        let url = process.env.MIX_APP_URL + '/tutor/update-raise-hand-request/' + id;
        var actionLabel = Lang.get('labels.rejected');
        if (status == 'accept') {
            actionLabel = Lang.get("labels.accepted");
        } else if (status == 'complete') {
            actionLabel = Lang.get("labels.completed");
        }
        $.ajax({
            type: "put",
            url: url,
            data: { status: status },
            success: function(response) {
                successToaster(Lang.get("message.request_status_updated", { 'status': actionLabel }));
                if (status == 'accept') {
                    requestAccept(response.data);
                } else if (status == 'complete') {
                    requestComplete(response.data);
                } else {
                    removeRequest(response.data, true);
                }
            },
            error: function(err) {
                handleError(err);
            }
        });
    }

    function completeClass() {
        var url = process.env.MIX_APP_URL + '/tutor/complete-class/' + classId;
        $.ajax({
            type: "get",
            url: url,
            success: async function(data) {
                if (rtc.localAudioTrack) {
                    rtc.localAudioTrack.close();
                }
                if (rtc.localVideoTrack) {
                    rtc.localVideoTrack.close();
                }
                // Leave the channel.
                await rtc.client.leave();
                socket?.emit(
                    'end_call', {
                        class_id: classId
                    }
                );
                successToaster(data.message);
                setTimeout(function() {
                    window.location.href = process.env.MIX_APP_URL + '/tutor/feedback/' + classId;
                }, 2000);


            },
            error: function(err) {
                handleError(err);
            }
        });
    }

    window.endCall = function endCall() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary mr-2',
                cancelButton: 'btn btn-light ripple-effect-dark'
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: Lang.get('labels.alert_title'),
            text: Lang.get("labels.alert_message"),
            showCancelButton: true,
            confirmButtonText: Lang.get("labels.yes_end_call"),
            cancelButtonText: Lang.get('labels.cancel'),
        }).then((result) => {
            if (result.value) {
                completeClass();
            }
        });
    };

    $("#extraHourForm").on('submit', function(e) {
        e.preventDefault();
        var form = $('#extraHourForm');
        var btn = $('#extra-hour-submit');
        var btnName = btn.html();
        if (form.valid()) {
            var showLoader = 'Processing...';
            showButtonLoader(btn, showLoader, 'disabled');
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: async function(response) {
                    $("#extraHourRequestModal").modal('hide');
                    $("#extra-hour-btn").hide();
                    socket?.emit(
                        'extra_hour_request', {
                            class_id: classId,
                            tutor_name: tutorName,
                            extra_hour_charge: response.data.extra_hour_charge,
                            extra_duration: response.data.extra_duration
                        }
                    );
                    hasExtraHourRequest = 1;
                    successToaster(Lang.get('message.extra_hour_request_action', { action: Lang.get('labels.sent') }));
                },
                error: function(err) {
                    handleError(err);
                    showButtonLoader(btn, btnName, 'enabled');
                    $("#extraHourRequestModal").modal('hide');
                    $("#durationOfClass").val('').trigger('change');
                },
                always: function() {
                    showButtonLoader(btn, btnName, 'enabled');
                }
            });
        }
    });

    window.showHideWhiteBox = function() {
        var isShow = $('#whiteBox').is(':hidden');
        if (isShow) {
            $('#whiteBox').show('slow');
            $('#videoBox').hide('slow');
            showHideWhiteBoxEvent(true);
        } else {
            $('#whiteBox').hide('slow');
            $('#videoBox').show('slow');
            showHideWhiteBoxEvent(false);
        }
    }

    function showHideWhiteBoxEvent(isShow) {
        setTimeout(function() {
            socket?.emit(
                'show_whiteboard', {
                    'class_id': classId,
                    'is_show': isShow
                }
            );
        }, 1000);
    };

    var  localTracks = {
        screenVideoTrack:null,
        screenAudioTrack :null
    };

    $('.screen-share-on').on('click', async function() {
        let videoEnabled = $('.video-off').children('span').hasClass('icon-video_off_white');
        if (!videoEnabled) {
            $('.video-off').trigger('click');
        }
        let isShared = $(this).children('span').hasClass('icon-close');

        if (!isShared) {
            var screenTrack = await AgoraRTC.createScreenVideoTrack(
                {}, 'auto'
                
            ).then((tracks)=> {
                $(this).children('span').removeClass('icon-arrow_upward');
                $(this).children('span').addClass('icon-close');
                $('.screen-share-on').find('.screen-sharing').text(Lang.get("labels.stop_sharing"));
                $('#showHideWhiteBox').hide();
                $('#whiteBox').hide();
                $('#videoBox').show();
                $('.video-off').hide();
                showHideWhiteBoxEvent(false);

                rtc.localScreenTrack = tracks;
                if(tracks instanceof Array){
                    localTracks.screenVideoTrack = tracks[0]
                    localTracks.screenAudioTrack = tracks[1]
                }
                else{
                    localTracks.screenVideoTrack = tracks
                }
                rtc.client.publish(tracks);
                localTracks.screenVideoTrack.on('track-ended', () => {
                    stopScreenShare();
                });
            }).catch(function(err) {
                console.error(err);
                stopScreenShare();
            });;  
        } else {
            stopScreenShare();
        }
             
    });

    window.stopScreenShare = function() {
        rtc.client.unpublish(rtc.localScreenTrack);
        localTracks.screenVideoTrack.close();
        if(localTracks.screenAudioTrack) {
            localTracks.screenAudioTrack.close();
        }
        
        $('#showHideWhiteBox').show();
        $('.video-off').show();
        //$('.video-off').trigger('click');
        $('.screen-share-on').children('span').removeClass('icon-close');
        $('.screen-share-on').children('span').addClass('icon-arrow_upward');
        $('.screen-share-on').find('.screen-sharing').text(Lang.get("labels.screen_share"));
    }


   
   

  
});