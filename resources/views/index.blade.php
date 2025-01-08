<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Belandres</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
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
            text-align: center;
            border-radius: 20px;
            margin-top: 70px;
            margin-left: 300px;
            padding: 50px 30px;
            max-width: 650px;
            width: 90%;
        }

        h1 {
            font-size: 36px;
            color: #fff;
            margin-bottom: 40px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .button-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .button-container button {
            background-color: black;
            color: white;
            padding: 20px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .button-container a {
            text-decoration: none;
            width: 100%;
        }

        .button-container button:hover {
            background-color: black;
            transform: translateY(-6px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .button-container button:active {
            transform: translateY(3px);
        }

        .alert {
            margin-top: 30px;
            font-size: 16px;
            color: white;
            background-color: #333;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
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
        <h1>Secret Messaging Techniques</h1>
        
        <div class="button-container">
            <a href="{{ route('caesar-cipher.form') }}">
                <button>Caesar Cipher</button>
            </a>
            <a href="{{ route('vigenere-cipher.form') }}">
                <button>Vigenère Cipher</button>
            </a>
            <a href="{{ route('playfair-tool.form') }}">
                <button>Playfair Cipher</button>
            </a>
            <a href="{{ route('single-tool.form') }}">
                <button>Single Columnar</button>
            </a>
            <a href="{{ route('double-tool.form') }}">
                <button>Double Columnar</button>
            </a>
            <a href="{{ route('aes-tool') }}">
                <button>AES Cipher</button>
            </a>
        </div>

        <div class="alert" id="alertMessage">
            Navigating to the selected cipher method...
        </div>
    </div>

    <div class="footer">
        <p>© 2025 Team Belandres. All rights reserved.</p>
    </div>

    <script>
        function navigateTo(cipher) {
            document.getElementById('alertMessage').style.display = 'block';
            setTimeout(function() {
                window.location.href = cipher;
            }, 1500);
        }
    </script>

</body>
</html>
