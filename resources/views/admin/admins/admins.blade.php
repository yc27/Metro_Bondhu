<!-- Admins -->
<div id="Admins" class="tabcontent">
    <div class="container-fluid">
        <div class="text-dark title h1">
            Admins
        </div>
		<hr>

		@foreach($admins as $admin)
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-3 col-md-2 col-lg-1 border-right">
							<img src="{{ asset('img/admins/' . $admin->photo) }}" alt="{{ $admin->name }}" class="img-thumbnail border-primary-dark rounded-circle w-100">
						</div>
						<div class="col-9 col-md-10 col-lg-11">
							<span class="user-name">{{ $admin->name }}</span>
							<br>

							<p class="my-2">
								<span>Email: {{ $admin->email }}</span>
								<br>
								<span>
									Mobile No:
									{{ $admin->mobile_no !== null ? '+88 0' . $admin->mobile_no : '' }}
								</span>
							</p>

							<span class="text-muted">
								Registerd At:
								{{ \Carbon\Carbon::parse($admin->created_at)->format('M d, Y h:ia') }}
							</span>
							<br>
							<span class="text-muted">
								Email Verified At:
								{{ $admin->email_verified_at !== null ? \Carbon\Carbon::parse($admin->email_verified_at)->format('M d, Y h:ia') : '' }}
							</span>
							
							<hr class="my-1">

							<em>
								<span class="text-muted">
									Added By:
									@if($admin->id === 1)
										Default
									@elseif($admin->inviter === null)
										Deleted Account
									@else
										{{ $admin->inviter }}
									@endif
								</span>
							</em>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
<!-- /Admins -->