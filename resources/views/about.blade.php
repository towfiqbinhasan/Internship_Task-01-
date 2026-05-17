@extends('layouts.app')
@section('script')
<script>


    alert('This is the about page');
</script>




@section ('styles')


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
@endsection
@section('styles')





<div class="main-container">



    <main class="content">


    </main>

</div>


























































{{--
<html>

<body>


    <h1>About us</h1>
    <h2>Name:{{$name}}</h2>

    @include('SubViews.Input',[
    'Myname' => '$name'
    ])

    <h2>Email:{{$email}}</h2>


    @for ($i= 0; $i<10;$i++) <p>{{ $i }}</p>


        @if ($i==5)
        <h1>hi hi {{ $i }}</h1>
        @endif
        @endfor

</body>

</html>
--}}