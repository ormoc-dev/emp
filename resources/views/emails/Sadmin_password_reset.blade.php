<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .email-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 35px;
            border-bottom: 2px solid #fee2e2;
            padding-bottom: 20px;
        }
        .logo {
            color: #dc2626;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        .logo-accent {
            color: #991b1b;
        }
        h1 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 25px;
            border-left: 4px solid #dc2626;
            padding-left: 15px;
        }
        .message {
            background-color: #fef2f2;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc2626;
        }
        .password-container {
            background: linear-gradient(145deg, #ffffff, #fef2f2);
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            text-align: center;
            border: 1px solid #fee2e2;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1);
        }
        .password-label {
            color: #991b1b;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .password {
            font-family: 'Courier New', monospace;
            font-size: 32px;
            color: #dc2626;
            font-weight: bold;
            letter-spacing: 3px;
            padding: 10px 20px;
            background-color: #fff;
            border-radius: 6px;
            display: inline-block;
            margin: 10px 0;
            border: 2px dashed #fca5a5;
        }
        .warning {
            background-color: #fff5f5;
            color: #dc2626;
            font-size: 14px;
            margin-top: 25px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #fecaca;
        }
        .warning-icon {
            font-weight: bold;
            margin-right: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            border-top: 2px solid #fee2e2;
            padding-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Event <span class="logo-accent">Master-Pro</span></div>
        </div>
        
        <h1>Welcome Back, {{ $name }}!</h1>
        
        <div class="message">
            Your account password has been successfully reset. Please use the following credentials to access your account.
        </div>
        
        <div class="password-container">
            <div class="password-label">Your New Password</div>
            <div class="password">{{ $password }}</div>
        </div>
        
        <a href="{{ url('/login') }}" class="button">
            Login to Your Account
        </a>
        
        <div class="warning">
            <span class="warning-icon">⚠️</span>
            For your security, we strongly recommend changing this password immediately after logging in to your account.
        </div>
        
        <div class="footer">
            <p>This is an automated message from Event Master-Pro. Please do not reply.</p>
            <p>If you didn't request this password reset, please contact support immediately.</p>
            <p>&copy; {{ date('Y') }} Event Master-Pro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>