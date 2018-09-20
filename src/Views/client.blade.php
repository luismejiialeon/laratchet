<html>
<head>
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
            margin-bottom: 40px;
        }

        .quote {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .visit{

            font-family: "Roboto" , Arial, sans-serif;
            font-size: 11px;

        }

        .visit a{
            color: inherit;
        }

        p.warning{
            color:orangered;
            font-family: Roboto;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Client</div>
        <div class="quote">
            @if(!class_exists('ZMQContext'))
                <p class="warning">Warning: ZeroMQ is not available on your system. Push will not work.</p>
                <p class="warning"><a target="_blank" href="http://jackbennett.co/2013/11/using-omq-zeromq-with-vagrant-and-virtualbox/">Howto</a> install ZMQ on vagrant</p>
                <p class="warning">Or <a href="http://alexandervn.nl/2012/05/03/install-zeromq-php-ubuntu/">build</a> on your own</p>
            @endif
        </div>
        <div class="visit">Hint: Visit <a target="_blank" href="{{URL::action('\Barrot\Laratchet\Controllers\LaratchetController@pusher')}}">this page</a> to send push messages.</div>
    </div>
</div>

<!-- Scripts -->
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script>

    var count = 0;
    var conn = new ab.Session('{{Config::get('laratchet.clientPushServerSocket')}}',
            function() {
                conn.subscribe('{{(Config::get('laratchet.demoPushChannel'))}}', function(topic, data) {
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                    console.log('Got push nr. '+count);
                    count++;
                    $('.quote').html("I got "+count+" laratchet message(s).");
                });
            },
            function() {
                console.warn('WebSocket connection closed');
            },
            {'skipSubprotocolCheck': true}
    );

</script>
</body>
</html>
