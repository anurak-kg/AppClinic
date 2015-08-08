@extends('layout.master')
@section('title','ข้อมูลคอร์ส')

@section('content')

<html>
<head>
    <meta charset="utf-8">
    <title>jQuery File Upload Example</title>
</head>
<body>

<script src="/dist/js/dropzone.js"></script>

<link href="/dist/js/dropzone.css" rel="stylesheet" type="text/css"/>


<div class="container">



    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading with-border">

            </div>
            <div class="panel-body">
                <div class="dropzone" id="dropzoneFileUpload"></div>

                <button id="clear-dropzone">Clear Dropzone</button>
            </div>

        </div>
    </div>


</div>


<script type="text/javascript">
    var baseUrl = "{{ url('customer/upload') }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneFileUpload", {
        url: baseUrl,
        params: {
            _token: token
        }
    });
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        maxFiles: 5,
        accept: function(file, done) {

        },
        init: function() {
            this.on("sending", function(file) {
                alert('Sending the file' +  file.name)
            });

            // Using a closure.
            var _this = this;

            // Setup the observer for the button.
            document.querySelector("button#clear-dropzone").addEventObserver("click", function() {
                // Using "_this" here, because "this" doesn't point to the dropzone anymore
                _this.removeAllFiles();
                // If you want to cancel uploads as well, you
                // could also call _this.removeAllFiles(true);
            });
        }
    };

</script>

</body>
</html>

    @stop