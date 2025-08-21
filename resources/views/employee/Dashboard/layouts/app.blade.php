<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel</title>
    

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
   
    
    <link rel="stylesheet" href="{{ asset('css/FlashMessage.css') }}">
   
    
    
   

</head>
<body>

    <div class="layout">
        @include('employee.Dashboard.layouts.sidebar')

        <div class="main">
            @include('employee.Dashboard.layouts.header')

            <main class="content">
                @yield('content')
            </main>

            @include('employee.Dashboard.layouts.footer')
        </div>
    </div>

</body>
</html>