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

<div class="upload-page">
    <div class="inside">
        <form id="upload-form" class="upload-form visible" action="{{ route('upload') }}" method="post"
              enctype="multipart/form-data">
            <label class="upload-label mb-3" for="files">
                <img class="upload-icon" src="{{asset('icons/up.svg')}}" alt="Upload">
                <p class="upload-text ms-2 mb-0">Attach files here</p>
            </label>

            @csrf
            <input type="file" name="files[]" id="files" multiple class="d-none">

            <div class="files-box mb-4" id="files-box">


            </div>

            @if($authenticated)
                <div id="expiration-element" class="expiration-element mb-3">
                    <div class="inside">
                        <label class="expiration-label" for="expiration-datetime">Set Expiration Date</label>
                        <input id="expiration-datetime" name="expiration-datetime" class="expiration-datetime"
                               type="datetime-local">
                    </div>
                </div>
            @endif

            <div class="button-row">
                <button class="button-default" type="submit">Upload</button>
            </div>
            <div id="progress" class="mt-3 progress-bar" style="display: none;">
                <div id="bar" style="width: 0%; background-color: #27c499;">0%</div>
            </div>
        </form>

        <div class="send-box" id="send-box">
            <img class="send-icon mb-3" src="{{asset('icons/send.svg')}}" alt="Send">
            <h4 class="send-text-heading">Share uploaded files with anyone</h4>
            <p class="send-text">
                Great news! Your uploaded files are ready and waiting for you. You can now easily share them with anyone
                by simply clicking on the provided link. Whether it's documents, images, or any other files, they're all
                set for sharing. Get started and collaborate effortlessly!</p>
            <input type="text" id="share-link-input" class="send-input-field mb-3" value="" disabled>
            <div class="button-row">
                <button id="share-link-button" class="button-default" data-link="test" type="button"
                        onclick="copyToClipboard(this)">Copy to clipboard
                </button>
            </div>
        </div>
    </div>
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
                document.getElementById("upload-form").classList.remove("visible");
                document.getElementById("send-box").classList.add("visible");
                document.getElementById("share-link-input").value = data.message.link;
                document.getElementById("share-link-button").setAttribute("data-link", data.message.link);
            },
            error: function (data) {
                alert("Error while uploading files");
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
        $(".expiration-element").addClass("visible");

        Array.from(files).forEach(file => {
            appendFileBox(file.name, file.size);
        });
    }

    function copyToClipboard(button) {
        // Get the data-link attribute value from the button
        var dataLink = button.getAttribute("data-link");

        // Create a temporary input element to copy the value to the clipboard
        var tempInput = document.createElement("input");
        tempInput.setAttribute("value", dataLink);
        document.body.appendChild(tempInput);

        // Select the text inside the input field
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Copy the selected text to the clipboard using the Clipboard API
        document.execCommand("copy");

        // Remove the temporary input element
        document.body.removeChild(tempInput);

        // Provide user feedback (you can customize this part)
        alert("Copied to clipboard: " + dataLink);
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
