<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>File Upload with Progress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

<div class="upload-page">
    <div class="inside">
        <form class="upload-form" action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
            <label class="upload-label" for="file">
                <img class="upload-icon" src="{{asset('icons/up.svg')}}" alt="Upload">
                <p class="upload-text">Attach files here</p>
            </label>

            @csrf
            <input type="file" name="file" id="file" multiple>
            <div class="button-row">
                <button class="button-default" type="submit">Upload</button>
            </div>
        </form>
    </div>
</div>

<div id="progress" style="display: none;">
    <div id="bar" style="width: 0%; background-color: green;">0%</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('form').submit(function (event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);
        $('#progress').show();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        var percent = Math.round((e.loaded / e.total) * 100);
                        $('#bar').css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            success: function (data) {
                // Handle the success response
            },
            error: function (data) {
                // Handle the error response
            },
            complete: function () {
                $('#progress').hide();
                $('#bar').css('width', '0%').text('0%');
            }
        });
    });
</script>
</body>
</html>
