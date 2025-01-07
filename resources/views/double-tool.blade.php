<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Columnar Cipher</title>
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

    <div class="container">
        <h1>Double Columnar Cipher Tool</h1>
        <form id="cipherForm">
            @csrf
            <label for="text">Text</label>
            <input type="text" id="text" name="text" placeholder="Enter your text..." required>

            <label for="key1">Key 1</label>
            <input type="text" id="key1" name="key1" placeholder="Enter first key..." required>

            <label for="key2">Key 2</label>
            <input type="text" id="key2" name="key2" placeholder="Enter second key..." required>

            <label for="action">Action</label>
            <select id="action" name="action" required>
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>

            <button type="submit">Submit</button>
        </form>

        <div class="result" id="result">
            <h2>Result</h2>
            <p id="output">Your result will appear here...</p>
        </div>

        <div class="error" id="error"></div>
    </div>

    <script>
        document.getElementById('cipherForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const text = document.getElementById('text').value;
            const key1 = document.getElementById('key1').value;
            const key2 = document.getElementById('key2').value;
            const action = document.getElementById('action').value;

            if (!text || !key1 || !key2) {
                document.getElementById('error').innerText = 'All fields are required.';
                return;
            }

            document.getElementById('error').innerText = '';

            const formData = new FormData();
            formData.append('text', text);
            formData.append('key1', key1);
            formData.append('key2', key2);
            formData.append('action', action);

            // Ensure you use the correct route for your form submission
            fetch("{{ route('double-tool.process') }}", {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('error').innerText = data.error;
                } else {
                    document.getElementById('output').innerText = data.result;  // Display the result here
                }
            })
            .catch(error => {
                document.getElementById('error').innerText = 'An error occurred. Please try again later.';
            });
        });
    </script>
</body>
</html>
