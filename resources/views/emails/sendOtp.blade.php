<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
</head>
<body>
    <p>Hello <strong>{{ $userName }}</strong>,</p>

    <p>Your OTP code is:</p>

    <h2 style="letter-spacing: 2px;">{{ $otp }}</h2>

    <p>This code will expire in <strong>5 minutes</strong>.</p>

    <br>

    <p style="font-size: 12px; color: #666;">
        If you did not request a password reset, please ignore this email.
    </p>
</body>
</html>
