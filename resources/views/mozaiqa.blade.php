<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$clientName}}</title>

    <!-- Fonts -->
<!--
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
     -->

</head>

<body>

<img src="https://static10.tgstat.ru/channels/_0/4c/4c626c10f5e4e769e638c3acf58117e1.jpg"/>

<script>
    let correct_request_id='<?php echo $correct_request_id?>';
    let promotionDuration='<?php echo $promotionDuration?>';

    setTimeout(() => {

        let body = 'isConversion=' + encodeURIComponent('yes');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", 'https://nfc-u.ru/api/uid/update/'+correct_request_id, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(body);

        let redirectTo = '<?php echo $redirectTo?>';
        window.location.href = redirectTo;

    },promotionDuration * 1000);
</script>

</body>

</html>
