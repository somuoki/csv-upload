<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>

</head>
<body>
@yield('content')
@yield('orders')

<script>
    var $ = window.$; // use the global jQuery instance


    $(window).on('hashchange',function(){
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else{
                getData(page);
            }
        }
    });
    $(document).ready(function(){
        $(document).on('click','.pagination a',function(event){
            event.preventDefault();
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            var url = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];
            getData(page);
        });
    });
    function getData(page) {
        // body...
        $.ajax({
            url : '?page=' + page,
            type : 'get',
            datatype : 'html',
        }).done(function(data){
            $('#orders').empty().html(data);
            location.hash = page;
        }).fail(function(jqXHR,ajaxOptions,thrownError){
            alert('No response from server');
        });
    }

    var $fileUpload = $('#resumable-browse');
    var $fileUploadDrop = $('#resumable-drop');
    var $uploadList = $("#file-upload-list");
    var $progress = $("#progress");

    if ($fileUpload.length > 0 && $fileUploadDrop.length > 0) {
        var resumable = new Resumable({
            // Use chunk size that is smaller than your maximum limit due a resumable issue
            // https://github.com/23/resumable.js/issues/51
            chunkSize: 8 * 1024 * 1024, // 1MB
            simultaneousUploads: 3,
            testChunks: false,
            throttleProgressCallbacks: 1,
            // Get the url from data-url tag
            target: $fileUpload.data('url'),
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // Append token to the request - required for web routes
            // query:{_token : $('input[name=_token]').val('1')}
        });

        // Resumable.js isn't supported, fall back on a different method
        if (!resumable.support) {
            $('#resumable-error').show();
        } else {
            // Show a place for dropping/selecting files
            $fileUploadDrop.show();
            resumable.assignDrop($fileUpload[0]);
            resumable.assignBrowse($fileUploadDrop[0]);

            // Handle file add event
            resumable.on('fileAdded', function (file) {
                // Show progress pabr
                $uploadList.show();
                $progress.show();
                // Show pause, hide resume
                $('.resumable-progress .progress-resume-link').hide();
                $('.resumable-progress .progress-pause-link').show();
                // Add the file to the list
                $uploadList.append('<p class="text-gray-500 text-xs mt-4 resumable-file-' + file.uniqueIdentifier + '">Uploading <span class="resumable-file-name"></span> <span class="resumable-file-progress"></span>');
                $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-name').html(file.fileName);
                // Actually start the upload
                resumable.upload();
            });
            resumable.on('fileSuccess', function (file, message) {
                // Reflect that the file upload has completed
                $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html('(completed)');
                location.reload(true);
            });
            resumable.on('fileError', function (file, message) {
                // Reflect that the file upload has resulted in error
                $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html('(file could not be uploaded: ' + message + ')');
            });
            resumable.on('fileProgress', function (file) {
                // Handle progress for both the file and the overall upload
                $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(Math.floor(file.progress() * 100) + '%');
                $('.progress-bar').css({width: Math.floor(resumable.progress() * 100) + '%'});
                if (Math.floor(resumable.progress() * 100) >= 95){
                    $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(Math.floor(file.progress() * 100) + '%' + ' Sending To Database may take a while');
                }
            });
        }

    }



</script>

</body>
</html>
