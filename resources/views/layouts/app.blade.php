<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title','E-Invensi')</title>
        
        
        
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
        
    
    
      <link rel="stylesheet" href="{{asset('dist/assets/compiled/css/app.css')}}">
      <link rel="stylesheet" href="{{asset('dist/assets/compiled/css/app-dark.css')}}">
      <link rel="stylesheet" href="{{asset('dist/assets/compiled/css/iconly.css')}}">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
      <style>
        /* Pastikan <th> dan <td> berada di tengah */
        th, td {
            text-align: center;
            vertical-align: middle; /* Agar teks berada di tengah secara vertikal */
        }
        
        /* Aturan untuk memastikan teks tidak tertimpa aturan lain */
        table th, table td {
            text-align: center !important;
        }
    </style>
    </head>
    
    <body>
        <script src="{{asset('dist/assets/static/js/initTheme.js')}}"></script>
        <div id="app">
            <!--sidebar-->
            @include('layouts.sidebar')
            <!--sidebar-->
    
            <div id="main">
                <!--header-->   
                @include('layouts.header')
    <!--header-->
    <!--content-->
    
    <div class="page-content"> 
        @yield('content')
    </div>
    <!--content-->
    <!--footer-->
        @include('layouts.footer')
    <!--footer-->
    </body>
    
    </html>
