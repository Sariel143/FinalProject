<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Belandres</title>
    <link rel="shortcut icon" href="{{ asset('frog.jpg') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        /* General Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff7c7c, #5b86e5); /* Gen Z gradient */
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
            text-align: center;
            border-radius: 20px;
            margin-top: 10px;
            padding: 50px 30px;
            max-width: 1200px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            font-size: 36px;
            color: #fff;
            margin-bottom: 40px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .team-section {
            text-align: center;
        }

        /* Team Member Styling */
        .team-members {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 items per row */
            gap: 20px;
            justify-items: center;
            margin-top: 30px;
        }

        .team-member {
            width: 200px;
            text-align: center;
        }

        .team-member img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
        }

        .team-member h3 {
            font-size: 22px;
            color: #fff;
        }

        .team-member p {
            font-size: 16px;
            margin-bottom: 100px;
            color: #ddd;
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

    <!-- Main Content -->
    <div class="container">
        <h1>Team Belandres</h1>

        <div class="team-section">
            <h2>Meet Our Team</h2>

            <div class="team-members">
                <!-- Team Member 1 -->
                <div class="team-member">
                    <img src="{{ asset('images/joshua.jpg') }}" alt="Joshua">
                    <h3>Joshua</h3>

                </div>

                <!-- Team Member 2 -->
                <div class="team-member">
                    <img src="{{ asset('images/pj.jpg') }}" alt="Philip">
                    <h3>Philip</h3>
  
                </div>

                <!-- Team Member 3 -->
                <div class="team-member">
                    <img src="{{ asset('images/wawang.jpg') }}" alt="Arielle">
                    <h3>Ariel</h3>

                </div>

                <!-- Team Member 4 -->
                <div class="team-member">
                    <img src="{{ asset('images/lloyd.jpg') }}" alt="Lloyd">
                    <h3>Lloyd</h3>

                </div>

                <!-- Team Member 5 -->
                <div class="team-member">
                    <img src="{{ asset('images/kanes.jpg') }}" alt="Kanes">
                    <h3>Kanes</h3>

                </div>

                <div class="team-member">
                    <img src="{{ asset('images/dave.png') }}" alt="Dave">
                    <h3>Dave</h3>

                </div>

                <div class="team-member">
                    <img src="{{ asset('images/ryl.jpg') }}" alt="Rheyle">
                    <h3>Rheyle</h3>

                </div>

                <div class="team-member">
                    <img src="{{ asset('images/dona.jpg') }}" alt="Donabella">
                    <h3>Donabella</h3>

                </div>

                <div class="team-member">
                    <img src="{{ asset('images/flexis.jpg') }}" alt="Flexis">
                    <h3>Flexis</h3>

                </div>

                <div class="team-member">
                    <img src="{{ asset('images/marsha.jpg') }}" alt="Marsha">
                    <h3>Marsha</h3>

                </div>

                <div class="team-member">
                    <img src="{{ asset('images/zen.jpg') }}" alt="Zenaida">
                    <h3>Zenaida</h3>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2025 Team Belandres. All rights reserved.</p>
    </div>

</body>
</html>
