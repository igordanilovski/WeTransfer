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
</body>

@if($accessible)

    <div class="download-page">
        <div class="inside">
            <div class="files-box visible mb-4" id="files-box">
                @foreach($result->files as $file)
                    <p class="file-box-name">{{ $file["originalName"] }}</p>
                @endforeach
            </div>
            <div class="button-row visible">
                <button class="button-default" type="submit" id="download_button">
                    <img class="icon me-2" src="{{asset('icons/download.svg')}}" alt="Download">
                    <p class="m-0">Download</p>
                </button>
            </div>
        </div>
    </div>

    <a id="download-link" style="display: none;"></a>

@endif

{{--TODO: Da se stavi error ako linkot ne e accessible--}}
<div class="box-container">
    <div class="broken-link-box">
        <img class="mb-2" src="{{asset('icons/info.svg')}}" alt="">
        <p class="broken-link-text m-0">Sorry, this link is not valid or expired.</p>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#download_button").click(function () {
            var downloadLink = document.getElementById("download-link");
            downloadLink.href = "http://127.0.0.1:8000/download/{{$slug}}"; // Replace with the actual download link
            downloadLink.click();
        });
    });
</script>

</html>
