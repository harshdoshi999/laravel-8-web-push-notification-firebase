@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center>
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyB28u----------------aIPB4XjcUI_4hU",
        authDomain: "app-name.firebaseapp.com",
        projectId: "app-name",
        storageBucket: "app-name.appspot.com",
        messagingSenderId: "7952----2724",
        appId: "1:795-------5bbe7d16f11",
        measurementId: "G-XXXXXXX"
    };
      
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    
    messaging
    .requestPermission()
    .then(function () {
        return messaging.getToken()
    })
    .then(function(token) {
        console.log(token);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ route("save-token") }}',
            type: 'POST',
            data: {
                token: token
            },
            dataType: 'JSON',
            success: function (response) {
                alert('Token saved successfully.');
            },
            error: function (err) {
                console.log('User Chat Token Error'+ err);
            },
        });

    }).catch(function (err) {
        console.log('User Chat Token Error'+ err);
    });

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: "https://www.kabbage.com/favicon.ico",
        };
        var n = new Notification(noteTitle, noteOptions);
    });
    
</script>
@endsection