<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notification Email</title>
</head>

<body
    style="font-family: Arial, sans-serif; color: #333333; background-color: #ffffff; padding: 20px; font-size: 16px; line-height: 1.5;">
    <div style="max-width: 600px; margin: auto; border: 1px solid #cccccc; padding: 20px; background-color: #f9f9f9;">
        <h1 style="color: #444444; font-size: 24px;">{{ $messageContent['title'] }}</h1>
        <p>{{ $messageContent['body'] }}</p>
        @if (!empty($messageContent['reply']))
            <p style="padding: 15px; background-color: #e2e2e2; border-left: 5px solid #007BFF; margin-top: 20px;">
                <strong>Reply:</strong> {{ $messageContent['reply'] }}
            </p>
        @endif
    </div>
</body>

</html>
