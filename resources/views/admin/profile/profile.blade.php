<!-- Profile -->
<div id="Profile" class="tabcontent">
    <div class="container-fluid">
        <div class="text-dark title h1">
            Profile
        </div>
        <hr>

        <div class="row align-items-end">
            <div class="col-4 col-md-3 col-lg-2">
                <img id="User-Photo" src="{{ asset('img/admins/' . $user->photo) }}" alt="Profile Photo" class="img-thumbnail border-primary-dark rounded-circle w-100">
            </div>
            <div class="col-8">
                <span id="User-Name" class="user-name">{{ $user->name }}</span>
                <br>
                <span class="text-muted">{{ $user->email }}</span>
				<br>
				<form id="Form-Profile-Photo" enctype="multipart/form-data">
					<input type="file" name="photo" accept="image/*" id="File-Profile-Photo" hidden>
					<button class="btn btn-sm btn-indigo ml-0 mb-0" id="Update-Profile-Photo">
						<i class="fas fa-camera mr-2"></i>
						Update Photo
					</button>
					<input type="submit" id="Submit-Profile-Photo" hidden>
				</form>
            </div>
        </div>
        <hr class="my-3">

        <form id="Form-Profile">
            <div class="form-row mb-3">
                <div class="col-3 offset-md-1 offset-lg-2">
                    Name:
                </div>
                <div class="col-9 col-md-7 col-lg-5">
                    <input type="text" name="name" id="User-Name-Form" class="form-control form-control-sm" value="{{ $user->name }}">
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-3 offset-md-1 offset-lg-2">
                    Mobile No:
                </div>
                <div class="col-9 col-md-7 col-lg-5">
                    <div class="row">
                        <div class="col-2 pr-0">
                            <input type="text" class="form-control form-control-sm text-center" value="+880" disabled>
                        </div>

                        <div class="col-1 px-0 text-center align-self-center">-</div>

                        <div class="col-9 pl-0">
                            <input type="text" name="mobile" id="User-Mobile-No-Form" class="form-control form-control-sm" value="{{ $user->mobile_no }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="col offset-md-1 offset-lg-2">
                    <button class="btn btn-sm btn-mdb-color ml-0" id="Change-Password">Change Password</button>
                </div>
            </div>
            <div id="Passwords" style="display: none">
                <div class="form-row mb-3">
                    <div class="col-3 offset-md-1 offset-lg-2">
                        Old Password:
                    </div>
                    <div class="col-9 col-md-7 col-lg-5">
                        <input type="password" name="old-pass" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-3 offset-md-1 offset-lg-2">
                        New Password:
                    </div>
                    <div class="col-9 col-md-7 col-lg-5">
                        <input type="password" name="new-pass" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-3 offset-md-1 offset-lg-2">
                        Confirm Password:
                    </div>
                    <div class="col-9 col-md-7 col-lg-5">
                        <input type="password" name="confirm-pass" class="form-control form-control-sm">
                    </div>
                </div>
			</div>
			
			<div class="form-row" id="Save-Profile" style="display: none">
				<div class="col offset-md-1 offset-lg-2">
					<button class="btn btn-indigo ml-0" type="submit">Save Changes</button>
				</div>
			</div>
        </form>
    </div>
</div>
<!-- /Profile -->

@section('script')
@parent
<script type="text/javascript" src={{ asset('js/profile.js') }}></script>
@endsection