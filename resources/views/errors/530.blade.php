<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            text-align: center;
        }
        .message {
            font-size: 24px;
            color: #333;
        }
        .image {
            margin-top: 20px;
        }
        .image img {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="message">Your IP is not allowed</div>
    {{ request()->ip() }}
    <div class="image">
        <img src="data:image/png;base64,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">
    </div>
</div>
</body>
</html>
