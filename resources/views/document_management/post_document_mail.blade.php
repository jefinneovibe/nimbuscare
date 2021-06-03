
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Email Template</title>
    <meta charset="utf-8">
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
                        <td align="center">
                            <table class="mn_tbl" border="0" cellpadding="0" cellspacing="0" style="margin: 0px auto;width: 600px;">
                                <tr>
                                    <td align="center">
                                        <img src="{{URL::asset('img/main/interactive_logo.png')}}" width="150">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2" style="line-height: 0">
                                    </td>
                                </tr>
                                <tr><td height="30"colspan="2"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="mn_tbl" border="0" cellpadding="0" cellspacing="0" width="600" style="margin: 0px auto;width: 600px;">
                    <tr>
                        <td>
                            <table class="mn_tbl_bg" border="0" cellpadding="30" cellspacing="0" bgcolor="#fff" style="width: 100%;border-radius: 8px;text-align: center">
                                <tr>
                                    <td>
                                        <div style="height: 10px;"></div>
                                        <h1 class="title" style="margin: 0;color: #078ac8;font-size: 20px;font-weight: 700;text-transform: uppercase;"> </h1>
                                        <hr style="height: 2px;background-color: #f1f4f7;border: none">
                                        <div style="height: 20px;"></div>
                                        <div class="mn_info" style="text-align: left">
                                            @php
                                                if($name=="")
                                                {
                                                    $name="Customer";
                                                }
                                            @endphp
                                            <h1 style="color: rgba(0,0,0,0.7);font-size: 16px;font-weight: 500;margin: 0">Dear <span style="color: #44acd8">Valued Customer,</span></h1>
                                            <br>
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                                {{-- <div>Dear customer,</div> --}}
                                                <div>
                                                    Interactive Insurance Brokers has shared an invoice with you. 
                                                    Please login to the IIB customer portal using the below details
                                                    to view the invoice.
                                                </div>
                                                <div>
                                                    @php
                                                        $url=url('/');
                                                    @endphp
                                                    Login link :  
                                                            <a style="color:#29b6f9;text-decoration:underline;font-weight:  600;font-size: 14px;" href="{{$url}}" target="_blank">
                                                                {{$url}}
                                                            </a>
                                                </div>
                                                <div>
                                                    Username :<span style="color:#078ac8">{{$userName}}</span>
                                                </div>
                                                <div>
                                                    Password:<span style="color:#078ac8">{{$passWard}}</span>
                                                </div>
                                            </h2>
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                            </h2>
                                            <h2 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">
                                                <br>For any clarifications please contact <a href="mailto:info@iibcare.com">info@iibcare.com</a> <br>
                                                or call  (+971) 042944399 (Sunday-Thursday, 7:30am to 5:00pm)
                                            </h2>
                                            <div style="height: 28px;"></div>

                                            <div class="wishes" style="text-align: left">
                                                <h3 style="color: rgba(0,0,0,0.7);font-weight: 500;line-height: 22px;font-size: 14px;margin: 0">Best wishes!</h3>
                                                <div style="font-weight: 600;line-height: 22px;font-size: 12px"> Team Interactive</div>
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