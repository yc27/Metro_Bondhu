<!-- Footer -->
<footer class="page-footer font-small mdb-color darken-3 pt-4" id="Feedback">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 align-self-center">
                <h5 class="text-uppercase font-weight-bold">Send Feedback</h5>
                <p class="text-justify">
                    We would love to hear from you. For any query, suggestion, complain send as a message. Our admins will check out your feedback and if neccessary a reply will be sent to your mail address.
                </p>
            </div>

            <div class="col-12 col-md-9">
                <form id="Form-Message" method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-12 col-md-5">
                            <label for="name">Name*:</label>
                            <input id="name" type="text" class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" required autocomplete="name">
                            @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-7">
                            <label for="email">Email*:</label>
                            <input id="email" type="email" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" required autocomplete="email">
                            @error('email')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
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

                    <div class="form-row">
                        <div class="form-group col">
                            <button class="btn btn-sm btn-success ml-0" type="submit">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="footer-copyright text-center py-3">&copy;
        @php
        echo date('Y');
        @endphp
        Copyright:
        <a href="https://www.mu-guide.com"> www.mu-guide.com</a>
    </div>
</footer>
<!-- Footer -->
