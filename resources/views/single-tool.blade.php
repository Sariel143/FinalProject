<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Columnar Cipher</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff7c7c, #5b86e5);
            color: #fff;
            font-size: 14px;
        }
        .navbar {
            width: 100%;
            background-color: #222;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
        }
        .navbar a:hover, .navbar a.active {
            background-color: #fff;
            color: #222;
        }
        .container {
            max-width: 600px;
            margin: 120px auto;
            padding: 30px 20px;
            background-color: #222;
            border-radius: 15px;
            text-align: center;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #ff7c7c;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
        }
        button:hover {
            background-color: #5b86e5;
        }
        .result {
            margin-top: 30px;
            background-color: #333;
            padding: 20px;
            border-radius: 8px;
        }
        .error {
            color: #f44336;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ route('index') }}">Home</a>
        <a href="{{ route('about-us') }}">About Us</a>
        <a href="{{ route('contact-us') }}">Contact</a>
    </div>
    <div class="container">
        <h1>Single Columnar Cipher</h1>
        <form id="cipherForm" method="POST" action="{{ route('single-tool.process') }}">
            @csrf
            <label for="text">Plain Text</label>
            <input type="text" id="text" name="text" required>
            <label for="key">Key</label>
            <input type="text" id="key" name="key" required>
            <label for="action">Action</label>
            <select id="action" name="action" required>
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>
            <button type="submit">Process</button>
        </form>
        @if (isset($ciphertext))
            <div class="result">
                <h3>Result:</h3>
                <p><strong>Action:</strong> {{ $action }}</p>
                <p><strong>Key:</strong> {{ $key }}</p>
                <p><strong>Steps:</strong></p>
                <p><strong>Output:</strong> {{ $ciphertext }}</p>
            </div>
        @endif
        @if (isset($error))
            <div class="error">{{ $error }}</div>
        @endif
    </div>
</body>
</html>
