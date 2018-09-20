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

        .sendPush{

            font-family: "Roboto" , Arial, sans-serif;
            font-size: 11px;

        }

        .sendPush a{
            color: inherit;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Pusher</div>
        @if(\Session::has('message'))
            <div class="quote">{{Session::get('message')}}</div>
        @endif
        <div class="sendPush">
            <a href="{{URL::action('\SysMl\Laratchet\Controllers\LaratchetController@pushTest')}}">Send push to clients.</a>
        </div>
    </div>
</div>

</body>
</html>
