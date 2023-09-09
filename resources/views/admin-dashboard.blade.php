<!DOCTYPE html>
<html>
<head>
    <title>File Upload with Progress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>
<nav class="navbar">
    <div class="container">
        <div class="left-part">
            <h4 class="m-0 me-4">WeTransfer</h4>
            <a href="/admin-dashboard" class="m-0 me-2">Dashboard</a>
            <a href="/upload" class="m-0">Upload</a>
        </div>
        @auth
            <div class="right-part">
                <a href="/logout" class="nav-link me-2">Log Out</a>
            </div>
        @endauth

        @guest
            <div class="right-part">
                <a href="/register" class="nav-link me-2">Register</a>
                <a href="/login" class="nav-link">Log In</a>
            </div>
        @endguest
    </div>
</nav>
<div class="upload-page d-block mt-3">
    <div class="container">
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Link</th>
                <th scope="col">Number of files</th>
                <th scope="col">Times opened</th>
                <th scope="col">Expiration date</th>
                <th scope="col">Options</th>
            </tr>
            </thead>
            <tbody>
            {{--TODO: For each--}}
            @foreach($links as $link)
                <tr>
                    <td>{{$link->slug}}</td>
                    <td>{{$link->files->count()}}</td>
                    <td>{{$link->time_opened}}</td>
                    @if($link->has_expiration)
                        <td> {{$link->expiration_date}}</td>
                    @else
                        <td>Indefinite</td>
                    @endif
                    <td>
                        <button type="button" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-primary">Copy</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
