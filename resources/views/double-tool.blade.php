<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Columnar Cipher</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }

        /* Navbar */
        .navbar {
            width: 100%;
            background-color: #222;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 15px 0;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
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
            max-width: 800px;
            margin: 120px auto;
            padding: 40px 25px;
            background-color: #222;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 36px;
            color: #fff;
            margin-bottom: 25px;
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
            transition: 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #ff7c7c;
            outline: none;
        }

        .input-group {
            display: flex;
            justify-content: space-between;
            gap: 20px;

        }

        .input-group label {
            width: 48%;
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

        .result h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .error {
            margin-top: 20px;
            color: #f44336;
            font-weight: bold;
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
        <h1>Double Columnar Cipher Tool</h1>
        <form id="cipherForm" method="POST" action="{{ route('double-tool.process') }}">
            @csrf
            <label for="text">Text</label>
            <input type="text" id="text" name="text" placeholder="Enter your text..." required>

            <div class="input-group">
                <label for="key1">Key 1</label>
                <label for="key2">Key 2</label>
            </div>
            <div class="input-group">
                <input type="text" id="key1" name="key1" placeholder="Enter first key..." required>
                <input type="text" id="key2" name="key2" placeholder="Enter second key..." required>
            </div>

            <label for="action">Action</label>
            <select id="action" name="action" required>
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>

            <button type="submit">Submit</button>
        </form>

        <!-- Results Section -->
        <div id="output" class="result"></div>
        
        <!-- Error Handling -->
        <div class="error" id="error"></div>
    </div>

    <script>
        document.getElementById('cipherForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const text = document.getElementById('text').value;
            const key1 = document.getElementById('key1').value;
            const key2 = document.getElementById('key2').value;
            const action = document.getElementById('action').value;

            // Validate fields
            if (!text || !key1 || !key2) {
                document.getElementById('error').innerText = 'All fields are required.';
                return;
            }

            document.getElementById('error').innerText = ''; // Clear error

            const formData = new FormData();
            formData.append('text', text);
            formData.append('key1', key1);
            formData.append('key2', key2);
            formData.append('action', action);

            // Retrieve the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('double-tool.process') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                text: text,
                key1: key1,
                key2: key2,
                action: action
            }),
        })
            .then(response => response.json())
            .then(data => {
            if (data.error) {
                document.getElementById('error').innerText = data.error;
            } else {
                // Display both results
                document.getElementById('output').innerHTML = `
                    <h3>Result:</h3>
                    <p><strong>Action:</strong> ${data.action}</p>
                    <p><strong>Key 1:</strong> ${data.key1}</p>
                    <p><strong>Output 1:</strong> ${data.result1}</p>
                    <p><strong>Key 2:</strong> ${data.key2}</p>
                    <p><strong>Output 2:</strong> ${data.result2}</p>
                `;
            }
        })
            .catch(error => {
                document.getElementById('error').innerText = 'An error occurred. Please try again later.';
            });
        });
    </script>
</body>
</html>
