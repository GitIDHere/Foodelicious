<html style="margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;font-size:16px;color:#000000;background-color:#F3F3F3;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;" lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title>{{env('APP_NAME')}} | Foodelicious</title>
        <style type="text/css">
            td {
                border-collapse: collapse;
                mso-table-lspace: 0;
                mso-table-rspace: 0;
            }
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                font-size : 16px;
                color : #000000;
                background : #EEEEEE;
            }
            body, h1, h2, h3, h4, h5, h6, p, a, li, ol {
                font-family: helvetica, arial, sans-serif;
                -ms-text-size-adjust: none;
                -webkit-text-size-adjust: none;
                color : #000000;
            }
            h1 {
                font-family:Arial, Helvetica, sans-serif;
                font-size:24px;
                line-height:30px;
                color:#40ba37;
                font-weight:bold;
                margin:0px;
                padding:0px;
            }
            h2 {
                font-family:Arial, Helvetica, sans-serif;
                font-size:18px;
                line-height:24px;
                color:#231F20;
                font-weight:bold;
                margin:0px;
                padding:0px;
            }
            h3 {
                font-family:Arial, Helvetica, sans-serif;
                font-size:16px;
                line-height:22px;
                color:#231F20;
                font-weight:bold;
                margin:0px;
                padding:0px;
            }
            h4 {
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
                line-height:20px;
                color:#231F20;
                font-weight:bold;
                margin:0px;
                padding:0px;
            }
            p {
                margin:7px 0 !important;
                padding:0px !important;
            }
            a.email-btn
            {
                display: inline-block;
                background-color: #40ba37;
                padding: 10px 28px 10px 14px;
                color: #FFFFFF;
                font-weight: bold;
                text-decoration: none;
                margin: 7px 0;
            }
            .imgscale {
                display:block;
                width : 100%;
                height : auto;
            }
            @media only screen and (max-width: 639px) {
                #container {
                    width:96% !important;
                }
                .columnContainer {
                    display:block !important;
                    width:100% !important;
                }
                .columnImage {
                    height:auto !important;
                    max-width:480px !important;
                    width:100% !important;
                }
                .leftColumn {
                    font-size:16px !important;
                    line-height:125% !important;
                }
                .rightColumn {
                    font-size:16px !important;
                    line-height:125% !important;
                }
                .rightColumnContainer {
                    width:94% !important;
                }
                table[class=devicewidthinner] {
                    width: 100% !important;
                }
                *[class].hide {
                    display: none !important;
                    width: 0 !important;
                }
            }
        </style>
    </head>
    <body style="margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;font-size:16px;background-color:#F3F3F3;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;font-family:helvetica, arial, sans-serif;-ms-text-size-adjust:none;-webkit-text-size-adjust:none;color:#000000;" cz-shortcut-listen="true">
    <table id="container" width="640" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;"><table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
                    <tbody>
                    <tr>
                        <td style="font-size:16px;line-height:16px;" height="16">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px;padding-right:10px;" align="center"><!--Title table-->

                            <table width="96%" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tbody>
                                <tr>
                                    <td valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td style="font-size:24px; line-height:40px;" height="40"><a href="{{url('')}}"><img src="{{asset('/img/core-img/logo.png')}}" width="240" height="72" style="max-width:100%;display:block;height:auto;border:none; outline:none;" alt="Foodelicious" title="Foodelicious" /></a></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="font-family:Arial, Helvetica, sans-serif;font-size:22px;line-height:22px;color:#40ba37;font-weight:bold;" valign="top" align="left"><h1 style="font-family:Arial, Helvetica, sans-serif;font-size:24px;line-height:30px;color:#40ba37;font-weight:bold;margin:0px;padding:0px;">{{ ucwords($subject)  }}</h1></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:10px; line-height:10px;" height="10">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                </tbody>
                            </table>
                            <!--SubTitle table-->

                            <table width="96%" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tbody>
                                <tr>
                                    <td class="leftColumn" valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td><p class="font-bold" style="font-weight: bold">Dear {{ $recipientName  }}</p></td>
                                            </tr>
                                            <tr>
                                                <td style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:20px;color:#000000;"> @yield('content') </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:16px;line-height:16px;" height="16">&nbsp;</td>
                                            </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                                </tbody>
                            </table>
                            <!--End columns--></td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;line-height:16px;" height="16">&nbsp;</td>
                    </tr>
                    </tbody>
                </table></td>
        </tr>
        <tr>
            <td style="border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    </body>
</html>
