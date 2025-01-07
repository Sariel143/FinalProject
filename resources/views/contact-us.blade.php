<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Belandres</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('frog.jpg') }}" type="image/x-icon">

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
        /* Reset some basic styles */
        body, h1, a {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        /* Body styles */
        body {
            background: linear-gradient(135deg, #ff7c7c, #5b86e5); /* Gen Z gradient */
            color: #333;
            line-height: 2;
            padding: 0;
            font-size: 16px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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


        /* Header styling */
        h1 {
            font-size: 40px;
            color: #2c3e50;
            text-align: center;
            margin-top: 60px; /* Reduced top margin */
            margin-bottom: 30px;
            font-weight: 600;
        }

        /* Contact Section Styling */
        .contact-section {
            margin-top: -45px; /* Adjusted for the navbar */
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0 20px;
        }

        .contact-text {
            flex: 1;
            margin-top: 80px; /* Added margin-top */
            max-width: 45%;
        }

        .contact-form {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            padding: 17px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            background: linear-gradient(145deg, #e6e6e6, #ffffff);
        }

        .contact-form input,
        .contact-form textarea {
            width: 95%;
            padding: 8px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f4f4f4;
            transition: all 0.3s ease;
        }

        .contact-form input[type="submit"] {
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
            border-radius: 8px;
            padding: 12px;
        }

        .contact-form input[type="submit"]:hover {
            background-color: black;
        }

        /* Mobile-responsive tweaks */
        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }
            .contact-form input, .contact-form textarea {
                font-size: 14px;
                padding: 12px;
            }
            .contact-section {
                flex-direction: column;
                align-items: center;
            }
            .contact-text, .contact-form {
                max-width: 100%;
            }
        }

        /* Footer */
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

    <!-- Navbar -->
    <div class="navbar">
        <a href="{{ route('index') }}">Home</a>
        <a href="{{ route('about-us') }}">About Us</a>
        <a href="{{ route('contact-us') }}">Contact</a>
    </div>

    <div class="container">
        <h1>Contact Us</h1>

        <!-- Contact Section -->
        <div class="contact-section">
            <!-- Contact Text -->
            <div class="contact-text">
                <h2>Get in Touch</h2>
                <p>If you have any questions, feel free to contact us using the form on the right side.</p>
            </div>

            <!-- Contact Form -->
            <form class="contact-form" method="POST" action="#">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="6" required></textarea>
                <input type="submit" value="Send Message">
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2025 Team Belandres. All rights reserved.</p>
    </div>

</body>
</html>
