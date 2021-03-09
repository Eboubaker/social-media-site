@extends('layouts.app')

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
        <div class="grid grid-cols-2 text-xl gap-44 pt-36 pb-36 ml-48 mr-40">
            <div class="grid grid-cols-1 w-100 h-72">
                <img src="{{ asset('img/logo.png') }}" width="350" height="250" alt="">
                <h3 class="mt-1 text-3xl">Connect with friends and expand your buisness</h3>
            </div>
            <div class="grid grid-cols-1 text-center bg-white p-5 border-2 rounded-lg shadow-2xl w-96 h-96">
                <form class="grid grid-cols-1 gap-4" action="POST">
                    <input  class="p-2 font-medium border-2 outline-none rounded-lg" type="text" name="email_phone" placeholder="Email or Phone Number">
                    <input  class="p-2 font-medium border-2 outline-none rounded-lg" type="password" name="password" placeholder="Password">
                    <button class="p-2 font-medium border-2 outline-none border-transparent rounded-lg text-white bg-logo-red hover:bg-red-500" type="submit">Log In</button>
                    <a class="text-sm" href="#">forgot Password?</a>
                </form>
                <hr>
                <input class="justify-self-center font-medium border-2 border-transparent w-64 rounded-lg text-logo-white cursor-pointer outline-none bg-logo-black hover:bg-gray-900" 
                type="button" value="Create New Account">
            </div>
        </div>
    </body>
</html>
 
