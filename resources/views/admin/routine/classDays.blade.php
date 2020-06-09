<div id="ClassDays" style="display: none;">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="lead">Class Days</div>
        </div>
        <div class="card-body">
            <form id="Form-Set-Days">
                @foreach($classDays as $classDay)
                <div class="form-row mb-2">
                    <div class="col">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Day-{{ $classDay->id }}" name="class-days[]" value="{{ $classDay->day }}" {{ $classDay->is_open === 1 ? "checked" : "" }}>
                            <label class="custom-control-label" for="Day-{{ $classDay->id }}">{{ $classDay->day }}</label>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="form-row">
                    <div class="col">
                        <input type="submit" name="submit" id="Form-Set-Days-Submit" class="btn btn-sm btn-success d-none" value="Save Changes">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
