<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#f3f3f3!important">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title></title>
    <style>
        @media only screen {
            html {
                min-height: 100%;
                background: #f3f3f3
            }
        }

        @media only screen and (max-width:596px) {
            table.body img {
                width: auto;
                height: auto
            }

            table.body center {
                min-width: 0 !important
            }

            table.body .container {
                width: 95% !important
            }

            table.body .columns {
                height: auto !important;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                padding-left: 16px !important;
                padding-right: 16px !important
            }

            table.body .columns .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }

            table.body .collapse .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }

            th.small-6 {
                display: inline-block !important;
                width: 50% !important
            }

            th.small-12 {
                display: inline-block !important;
                width: 100% !important
            }

            .columns th.small-12 {
                display: block !important;
                width: 100% !important
            }
        }

        @media only screen and (max-width:480px) {
            .secondary .price {
                display: block;
                margin-left: 0;
                Margin-left: 0
            }
        }

        @media screen and (max-width:596px) {

            .footer p,
            .footer th {
                text-align: center
            }
        }
    </style>
</head>
<body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#f3f3f3!important;box-sizing:border-box;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"><span
        class="preheader" style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span>
    <table class="body" style="Margin:0;background:#f3f3f3!important;border-collapse:collapse;border-spacing:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;width:100%">
        <tr style="padding:0;text-align:left;vertical-align:top">
            <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
              <center data-parsed="" style="min-width:580px;width:100%">
                 {{-- Header --}}
                  {{ $header ?? '' }}
                    {{-- Content --}}
                    <table align="center" class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
                        <tbody>
                            <tr style="padding:0;text-align:left;vertical-align:top">
                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:2.125;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                    <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                            <tr style="padding:0;text-align:left;vertical-align:top">
                                                <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                            <tr style="padding:0;text-align:left;vertical-align:top">
                                                <th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                            <th style="Margin:0;color:#333;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:2.125;margin:0;padding:0;text-align:left">
                                                            {{ $slot }}
                                                            </th>
                                                          </tr>
                                                      </table>
                                                  </th>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                    {{-- Footer --}}
                    {{ $footer ?? '' }}
                </center>
            </td>
        </tr>
    </table><!-- prevent Gmail on iOS font size manipulation -->
    <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
</body>
</html>
