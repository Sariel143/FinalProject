<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AES Cipher Tool</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <style>
        /* Your CSS styles here */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            color: #000;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            color: #000;
            margin-bottom: 20px;
            font-weight: 600;
            font-style: italic;
        }

        form {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 400;
            color: #000;
        }

        textarea, input, select, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4a90e2;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 600;
        }

        button:hover {
            background-color: #357ABD;
        }

        h2 {
            color: #4a90e2;
            margin-top: 20px;
            font-weight: 600;
        }

        pre {
            background: #e8f4fc;
            border-left: 5px solid #4a90e2;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <h1>AES Cipher Tool</h1>
    <form method="POST" action="{{ url('/aes-tool') }}">
        @csrf
        <label for="text">Input Text:</label>
        <textarea id="text" name="text" rows="4" required>{{ old('text') }}</textarea>

        <label for="key">Key:</label>
        <input type="text" id="key" name="key" maxlength="16" required>

        <label for="mode">Mode:</label>
        <select id="mode" name="mode">
            <option value="encrypt" {{ old('mode') === 'encrypt' ? 'selected' : '' }}>Encrypt</option>
            <option value="decrypt" {{ old('mode') === 'decrypt' ? 'selected' : '' }}>Decrypt</option>
        </select>

        <button type="submit">Submit</button>
    </form>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        </script>
    @endif

    @if(session('output'))
        <h2>Solution and Result:</h2>
        <pre>{{ session('output') }}</pre>
    @endif

</body>
</html>
