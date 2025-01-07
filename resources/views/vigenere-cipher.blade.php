<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vigenère Cipher</title>
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

        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 30px;
            background-color: #222;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 36px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background-color: #333;
            color: #fff;
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
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
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
        <h1>Vigenère Cipher</h1>
        <form id="cipherForm">
            @csrf
            <textarea name="text" placeholder="Enter text to encrypt or decrypt" rows="5"></textarea>
            <input type="text" name="key" placeholder="Enter key">
            <select name="action">
                <option value="encrypt">Encrypt</option>
                <option value="decrypt">Decrypt</option>
            </select>
            <button type="submit">Submit</button>
        </form>
        <div id="result" class="result" style="display: none;"></div>
    </div>

    <script>
        document.getElementById('cipherForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const response = await fetch("{{ route('vigenere-cipher.process') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                }
            });

            const data = await response.json();
            const resultDiv = document.getElementById('result');
            resultDiv.style.display = 'block';
            if (data.status === 'success') {
                resultDiv.innerHTML = `<p><strong>Result:</strong> ${data.result}</p>`;
            } else {
                resultDiv.innerHTML = `<p style="color: #f44336;"><strong>Error:</strong> ${data.message}</p>`;
            }
        });
    </script>
</body>
</html>
