<!--Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background: transparent; box-shadow: none">
    <a class="navbar-brand pl-3" href="#">
		<img src="{{ asset('img/brand-logo.png') }}" alt="MU-Guide" style="height: 36px">
	</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar-Content" aria-controls="Navbar-Content" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
	</button>
	
    <div class="collapse navbar-collapse" id="Navbar-Content">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item px-3">
                <a class="nav-link Notices">
                    <i class="fas fa-file-alt mr-2"></i>Notice
                </a>
            </li>

            <li class="nav-item px-3">
                <a class="nav-link Routines">
                    <i class="far fa-calendar-plus mr-2"></i>Routine
                </a>
            </li>

            <li class="nav-item px-3">
                <a class="nav-link Schedules">
                    <i class="fas fa-bus-alt mr-2"></i>Bus Schedule
                </a>
            </li>

            <li class="nav-item px-3">
                <a class="nav-link Track-Buses">
                    <i class="fas fa-map-marker-alt mr-2"></i>Track Bus
                </a>
            </li>
        </ul>
    </div>
</nav>
<!--/.Navbar -->
