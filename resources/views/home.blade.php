<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Metro Guide </title>

    <!-- JQuery -->
    <script type="text/javascript" src={{ asset('jQuery-3.3.1/jquery-3.3.1.min.js') }}></script>

    <!-- Pubnub Script -->
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.27.3.js"></script>

    <!-- Data Table Script -->
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <!-- Data Table Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mdb.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <!-- Tiny MCE Editor -->
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tiny_mce.key') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700">

    <!-- fontawesome icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <div id="app" class="bg-home">
        <div class="container px-2" id="App-Content">
            <div class="card">
                <div class="card-body info-color rounded p-1">
                    <div class="row m-0 app-content">
                        <div class="col-md-5 text-white text-center p-4">
                            <p class="app-header mb-0">
                                Welcome to
                            </p>
                            <p class="app-name">
                                `Metro Guide`
                            </p>
                            <img src="{{asset('img/Robot.png')}}" alt="Robot Waving" class="w-35 ml-3">
                            <p>
                                Wising you very best for your journy to
                                <br>
                                <strong>Metropolitan University.</strong>
                            </p>
                        </div>
                        <div class="col-md-7 mdb-color p-4 ">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item mdb-color">
                                    <a href="" class="text-info">
                                        <i class="fas fa-angle-double-right text-info mr-4"></i>
                                        Check Important Notices
                                    </a>
                                </li>
                                <li class="list-group-item mdb-color">
                                    <a href="" class="text-info">
                                        <i class="fas fa-angle-double-right text-info mr-4"></i>
                                        Check Class Routine
                                    </a>
                                </li>
                                <li class="list-group-item mdb-color">
                                    <a href="" class="text-info">
                                        <i class="fas fa-angle-double-right text-info mr-4"></i>
                                        Check Bus Schedule
                                    </a>
                                </li>
                                <li class="list-group-item mdb-color">
                                    <a href="" class="text-info">
                                        <i class="fas fa-angle-double-right text-info mr-4"></i>
                                        Track Bus
                                    </a>
                                </li>
                                <li class="list-group-item mdb-color">
                                    <a href="" class="text-info" data-toggle="modal" data-target="#Modal-Message-Form">
                                        <i class="fas fa-angle-double-right text-info mr-4"></i>
                                        Send message to admin
                                    </a>
                                </li>
                            </ul>
                            <p class="text-warning">
                                <br>
                                Porta ac consectetur ac Porta ac consectetur ac
                            </p>
                            <div class="alert alert-success" id="Message-Success" style="display: none;">
                                <span id="Message-Success-Data"></span>
                            </div>
                            <div class="alert alert-danger" id="Message-Failed" style="display: none;">
                                <span id="Message-Failed-Data"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Form Modal -->
    <div class="modal fade" id="Modal-Message-Form" tabindex="-1" role="dialog" aria-labelledby="Modal-Message-Label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h4 class="modal-title w-100 font-weight-bold" style="font-family: serif">Send Message</h4>
                    <button type="button" id="Btn-Close-Message-Form" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <form id="Form-Message" method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body mx-3 pb-0">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="name">Name*:</label>
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" required autocomplete="name">
                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-7">
                                <label for="email">Email*:</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" required autocomplete="email">
                                @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="message">Message*:</label>
                                <textarea id="message" type="text" class="message-box form-control" name="message" autocomplete="false">
                                </textarea>
                                @error('message')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end p-1">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Message Form Modal -->

    <!-- Adjust Top Position of App-Content -->
    <script>
        function adjustMainTop() {
            var appHight = $('#App-Content').height();
            var windowHeight = $(window).innerHeight();
            if(windowHeight > appHight) {
                var top = (windowHeight - appHight) / 2;
                $("#App-Content").css("padding-top", Math.max(top-30, 30));
                $("#App-Content").css("padding-bottom", top);
            } else {
                $("#App-Content").css("padding-top", 20);
                $("#App-Content").css("padding-bottom", 20);
            }
        };
        adjustMainTop();
        $(window).resize(function() {
            adjustMainTop();
        });
    </script>

    <!-- Initialize Tiny Editor -->
    <script>
        tinymce.init({
            selector: '#message',
            skin: 'oxide-dark',
            content_css: "{{ url('css/style.css') }}",
            extended_valid_elements: 'blockquote[class=blockquote]',
            plugins: 'lists',
            toolbar: 'undo redo | bold italic underline | fontsizeselect | alignleft aligncenter alignright alignjustify | blockquote | bullist numlist | subscript superscript | forecolor backcolor | outdent indent | removeformat',
            menubar: false,
            force_br_newlines : true,
            force_p_newlines : false,
            forced_root_block : 'div',
            min_height: 250,
            max_height: 250,
        });
    </script>

    <!-- Store Message -->
    <script>
        $("#Form-Message").on("submit", function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            $('#message').html( tinymce.get('message').getContent() );
            $.ajax({
                type: "POST",
                url: "/store/message",
                data: $("#Form-Message").serialize(),
                success: function (response) {
                    $("#Form-Message").trigger("reset");
                    $("#Btn-Close-Message-Form").click();

                    $("#Message-Success-Data").html(response.msg);
                    $("#Message-Success").fadeIn("slow");
                    setTimeout(function() {
                        $("#Message-Success").fadeOut("slow");
                    }, 10000);
                },
                error: function(xhr) {
                    $("#Form-Message").trigger("reset");
                    $("#Btn-Close-Message-Form").click();

                    if(xhr.status == 422) {
                        var error = xhr.responseJSON.message + "<br><ul>";
                        $.each(xhr.responseJSON.errors, function(key, item) {
                            error = error + "<li>" + item + "</li>";
                        });
                        error = error + "</ul>";
                        $("#Message-Failed-Data").html(error);
                    } else {
                        $("#Message-Failed-Data").html("Something went wrong!<br>Please try again after some time.");
                    }
                    $("#Message-Failed").fadeIn("slow");
                    setTimeout(function() {
                        $("#Message-Failed").fadeOut("slow");
                    }, 10000);
                }
            });
        });
    </script>

</body>
</html>