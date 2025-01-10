<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h1>OTP Verification</h1>
    <p>Hi, {{ $user->username }},</p>
    <p>Your OTP for verification is: <strong>{{ $user->otp }}</strong></p>
    <p>Please use this OTP to complete your registration.</p>
</body>
</html>
