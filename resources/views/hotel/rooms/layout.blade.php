<!-- Master Layout: resources/views/hotel/rooms/layout.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Occupancy</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('css/public.css') }}"> <!-- Correct way to link assets --> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets') }}/css/material-dashboard.css" type="text/css"> --}}
    @livewireStyles
</head>

<body class="full-screen-big"
    style="background-color: black; color: white; margin: 0; height: 100vh; display: flex; align-items: top; justify-content: center;">

    <div class="full-screen-container" style="width: 100%; max-width: 100%; padding: 40px;">

        <!-- Change to occupied to display alternative tablet display -->
        {{ $slot }}

    </div>

    <!-- Optional JavaScript -->
    {{-- <script src="{{ asset('assets') }}/js/material-dashboard.min.js" type="text/javascript"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @livewireScripts
</body>

</html>
