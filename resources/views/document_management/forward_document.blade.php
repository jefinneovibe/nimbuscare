<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .mailContainer{
        /* margin: 2% 20%; */
        /* padding: 10px; */
    }
    .border{
        border: 1px solid lightgray;
        width: 75%;
        margin: 23px auto;
    }
    .font{
        font-size: 16px;
    }
    .erta-body {
        border-bottom: 1px solid lightgray;
        /* width: 100%; */
        padding: 20px 12px 20px 12px;
        color: #4c688a;
        font-family: "Roboto",sans-serif;
        font-size: 15px;
        font-style: italic;
        font-weight: 500;
    }
    .comments_head{
        font-size: 15px;
        color: #757171;
        margin-top: 0;
    }
    
    </style>
</head>
<body>
    <div id="content" class="mailContainer border font">
        @if($body!="")
            <div class="erta-body">
                {{$body}}
            </div>
        @endif
        <div style="padding:10px">{!! $mail !!}</div>
    </div>
    
</body>
<script>

</script>
</html>