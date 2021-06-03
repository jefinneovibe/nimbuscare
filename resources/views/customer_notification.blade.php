<!DOCTYPE html>
<html lang="en">
<head>
    <title>Interactive Insurance Brokers LLC</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900');
        body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;}
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
        img{-ms-interpolation-mode:bicubic;}
        body{margin:0; padding:0;background-color: #eff2f7; font-family: 'Montserrat', sans-serif;}
        img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
        table{border-collapse:collapse !important;}
        body{height:100% !important; margin:0; padding:0; width:100% !important;}
    </style>
</head>
<body style="margin: 0; padding: 0;">

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" bgcolor="#eff2f7">
    <tr>
        <td>
            <table class="mn_tbl" border="0" cellpadding="0" cellspacing="0" width="600" style="margin: 0px auto;width: 600px;">
                <tr>
                    <td>
                        <table class="mn_tbl_bg" border="0" cellpadding="30" cellspacing="0" bgcolor="#fff" style="width: 100%;border-radius: 8px;text-align: center">
                            <tr>
                                <td align="center">
                                    <img src="{{ URL::asset('img/main/interactive_logo.png')}}" width="150" class="logo">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="mn_info" style="text-align: left">

                                        <br>
                                        <div style="height: 18px;"></div>
                                        <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                            <div>
                                                @if(session('msg'))
                                                    <h2>{{session('msg')}}</h2>
                                                @endif
                                            </div></h2>
                                        @if(session('msg') == "You have approved the proposal for workman's compensation")
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                                <br> Reference Number : {{session('refNo')}}</br>
                                                <br>Your Insurer is : {{session('insurer')}}</br>
                                            </h2>
                                            @elseif(session('msg') == "You have approved the proposal for employers liability")
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                                <br> Reference Number : {{session('refNo')}}</br>
                                                <br>Your Insurer is : {{session('insurer')}}</br>
                                            </h2>
                                        @elseif(session('msg') == 'You have already filled the E-questionnaire' || session('msg') == 'You have successfully filled the e-questionnaire')
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                                <br>Your Reference Number is : {{session('refNo')}}</br>
                                                <br> Our team of qualified professionals will assess your requirements and revert to you at the earliest.</br>
                                            </h2>
                                        @elseif(session('msg') == 'We have received your feedback on the proposal')
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                                <br> Reference Number : {{session('refNo')}}</br>
                                                <br> Our team of qualified professionals will assess your requirements and revert to you at the earliest.</br>
                                            </h2>
                                        @endif

                                        <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                            For any clarifications please contact <a href="mailto:info@iibcare.com">info@iibcare.com</a> or call +9714 2944399 (Sunday-Thursday, 7:30am to 5:00pm)
                                        </h2>
                                    <div style="height: 32px;"></div>
                                    <div class="wishes" style="text-align: left">
                                        <h3 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">Best wishes!</h3>
                                        <div style="height: 5px;"></div>
                                        <p style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                            Interactive Insurance Brokers LLC
                                        </p>
                                    </div>

                                    <div style="height: 10px;"></div>
                                    </div>
                                </td>
                            </tr>

                        </table>
                        <div style="height: 100px;"></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>