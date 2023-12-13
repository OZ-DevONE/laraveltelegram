<!DOCTYPE html>
<html>
<head>
    <title>Bot Status</title>
</head>
<body>
    <h1>Telegram Bot Status</h1>
    @if($connected)
        <p>Connected to bot: {{ $botName }}</p>
    @else
        <p>Error: Connection to bot failed.</p>
    @endif
</body>
</html>
