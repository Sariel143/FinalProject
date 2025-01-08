<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Cipher Tool</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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

        /* Navbar */
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

        /* Container */
        .container {
            max-width: 600px;
            margin: 120px auto;
            padding: 30px 20px;
            background-color: #222;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 36px;
            color: #fff;
            margin-bottom: 20px;
            font-weight: bold;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: left;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #333;
            color: #fff;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #ff7c7c;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        button:hover {
            background-color: #5b86e5;
            transform: translateY(-4px);
        }

        button:active {
            transform: translateY(2px);
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            background-color: #333;
            border-radius: 8px;
            text-align: center;
        }

        .error {
            margin-top: 20px;
            color: #f44336;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="{{ route('index') }}">Home</a>
        <a href="{{ route('about-us') }}">About Us</a>
        <a href="{{ route('contact-us') }}">Contact</a>
    </div>

    <div class="container">
        <h1>AES Cipher Tool</h1>
        <form method="POST" action="{{ url('/aes-tool') }}">
            @csrf
            <label for="text">Input Text:</label>
            <textarea id="text" name="text" rows="4" required>{{ old('text') }}</textarea>

            <label for="key">Key (Max 16 Characters):</label>
            <input type="text" id="key" name="key" maxlength="16" required>

            <label for="mode">Mode:</label>
            <select id="mode" name="mode">
                <option value="encrypt" {{ old('mode') === 'encrypt' ? 'selected' : '' }}>Encrypt</option>
                <option value="decrypt" {{ old('mode') === 'decrypt' ? 'selected' : '' }}>Decrypt</option>
            </select>

            <button type="submit">Submit</button>
        </form>

        @if(session('error'))
            <div class="error">
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: "{{ session('error') }}"
                    });
                </script>
            </div>
        @endif

        @if(session('output'))
            <div class="result">
                <h2>Solution and Result:</h2>
                <pre>{{ session('output') }}</pre>
            </div>
        @endif
    </div>
</body>
</html>
