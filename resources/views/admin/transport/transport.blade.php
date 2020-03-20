<!-- Transport -->
<div id="Transport" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Transport
        </div>
        <hr>

        <ul class="nav nav-tabs" id="Transport-Tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="schedule-tab" data-toggle="tab" href="#Schedules" role="tab" aria-controls="Schedules" aria-selected="false" onclick="setTimeout(function() {schedulesTable.columns.adjust().draw();}, 150);">Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="routes-tab" data-toggle="tab" href="#Routes" role="tab" aria-controls="Routes" aria-selected="true" onclick="setTimeout(function() {routesTable.columns.adjust().draw();}, 150);">Routes</a>
            </li>
        </ul>

        <div class="tab-content text-dark" id="Transport-Tab-Content">
            <div class="tab-pane fade" id="Schedules" role="tabpanel" aria-labelledby="schedule-tab">
                @include('admin.transport.schedule')
            </div>
            <div class="tab-pane fade show active" id="Routes" role="tabpanel" aria-labelledby="routes-tab">
                @include('admin.transport.routes')
            </div>
        </div>
    </div>
</div>
<!-- /Transport -->
