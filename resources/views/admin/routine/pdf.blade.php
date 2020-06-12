<!DOCTYPE html>
<html>
<head>
    <style>
        .title {
            border-collapse: collapse;
            color: #25597B;
            margin: 20px 0;
        }

        .title td {
            font-size: 20px;
            padding: 5px 0;
            padding-right: 40px;
        }

        .title td strong {
            color: #002456;
        }

        .routine-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #002456;
        }

        .routine-table tbody tr td,
        .routine-table thead tr th {
            border-left: 1px solid #002456;
            border-top: none;
            border-bottom: 1px solid #002456;
            text-align: center;
        }

        .routine-table tbody tr td:first-child,
        .routine-table thead tr th:first-child {
            border-left: none;
        }

        .routine-table thead tr th,
        .routine-table tbody tr td:first-child {
            background: #4682B4;
            color: #ffffff;
            font-weight: bold;
            font-family: sans-serif;
        }

        .routine-table thead tr th:first-child {
            background: #356c99;
        }

        .routine-table tbody tr td:first-child {
            width: 1%;
            white-space: nowrap;
        }

        .routine-table thead tr th {
            padding: 10px;
        }

        .routine-table tbody tr td {
            color: #25597B;
            padding: 10px;
        }

        .routine-table .subject {
            font-size: 16px;
            font-weight: bold;
            color: #002456;
        }

        .routine-table .teacher {
            font-size: 14px;
            font-weight: bold;
            color: #2a4fad;
        }

        .routine-table .room {
            font-size: 14px;
            font-weight: bold;
            color: #800080;
        }

    </style>
</head>
<body>
    <div style="margin: 0 20px">
        <h1 style="color: #002456">Class Routine</h1>
        <hr style="border: 1px solid #002456">
        <!-- PDF Title -->
        <table class="title">
            <tbody>
                <tr>
                    <td>Session: <strong>{{ $session->session }}</strong></td>
                    <td>Department: <strong>{{ $departmentName->short_name }}</strong></td>
                </tr>
                <tr>
                    <td>Batch: <strong>{{ $batchNo->batch_no }}</strong></td>
                    <td>Section: <strong>{{ $sectionNo->section_no }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Routine -->
        <table class="routine-table">
            <thead>
                <tr>
                    <th></th>
                    @foreach($periods as $period)
                    <th>{{ \Carbon\Carbon::parse($period->start_time)->format('h:ia') }} - {{ \Carbon\Carbon::parse($period->end_time)->format('h:ia') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($classDays as $classDay)
                <tr>
                    <td>
                        {{ $classDay->day }}
                    </td>
                    @foreach($periods as $period)
                    @php
                    $flag = false;
                    @endphp
                    @foreach($routines as $routine)
                    @if($routine->day === $classDay->id && $routine->period === $period->id)
                    <td>
                        <span class="subject">{{ $routine->subject }}</span>
                        <br>
                        by <span class="teacher">{{ $routine->teacher }}</span>
                        <br>
                        at <span class="room">{{ $routine->room }}</span>
                    </td>
                    @php
                    $flag = true;
                    @endphp
                    @endif
                    @endforeach
                    @if($flag === false)
                    <td></td>
                    @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
