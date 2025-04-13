@extends('admin.master')
@section('title', __('keywords.classroom_list'))
@section('pagetitle', __('keywords.add_new_classroom'))

@section('content')
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="mb-3 btn btn-primary btn-sm" data-bs-toggle="modal" id="openModalBtn"
                                data-bs-target="#repeaterModal">{{ __('keywords.add_new_classroom') }}<i
                                    data-feather="plus"></i></button>

                            <!-- Bootstrap Form Repeater Modal -->

                            <div class="modal fade" id="repeaterModal" tabindex="-1" aria-labelledby="repeaterModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="repeaterModalLabel">
                                                {{ __('keywords.add_new_classroom') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <form action="{{ route('admin.classrooms.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div id="repeater">
                                                    <!-- First Row -->
                                                    <div class="mb-4 row align-items-center" id="row-1">
                                                        <div class="col-md-4">
                                                            <input type="text" name="inputs[0][text]"
                                                                class="form-control"
                                                                placeholder="{{ __('keywords.classroom_name') }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="inputs[0][select]" class="form-control">
                                                                <option value="" disabled class="text-muted">{{ __('keywords.gradeselect_option') }}
                                                                </option>
                                                                @foreach ($grades as $key => $grade)
                                                                    <option value="{{ $grade->id }}">{{ $grade->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div
                                                            class="col-md-4 d-flex align-items-center justify-content-center">
                                                            <button type="button"
                                                                class="btn btn-danger remove-row">{{ __('keywords.remove_row') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 text-center">
                                                    <button type="button" id="add-row"
                                                        class="btn btn-success">{{ __('keywords.add_row') }}</button>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{ __('keywords.close') }}</button>
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm">{{ __('keywords.submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- زر فتح الموديل -->
                    </div>
                </div>
            </div>
        @endsection



        {{-- For translations --}}
        @push('scripts')
            <script>
                window.keywords = {
                    remove_row: "{{ __('keywords.remove_row') }}",
                    add_row: "{{ __('keywords.add_row') }}",
                    submit: "{{ __('keywords.submit') }}",
                
                    gradeselect_option:"{{ __('keywords.gradeselect_option') }}",
                    close: "{{ __('keywords.close') }}",
                    select_option: "{{ __('keywords.select_option') }}",
                    option_1: "{{ __('keywords.option_1') }}",
                    option_2: "{{ __('keywords.option_2') }}",
                    option_3: "{{ __('keywords.option_3') }}",
                    text_input: "{{ __('keywords.text_input') }}",
                    classroom_name: "{{ __('keywords.classroom_name') }}",
                };
            </script>


{{-- For select Grade repeater --}}
<script>
    window.grades = @json($grades);
    window.gradeselect_option = "{{ __('keywords.gradeselect_option') }}";
    window.classroom_name = "{{ __('keywords.classroom_name') }}";
    window.remove_row = "{{ __('keywords.remove_row') }}";
</script>

        @endpush
