<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caesar Cipher</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
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
            margin: 120px auto; /* Adjust for navbar */
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
            text-transform: uppercase;
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

    <!-- Main Content -->
    <div class="container">
        <h1>Caesar Cipher</h1>

        <!-- Form -->
        <form action="{{ route('caesar-cipher.process') }}" method="POST">
            @csrf
            <label for="textInput">Text</label>
            <textarea name="textInput" id="textInput" rows="5">{{ old('textInput') }}</textarea>

            <label for="shiftInput">Shift</label>
            <input type="number" name="shiftInput" value="{{ old('shiftInput') }}" required>

            <label for="action">Action</label>
            <select name="action" id="action" required>
                <option value="encrypt" {{ old('action') === 'encrypt' ? 'selected' : '' }}>Encrypt</option>
                <option value="decrypt" {{ old('action') === 'decrypt' ? 'selected' : '' }}>Decrypt</option>
            </select>

            <button type="submit">Submit</button>
        </form>

        <!-- Result -->
        @if(isset($result))
            <div class="result">
                <h2><strong>Caesar Cipher Result</strong></h2>
                <p><strong>Action:</strong> {{ ucfirst($action) }}</p>
                <p><strong>Original Text:</strong> {{ $textInput }}</p>
                <p><strong>Shift:</strong> {{ $shiftInput }}</p>
                <p><strong>Result:</strong> {{ $result }}</p>
            </div>
        @elseif ($errors->any())
            <div class="error">
                <p><strong>Error:</strong> Please fill out all fields correctly.</p>
            </div>
        @endif
    </div>

</body>
</html>
