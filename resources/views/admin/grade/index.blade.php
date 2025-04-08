@extends('admin.master')
@section('title', __('keywords.gradeList'))
@section('pagetitle', __('keywords.addgrade'))
@section('content')
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ __('keywords.addnewgrade') }}</button>

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ ucwords(__('keywords.gradename')) }}</th>
                                        <th scope="col">{{ ucwords(__('keywords.notes')) }}</th>
                                        <th scope="col">{{ ucwords(__('keywords.actions')) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($grades->count() > 0)
                                    @foreach ($grades as $key => $grade)
                                        <tr>
                                            <th scope="row">{{ $grade->id + $loop->index }}</th>
                                            <td>{{ $grade->name }}</td>
                                            <td>{{ $grade->notes }}</td>
                                            <td></td> <!-- Remove this if not needed -->
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="alert table-danger">
                                        <td colspan="4" class="text-center"> <!-- Update the colspan value -->
                                            {{ ucwords(__('keywords.no_data_available')) }}
                                        </td>
                                    </tr>
                                @endif
                                
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $grades->links('pagination::bootstrap-5') }}


        {{-- /* ----------------------------- Add new grades modal ----------------------------- */ --}}
        <form action="{{ route('admin.grade.store') }}" method="POST">
            {{-- <form action="{{ isset($grade) ? route('grades.update', $grade) : route('grades.store') }}" method="POST"> --}}
            @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">{{__('keywords.gradename')}}</label>
                                <input type="text" class="form-control" id="recipient-name" name="'name_ar'">
                                <input type="text" class="form-control" id="recipient-name" name="'name_en'">
                                {{-- <input type="text" class="form-control" id="recipient-name" name="ar['name']"> --}}
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">{{__('keywords.notes')}}</label>
                                {{-- /* ----------------------------- Add new grades modal ----------------------------- */ --}}
                                <textarea class="form-control" id="message-text" name="'notes_ar'"></textarea>
                                <textarea class="form-control" id="message-text" name="'notes_en'"></textarea>
                                {{-- <textarea class="form-control" id="message-text" name="ar['notes']"></textarea> --}}
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-primary">Send message</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    @endsection
