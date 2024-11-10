<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* Đặt kiểu cho toàn bộ trang */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 6em;
            margin-bottom: 0.2em;
            color: #588CD0;
        }

        h2 {
            font-size: 1.5em;
            color: #555;
            margin-bottom: 1em;
        }

        p {
            font-size: 1em;
            color: #666;
            line-height: 1.6em;
            margin-bottom: 2em;
        }

        .button {
            text-decoration: none;
            background-color: #588CD0;
            color: #fff;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #588CD0;
        }

        .illustration {
            max-width: 100%;
            height: auto;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>The page you're looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="{{route('home')}}" class="button">Go Back Home</a>
    </div>
</body>
</html>
