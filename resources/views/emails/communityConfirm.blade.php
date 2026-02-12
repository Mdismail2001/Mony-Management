<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Community Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9fafb; padding:20px">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:8px">

        <h2 style="color:#111827;">
            You’re invited to join <span style="color:#10b981">{{ $community->name }}</span>
        </h2>

        <p style="color:#374151; font-size:14px;">
            You have been invited to join the community
            <strong>{{ $community->name }}</strong>.
        </p>

        <p style="margin:30px 0;">
            <a href="{{ $confirmLink }}"
               style="background:#10b981; color:white; padding:12px 20px;
                      text-decoration:none; border-radius:6px; font-weight:bold;">
                Confirm & Join Community
            </a>
        </p>

        <p style="font-size:12px; color:#6b7280;">
            This link will expire in 7 days.  
            If you did not expect this invitation, you can safely ignore this email.
        </p>

        <hr style="margin:30px 0">

        <p style="font-size:12px; color:#9ca3af;">
            {{ config('app.name') }}
        </p>

    </div>

</body>
</html>
