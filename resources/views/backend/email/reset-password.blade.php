<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <style>
        table,
        td,
        div,
        h1,
        p {
            font-weight: 500;
            font-family: Arial, sans-serif;
        }

        .btn {
            margin: 10px 0;
            border-radius: 4px;
            text-decoration: none;
            color: #fff !important;
            height: 46px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            background-image: linear-gradient(to right top, #021d68, #052579, #072d8b, #09369d, #093fb0) !important;
        }

        .btn:hover {
            text-decoration: none;
            opacity: .8;
        }
    </style>
</head>
<body style="margin:0;padding:0;">
<table role="presentation"
       style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
        <td align="center" style="padding:0;">
            <table role="presentation"
                   style="width:600px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                <tr style="border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;">
                    <td align="left" style="padding:10px 25px;background:#fff; display: flex; align-items: center;">
                        <span style="font-weight: bold; padding-top: 10px;"> Xác nhận đặt lại mật khẩu </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:36px 30px 42px 30px;">
                        <table role="presentation"
                               style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                            <tr>
                                <td style="padding:0 0 36px 0;color:#153643;">
                                    <p style="font-weight:bold;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                                        Xin chào
                                    <h1> {{ $customer_account ? $customer_account->name : '' }},</h1>
                                    <p
                                        style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
                                        Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn.
                                    </p>
                                    <p
                                        style="margin:10px 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
                                        Bạn có thể đặt lại mật khẩu bằng cách click vào liên kết dưới đây. Liên kết chỉ có hiệu lực trong vòng 5 phút!
                                    </p>

                                    <p style="text-align: center;">
                                        <a style="cursor: pointer"
                                           href="{!! $forgot_password_url !!}"
                                           class="btn">Đặt lại mật khẩu</a>
                                        {!! $forgot_password_url !!}}
                                    </p>

                                    <p style="margin:35px 0 12px 0;font-size:14px;font-family:Arial,sans-serif;">
                                        Nếu không phải bạn. Vui lòng bỏ qua email này
                                        <br>
                                        Xin chân thành cảm ơn! </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
