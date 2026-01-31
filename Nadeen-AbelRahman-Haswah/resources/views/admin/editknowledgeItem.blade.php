@extends('admin.layout.master')

@section('title', 'Edit knowledge Item')

@section('content')

    <div class="page-inner">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group form-group-default">
                        <label>Title</label>
                        <input id="addName" type="text" class="form-control" placeholder="fill Title" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group form-group-default">
                        <label>Category</label>
                        <input id="addName" type="text" class="form-control" placeholder="fill Category" />
                    </div>
                </div>

                <div class="col-md-12 pe-0">
                    <div class="form-group form-group-default">
                        <label>Content</label>
                        <input id="addPosition" type="text" class="form-control" placeholder="fill Content " />
                    </div>
                </div>
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Department</label>
                        <input id="addPosition" type="text" class="form-control" placeholder="fill Department " />
                    </div>
                </div>
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Created By</label>
                        <input id="addPosition" type="text" class="form-control" placeholder="fill Created By " />
                    </div>
                </div>
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Status</label>
                        <input id="addPosition" type="text" class="form-control" placeholder="fill Status " />
                    </div>
                </div>
                <div class="col-md-6 pe-0">
                    <div class="form-group form-group-default">
                        <label>Visibility</label>
                        <input id="addPosition" type="text" class="form-control" placeholder="fill CVisibility" />
                    </div>
                </div>

            </div>

            <div>
                <button type="button" id="addRowButton" class="btn btn-primary">
                    Edit
                </button>
                <a href="{{ route('admin.knowledgeItems') }}">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                </button>
                </a>
            </div>
        </form>
    </div>
@endsection
