<!-- resources/views/upload.blade.php -->
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

<div class="upload-page">
    <div class="inside">
        <form class="upload-form" action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
            <label class="upload-label mb-3" for="files">
                <img class="upload-icon" src="{{asset('icons/up.svg')}}" alt="Upload">
                <p class="upload-text ms-2 mb-0">Attach files here</p>
            </label>

            @csrf
            <input type="file" name="files[]" id="files" multiple class="d-none">

            <div class="files-box mb-4" id="files-box">

            </div>

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

    var elem = document.getElementById('files');
    elem.addEventListener('change', getFileData);

    function getFileData() {
        const files = this.files;
        var parentElement = document.getElementById("files-box");
        removeAllChildElements(parentElement);

        $(".button-row").addClass("visible");
        $(".files-box").addClass("visible");

        Array.from(files).forEach(file => {
            appendFileBox(file.name, file.size);
        });
    }

    function removeAllChildElements(parentElement) {
        while (parentElement.firstChild) {
            parentElement.removeChild(parentElement.firstChild);
        }
    }

    function appendFileBox(fileName, fileSize) {
        // Create a new div element
        var fileBoxDiv = document.createElement("div");
        fileBoxDiv.setAttribute("class", "file-box");

        // Create a new paragraph element for the file name
        var fileBoxNameP = document.createElement("p");
        fileBoxNameP.setAttribute("class", "file-box-name");
        fileBoxNameP.textContent = fileName;

        // Create a new paragraph element for the file size
        var fileBoxSizeP = document.createElement("p");
        fileBoxSizeP.setAttribute("class", "file-box-size");
        fileBoxSizeP.textContent = parseInt(fileSize / 1000) + " KB";

        // Append the paragraph elements to the div element
        fileBoxDiv.appendChild(fileBoxNameP);
        fileBoxDiv.appendChild(fileBoxSizeP);

        // Get the parent element where you want to append the code
        var parentElement = document.getElementById("files-box");

        // Append the new div element to the parent element
        parentElement.appendChild(fileBoxDiv);
    }
</script>
</body>
</html>
