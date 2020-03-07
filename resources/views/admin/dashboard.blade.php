@extends('layouts.app')

@section('content')
<!-- Sidebar -->
<nav id="Side-Navbar" class="side-nav">
    <div class="custom-menu">
        <button type="button" id="Sidenav-Toggle" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="sidenav-wrapper">
        <a id="defaultOpen" class="tablinks Home" onclick="openMenu(event, 'Home')">
            <i class="fas fa-home" style="padding-right: 8px"></i>Home
        </a>
        <a class="tablinks Inbox" onclick="openMenu(event, 'Inbox')">
            <i class="fas fa-envelope" style="padding-right: 8px"></i>Inbox
        </a>
        <a class="tablinks Profile" onclick="openMenu(event, 'Profile')">
            <i class="fas fa-user" style="padding-right: 8px"></i>Profile
        </a>
        <a class="tablinks Notice" onclick="openMenu(event, 'Notice')">
            <i class="fas fa-file-alt" style="padding-right: 8px"></i>Notice
        </a>
        <a class="tablinks Routine" onclick="openMenu(event, 'Routine')">
            <i class="far fa-calendar-plus" style="padding-right: 8px"></i>Routine
        </a>
        <a class="tablinks Transport" onclick="openMenu(event, 'Transport')">
            <i class="fas fa-bus-alt" style="padding-right: 8px"></i>Transport
        </a>
        <a class="tablinks Invite" onclick="openMenu(event, 'Invite')">
            <i class="fas fa-users" style="padding-right: 8px"></i>Send Invitation
        </a>
        <a class="tablinks Admins" onclick="openMenu(event, 'Admins')">
            <i class="fas fa-users-cog" style="padding-right: 8px"></i>Admins
        </a>
    </div>
</nav>
<!-- /Sidebar -->

<!-- Page Content -->
<div class="text-white mb-0 p-4 p-md-5 pt-5"></div>
<!-- /Page Content -->
@endsection