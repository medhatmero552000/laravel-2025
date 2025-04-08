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
                                data-bs-target="#exampleModal">{{ __('keywords.add_new_grade') }}</button>

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ ucwords(__('keywords.gradeName')) }}</th>
                                        <th scope="col">{{ ucwords(__('keywords.notes')) }}</th>
                                        <th scope="col">{{ ucwords(__('keywords.created_at')) }}</th>
                                        <th scope="col">{{ ucwords(__('keywords.actions')) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($grades->count() > 0)
                                        @foreach ($grades as $key => $grade)
                                            <tr>
                                                <th scope="row">{{ $grades->firstitem() + $loop->index }}</th>
                                                <td>{{ $grade->name }}</td>
                                                <td>{{ $grade->notes }}</td>
                                                <td>{{ $grade->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit{{ $grade->id }}"
                                                        class="btn btn-warning btn-sm">{{ __('keywords.edit') }}</a>
                                                    <form action="#" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('{{ __('keywords.confirm_delete') }}')">{{ __('keywords.delete') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            {{-- /* ----------------------------- Edit grades modal ----------------------------- */ --}}
                                            <form action="{{ route('admin.grade.edit,') }}" method="POST">
                                                @csrf
                                                <div class="modal fade" id="edit{{ $grade->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    {{ __('keywords.add_new_grade') }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="col-form-label">{{ __('keywords.gradename_ar') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        name="name" value="{{ $grade->name }}">


                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="col-form-label">{{ __('keywords.notes_ar') }}</label>
                                                                    <textarea class="form-control" name="notes">{{ $grade->notes }}</textarea>


                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('keywords.save') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
            @csrf
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('keywords.addnewgrade') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('keywords.gradename_ar') }}</label>
                                <input type="text" class="form-control" name="name">
                                {{-- 
                                <label class="col-form-label">{{ __('keywords.gradename_en') }}</label>
                                <input type="text" class="form-control" name="name_en"> --}}
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('keywords.notes_ar') }}</label>
                                <textarea class="form-control" name="notes"></textarea>

                                {{-- <label class="col-form-label">{{ __('keywords.notes_en') }}</label>
                                <textarea class="form-control" name="notes_en"></textarea> --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ __('keywords.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>




    @endsection
