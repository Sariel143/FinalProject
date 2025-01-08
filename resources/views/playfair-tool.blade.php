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

    <div class="navbar">
        <a href="{{ route('index') }}">Home</a>
        <a href="{{ route('about-us') }}">About Us</a>
        <a href="{{ route('contact-us') }}">Contact</a>
    </div>

    <div class="container">
        <h1>Playfair Cipher</h1>

        <form id="cipherForm" method="POST" action="{{ route('playfair-tool.process') }}">
        @csrf
        <label for="text">Text:</label>
        <input type="text" id="text" name="text" required>

        <label for="key">Key:</label>
        <input type="text" id="key" name="key" required>

        <label for="action">Action:</label>
        <select id="action" name="action">
            <option value="encrypt">Encrypt</option>
            <option value="decrypt">Decrypt</option>
        </select>

        <button type="submit">Submit</button>
    </form>

    <div id="result"></div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const form = document.getElementById('cipherForm');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const text = document.getElementById('text').value;
            const key = document.getElementById('key').value;
            const action = document.getElementById('action').value;

            try {
                const response = await axios.post('{{ route("playfair-tool.process") }}', {
                    text,
                    key,
                    action
                });

                document.getElementById('result').innerHTML = `
                    <div class="result">
                        <h2>Result</h2>
                        <p><strong>${action === 'encrypt' ? 'Encrypted' : 'Decrypted'} Text:</strong> ${response.data.result}</p>
                    </div>
                `;
            } catch (error) {
                const errorMessage = error.response?.data?.error || 'An unexpected error occurred.';
                document.getElementById('result').innerHTML = `
                    <div class="error">
                        <p><strong>Error:</strong> ${errorMessage}</p>
                    </div>
                `;
            }
        });
    </script>
</body>
</html>
