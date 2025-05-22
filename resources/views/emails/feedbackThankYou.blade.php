<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thank You for Your Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f4f4;
            padding-bottom: 60px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            font-family: sans-serif;
            color: #333333;
        }
        .header {
            background-color: #0067ce;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            margin: 0;
        }
        .content {
            padding: 35px;
        }
        .message {
            font-style: italic;
            color: #555;
            border-left: 4px solid #003366;
            padding-left: 15px;
            margin: 20px 0;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main" width="100%">
            <!-- Header -->
            <tr>
                <td class="header">
                    <h1>Thank You for Your Feedback</h1>
                </td>
            </tr>
            <!-- Content -->
            <tr>
                <td class="content">
                    <p>Dear Valued Customer,</p>
                    <p>We sincerely appreciate you taking the time to provide us with your feedback. Your input is invaluable to us and helps us improve our services.</p>
                    <p>We have received your message:</p>
                    <div class="message">
                        {{ $feedback['message'] }}
                    </div>
                    <p>Rest assured that your feedback has been forwarded to the appropriate department for review. If necessary, a member of our team will be in touch with you shortly.</p>
                    <p>Thank you once again for helping us serve you better.</p>
                    <p>Best regards,<br>Customer Support Team</p>
                </td>
            </tr>
            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} Event Master pro. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>