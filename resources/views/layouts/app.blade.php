<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Website Template</title>
    <style>
      
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

      
        .navbar {
            background-color: #0056b3;
           
            padding: 15px 0;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            display: inline;
            margin: 0 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

       
        .main-container {
            display: flex;
            flex: 1;
        }

      
        .sidebar {
            width: 20%;
            background-color: #f4f4f9;
           
            padding: 20px;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar ul {
            list-style: disc;
            padding-left: 20px;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            color: blue;
            text-decoration: underline;
        }

       
        .content {
            width: 80%;
            padding: 40px;
        }

        .content h1 {
            background-color: #4a90e2;
           
            color: white;
            display: inline-block;
            padding: 5px 15px;
            margin-bottom: 20px;
        }

        .content p {
            background-color: #4a90e2;
        
            color: white;
            display: inline-block;
            padding: 5px 10px;
        }

       
        .footer {
            background-color: #004080;
           
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>

    @yield('styles')
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <div class="main-container">

        <aside class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="#">Link 1</a></li>
                <li><a href="#">Link 2</a></li>
                <li><a href="#">Link 3</a></li>
            </ul>
        </aside>

        <main class="content">
            @yield('content')

        </main>

    </div>

    <footer class="footer">
        <p>&copy; 2025 My Website. All rights reserved.</p>
    </footer>

</body>

@yield('script')

</html>