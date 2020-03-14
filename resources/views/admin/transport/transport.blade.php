<!-- Transport -->
<div id="Transport" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Transport
        </div>
        <hr>

        <ul class="nav nav-tabs" id="Transport-Tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="schedule-tab" data-toggle="tab" href="#Schedules" role="tab" aria-controls="Schedules" aria-selected="true">Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="routes-tab" data-toggle="tab" href="#Routes" role="tab" aria-controls="Routes" aria-selected="false">Routes</a>
            </li>
        </ul>

        <div class="tab-content text-dark" id="Transport-Tab-Content">
            <div class="tab-pane fade show active" id="Schedules" role="tabpanel" aria-labelledby="schedule-tab">
                @include('admin.transport.schedule')
            </div>
            <div class="tab-pane fade" id="Routes" role="tabpanel" aria-labelledby="routes-tab">
                @include('admin.transport.routes')
            </div>
        </div>
    </div>
</div>

<!-- DataTable Script -->
<script type="text/javascript" src={{ asset('js/transport.js') }}></script>
<!-- /Transport -->
