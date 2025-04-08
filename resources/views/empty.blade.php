@extends('admin.master')
@section('title', __('keywords.gradeList'))


@section('content')
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        @section('pagetitle', __('keywords.addgrade'))
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
