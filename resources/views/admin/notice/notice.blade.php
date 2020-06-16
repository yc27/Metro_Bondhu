<!-- Notice -->
<div id="Notice" class="tabcontent">
    <div class="container-fluid">
        <div class="text-dark title h1">
            Notice Board
        </div>
        <hr>

        <div class="grid row">
            <div class="grid-item col-12 col-sm-6 col-md-4 col-lg-3" id="Create-Notice">
                <div class="card text-white unique-color mb-3 create-notice" data-toggle="modal" data-target="#Modal-Notice-Form">
                    <div class="card-body">
                        <i class="fas fa-plus-circle mr-2"></i>
                        <br>
                        <span>Create Notice</span>
                    </div>
                </div>
            </div>
            @foreach($notices as $notice)
            <div class="grid-item col-12 col-sm-6 col-md-4 col-lg-3" id="Notice-Id-{{ $notice->id }}">
                <div class="card text-white mb-3 view overlay {{ $notice->color }}">
                    <div class="card-header">
                        <h5 class="card-title mb-0 font-weight-bold">{{ $notice->title }}</h5>
                        <small>{{ \Carbon\Carbon::parse($notice->date)->format('F d, Y') }}</small>
                    </div>

                    <div class="card-body">
                        {{ $notice->getNotice() }}
                    </div>

                    <div class="mask flex-center rgba-black-strong">
                        <button class="btn btn-sm btn-indigo edit-notice" data-id="{{ $notice->id }}" data-toggle="modal" data-target="#Modal-Notice-Form">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </button>

                        <button class="btn btn-sm btn-danger delete-notice" data-id="{{ $notice->id }}" data-toggle="modal" data-target="#Modal-Notice-Delete">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Notice Form Modal -->
<div class="modal fade" id="Modal-Notice-Form" tabindex="-1" role="dialog" aria-labelledby="Modal-Notice-Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header primary-color-dark text-white">
                <h4 id="Modal-Notice-Title" class="modal-title w-100 text-center">Create Notice</h4>
            </div>
            <form id="Form-Notice" enctype="multipart/form-data">
                <div class="modal-body mx-3 pb-0">
                    <div class="alert alert-danger d-none" id="Form-Notice-Error">
                        <ul id="Form-Notice-Error-Message"></ul>
                    </div>

                    <input type="hidden" name="id" id="Notice-Id">
                    <div class="form-row">
                        <div class="col-12 col-sm-5 mb-4">
                            <label class="mb-0">Notice Color :</label>
                            <select id="Notice-Color" class="browser-default custom-select" style="height: calc(1.5em + .5rem + 2px); padding: .25rem .5rem; font-size: .875rem; line-height: 1.5; border-radius: .2rem;" name="color">
                                <option value="bg-primary" class="bg-primary">Blue</option>
                                <option value="bg-info" class="bg-info">Sky Blue</option>
                                <option value="bg-secondary" class="bg-secondary">Purple</option>
                                <option value="bg-success" class="bg-success">Green</option>
                                <option value="bg-warning" class="bg-warning">Yellow</option>
                                <option value="bg-danger" class="bg-danger">Red</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-7 mb-4">
                            <label class="mb-0">Date : <small class="text-muted">(mm-dd-yyyy)</small></label>
                            <input type="date" name="date" id="Notice-Date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12 col-md-5 mb-4">
                            <label class="mb-0">
                                Notice Topic :
                                <small class="text-muted">(max: 10)</small>
                            </label>
                            <input type="text" name="topic" id="Notice-Topic" class="form-control form-control-sm">
                        </div>

                        <div class="col-12 col-md-7 mb-4">
                            <label class="mb-0">
                                Notice Title :
                                <small class="text-muted">(max: 30)</small>
                            </label>
                            <input type="text" name="title" id="Notice-Title" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="mb-0">Notice Body :</label>
                        <textarea name="body" id="Notice-Body"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-end py-1 px-2">
                    <button class="btn btn-primary" type="submit" style="padding: 0.6rem 0.9rem">
                        <i class="fas fa-save mr-2"></i>
                        Save
                    </button>

                    <button class="btn btn-danger" id="Btn-Form-Notice-Close" data-dismiss="modal" style="padding: 0.6rem 0.9rem">
                        <i class="fas fa-times-circle mr-2"></i>
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Notice Form Modal -->

<!-- Notice Delete Modal -->
<div id="Modal-Notice-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Notice-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Notice-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this notice?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Notice" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Notice Delete Modal -->
<!-- /Notice -->

@section('script')
@parent
<script src="{{ asset('js/notice.js') }}"></script>
@endsection
