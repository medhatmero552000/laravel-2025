@extends('admin.master')
@section('title', __('keywords.add_new_section'))
@section('pagetitle', __('keywords.add_new_section'))

@section('content')
<button type="button" class="mb-3 btn btn-primary btn-sm" data-bs-toggle="modal"
data-bs-target="#repeaterModal">{{ __('keywords.add_new_section') }}<i data-feather="plus"></i></button>
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        @if ($grade->count() > 0)
                                            @foreach ($grade as $g)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-heading-{{ $g->id }}">
                                                        <button class="accordion-button collapsed " type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapse-{{ $g->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="flush-collapse-{{ $g->id }}">
                                                            {{ $g->name }}
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapse-{{ $g->id }}" class="accordion-collapse collapse "
                                                        aria-labelledby="flush-heading-{{ $g->id }}"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">
                                                                <table class="table text-center align-middle table-bordered table-striped">
                                                                    <thead class="">
                                                                        <tr>
                                                                            <th>{{strtoupper(__('keywords.sections'))}}</th>
                                                                            <th>{{strtoupper(__('keywords.class_name'))}}</th>
                                                                            <th>{{strtoupper(__('keywords.gradename'))}}</th>
                                                                            <th>{{strtoupper(__('keywords.actions'))}}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                       @foreach ($section as $s)
                                                                           
                                                                       <tr>
                                                                        <th scope="row">{{ $grades->firstitem() + $loop->index }}</th>
                                                                        <td>{{ $s->grsde->name }}</td>
                                                                        <td>{{ $s->classroom->classroom }}</td>
                                                                        {{-- <td>{{ $grade->notes }}</td> --}}
                                                                        <td>{{ $grade->created_at->diffForHumans() }}</td>
                                                                   
                                                                    </tr>
                                                                           
                                                                       @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else                                    
                                        <tr class="alert table-danger">
                                            <td colspan="100%" class="text-center"> <!-- رسالة عدم وجود بيانات -->
                                                {{ ucwords(__('keywords.no_data_available')) }}
                                            </td>
                                        </tr>
                                    @endif                                       
                                    </div>
                                    


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Section Modal --}}
        <div class="modal fade" id="repeaterModal" tabindex="-1" aria-labelledby="repeaterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="repeaterModalLabel">{{ __('keywords.add_new_classroom') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div id="repeater">
                            <!-- أول صف -->
                            <div class="mb-4 row align-items-center" id="row-1">
                                <div class="col-md-2">
                                    <input type="text" name="inputs[0][text]" class="form-control"
                                        placeholder="{{ __('keywords.section_name') }}">
                                </div>
                                <div class="col-md-4">
                                    <select name="inputs[0][select]" class="form-control">
                                        <option value="" disabled class="text-muted">
                                            {{ __('keywords.classroom_list') }}
                                        </option>
                                        {{-- @foreach () --}}
                                            <option value="">
                                               
                                            </option>
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="inputs[0][select]" class="form-control">
                                        <option value="" disabled class="text-muted">
                                            {{ __('keywords.grade_list') }}
                                        </option>
                                        {{-- @foreach () --}}
                                            <option value="">
                                               
                                            </option>
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-danger remove-row">{{ __('keywords.remove_row') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="button" id="add-row" class="btn btn-success">{{ __('keywords.add_row') }}</button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('keywords.close') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm">{{ __('keywords.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
