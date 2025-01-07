<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playfair Cipher</title>
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
            text-transform: uppercase;
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
    <div class="container mt-5">
        <h1 class="text-center mb-4">Single Columnar Cipher</h1>
        <form id="cipherForm" method="POST" action="{{ route('single-tool.process') }}">
            @csrf
            <div class="mb-3">
                <label for="text" class="form-label">Text</label>
                <input type="text" class="form-control" id="text" name="text" required>
            </div>
            <div class="mb-3">
                <label for="key" class="form-label">Key</label>
                <input type="text" class="form-control" id="key" name="key" required>
            </div>
            <div class="mb-3">
                <label for="action" class="form-label">Action</label>
                <select class="form-select" id="action" name="action" required>
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Process</button>
        </form>

        <div class="mt-4" id="result" style="display: none;">
            <h3>Result:</h3>
            <pre id="cipherOutput"></pre>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#cipherForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                url: "{{ route('single-tool.process') }}",
                method: "POST",
                data: formData,
                success: function (response) {
                    $('#cipherOutput').text(JSON.stringify(response, null, 2));
                    $('#result').show();
                },
                error: function (error) {
                    alert('An error occurred. Please check your inputs.');
                }
            });
            });
        });
    </script>
</body>
</html>
