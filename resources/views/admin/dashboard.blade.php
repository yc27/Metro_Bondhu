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
        <a class="tablinks Home" onclick="openMenu(event, 'Home')">
            <i class="fas fa-home mr-4"></i>Home
        </a>
        <a class="tablinks Inbox {{ $unseen_messages_count > 0 ? 'yellow-text' : 'custom-blue-1' }}" onclick="openMenu(event, 'Inbox')">
            <i class="fas fa-envelope mr-4"></i>Inbox
            <span class="badge badge-pill danger-color ml-1 align-self-start {{ $unseen_messages_count > 0 ? 'd-block' : 'd-none' }}" id="Sidebar-Unseen-Messages-Count">{{ $unseen_messages_count }}</span>
        </a>
        <a class="tablinks Profile" onclick="openMenu(event, 'Profile')">
            <i class="fas fa-user mr-4"></i>Profile
        </a>
        <a class="tablinks Notice" onclick="openMenu(event, 'Notice')">
            <i class="fas fa-file-alt mr-4"></i>Notice
        </a>
        <a id="defaultOpen" class="tablinks Routine" onclick="openMenu(event, 'Routine')">
            <i class="far fa-calendar-plus mr-4"></i>Routine
        </a>
        <a class="tablinks Transport" onclick="openMenu(event, 'Transport');setTimeout(function() {routesTable.columns.adjust().draw();}, 150);">
            <i class="fas fa-bus-alt mr-4"></i>Transport
        </a>
        <a class="tablinks Invite" onclick="openMenu(event, 'Invite')">
            <i class="fas fa-users mr-4"></i>Invitation Requests
            <span class="badge badge-pill danger-color ml-1 align-self-start d-block" id="Sidebar-Pending-Requests"></span>
        </a>
        <a class="tablinks Admins" onclick="openMenu(event, 'Admins')">
            <i class="fas fa-users-cog mr-4"></i>Admins
        </a>
    </div>
</nav>
<!-- /Sidebar -->

<!-- Page Content -->
<div id="Page-Content" class="mb-0 px-4 px-md-5 py-3">
    @include('admin.inbox.inbox')
    @include('admin.routine.setup')
    @include('admin.transport.transport')
    @include('admin.invitations.invitationRequests')
</div>
<!-- /Page Content -->

<!-- Script -->
<script type="text/javascript" src={{ asset('js/main.js') }}></script>
@endsection