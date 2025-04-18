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
                            <div class="d-flex justify-content-start align-items-center">
                                <!-- زر إضافة صف جديد -->
                                <button type="button" class="mb-0 btn btn-primary btn-sm" data-bs-toggle="modal"
                                    id="openModalBtn" data-bs-target="#repeaterModal">
                                    {{ __('keywords.add_new_classroom') }} <i data-feather="plus"></i>
                                </button>

                                <!-- فاصل بين الأزرار -->
                                <div class="mx-2"></div>

                                {{-- نموذج الحذف لجميع الصفوف المحددة --}}
                                <form id="deleteSelectedForm" class="d-inline"
                                    action="{{ route('admin.classrooms.deleteAll') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" id="selectedIds" name="selectedIds">

                                    <!-- زر حذف الصفوف المحددة -->
                                    <button type="submit" id="deleteAll" class="mb-0 btn btn-danger" disabled
                                        onclick="return confirm('{{ __('keywords.confirm_delete') }}')">
                                        حذف المحدد <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- فورم عرض المراحل الدراسية --}}
                       
                        <form method="GET" action="{{ route('admin.classrooms.filter') }}" >
                            <div class="mb-3 col-3">
                                <label for="grade_id">{{ __('keywords.gradename') }}</label>
                                <select name="grade_id" id="grade_id" class="form-select" onchange="this.form.submit()">
                                    <option value="" disabled selected>{{ __('keywords.grade_choose') }}</option> <!-- خيار افتراضي -->
                                    <option value="">{{ __('keywords.showall_greads') }}</option> <!-- خيار افتراضي -->
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}" 
                                            {{ request('grade_id') == (string)$grade->id ? 'selected' : '' }}>
                                            {{-- عرض الترجمة الخاصة باللغة الحالية فقط --}}
                                            {{ $grade->translate(app()->getLocale())->name ?? $grade->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                   
                        {{-- جدول لعرض البيانات --}}
                        <table class="table table-striped table-compact">

                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" class="row-checkbox form-check-input"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ ucwords(__('keywords.classroom')) }}</th>
                                    <th scope="col">{{ ucwords(__('keywords.gradeName')) }}</th>
                                    <th scope="col">{{ ucwords(__('keywords.created_at')) }}</th>
                                    <th scope="col">{{ ucwords(__('keywords.actions')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($classrooms->count() > 0)
                                    @foreach ($classrooms as $classroom)
                                        <tr>
                                            <td><input type="checkbox" name="ids[]" value="{{ $classroom->id }}"
                                                    class="row-checkbox"></td>
                                            <th scope="row">{{ $classrooms->firstItem() + $loop->index }}</th>
                                            <td>{{ $classroom->classroom }}</td>

                                            <!-- عرض اسم الصف الدراسي إذا كان موجوداً، وإذا لم يكن موجوداً يتم عرض 'No grade assigned' -->
                                            <td>{{ $classroom->classroom_grade ? $classroom->classroom_grade->name : 'No grade assigned' }}</td>

                                            <td>{{ $classroom->created_at->diffForHumans() }}</td>

                                            <td>
                                                {{-- زر التعديل (يفتح مودال خاص بـ classroom) --}}
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#editClassroom{{ $classroom->id }}">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                {{-- فورم الحذف (يتم إرسال الطلب لحذف الفصل) --}}
                                                <form action="{{ route('admin.classrooms.destroy', $classroom->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger"
                                                        onclick="return confirm('{{ __('keywords.confirm_delete') }}')">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        {{-- مودال تعديل الفصل --}}
                                        <div class="modal fade" id="editClassroom{{ $classroom->id }}" tabindex="-1"
                                            aria-labelledby="editClassroomLabel{{ $classroom->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.classrooms.update', $classroom->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id" value="{{ $classroom->id }}">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editClassroomLabel{{ $classroom->id }}">تعديل الفصل</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label>اسم الفصل</label>
                                                                <input type="text" name="classroom" class="form-control"
                                                                    value="{{ $classroom->classroom }}" id="classroomName{{ $classroom->id }}" required autofocus>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label>الصف الدراسي</label>
                                                                <select name="grade_id" class="form-control">
                                                                    @foreach ($grades as $grade)
                                                                        <option value="{{ $grade->id }}"
                                                                            {{ $classroom->grade_id == $grade->id ? 'selected' : '' }}>
                                                                            {{ $grade->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr class="alert table-danger">
                                        <td colspan="100%" class="text-center">
                                            {{ ucwords(__('keywords.no_data_available')) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- مودال إضافة صف جديد -->
                        <div class="modal fade" id="repeaterModal" tabindex="-1" aria-labelledby="repeaterModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="repeaterModalLabel">{{ __('keywords.add_new_classroom') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('admin.classrooms.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div id="repeater">
                                                <!-- أول صف -->
                                                <div class="mb-4 row align-items-center" id="row-1">
                                                    <div class="col-md-4">
                                                        <input type="text" name="inputs[0][text]" class="form-control"
                                                            placeholder="{{ __('keywords.classroom_name') }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="inputs[0][select]" class="form-control">
                                                            <option value="" disabled class="text-muted">
                                                                {{ __('keywords.gradeselect_option') }}
                                                            </option>
                                                            @foreach ($grades as $key => $grade)
                                                                <option value="{{ $grade->id }}">
                                                                    {{ $grade->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
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

                    </div>
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
                gradeselect_option: "{{ __('keywords.gradeselect_option') }}",
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
