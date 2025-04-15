<style>
    .table-compact td,
    .table-compact th {
        padding: 1px 3px !important; /* تحديد الحشو داخل الخلايا */
        line-height: 1 !important; /* تحديد ارتفاع السطر */
        font-size: 12px !important; /* تحديد حجم الخط */
        vertical-align: middle !important; /* محاذاة النص عموديًا في المنتصف */
    }
</style>

@extends('admin.master')
@section('title', __('keywords.gradeList')) <!-- عنوان الصفحة -->
@section('pagetitle', __('keywords.add_new_grade')) <!-- العنوان الفرعي للصفحة -->
@section('content')

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <!-- زر إضافة صف جديد -->
                            <button type="button" class="mb-3 btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ __('keywords.add_new_grade') }}<i data-feather="plus"></i></button>

                            <!-- جدول عرض الصفوف الدراسية -->
                            <table class="table table-striped table-compact">
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
                                    @if ($grades->count() > 0) <!-- التحقق إذا كانت هناك بيانات للعرض -->
                                        @foreach ($grades as $key => $grade)
                                            <tr>
                                                <th scope="row">{{ $grades->firstitem() + $loop->index }}</th>
                                                <td>{{ $grade->name }}</td>
                                                <td>{{ $grade->notes }}</td>
                                                <td>{{ $grade->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <!-- رابط التعديل -->
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#edit{{ $grade->id }}"><i data-feather="edit"></i></a>

                                                    <!-- رابط الحذف -->
                                                    <form action="{{ route('admin.grade.destroy',['grade'=>$grade->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger"
                                                            onclick="return confirm('{{ __('keywords.confirm_delete') }}')"><i data-feather="trash-2"></i></button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- مودال التعديل -->
                                            <form action="{{ route('admin.grade.update', $grade->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" value="{{ $grade->id }}">
                                                <div class="modal fade" id="edit{{ $grade->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">تعديل الصف</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <!-- حقل تعديل اسم الصف -->
                                                                <div class="mb-3">
                                                                    <label>اسم الصف</label>
                                                                    <input type="text" name="name" class="form-control" value="{{ $grade->name }}">
                                                                </div>

                                                                <!-- حقل تعديل الملاحظات -->
                                                                <div class="mb-3">
                                                                    <label>ملاحظات</label>
                                                                    <textarea name="notes" class="form-control">{{ $grade->notes }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endforeach
                                    @else
                                        <tr class="alert table-danger">
                                            <td colspan="100%" class="text-center"> <!-- رسالة عدم وجود بيانات -->
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

        <!-- روابط التصفح -->
        {{ $grades->links('pagination::bootstrap-5') }}

        <!-- مودال إضافة صف جديد -->
        <form action="{{ route('admin.grade.store') }}" method="POST">
            @csrf
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('keywords.add_new_grade') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>
                        <div class="modal-body">
                            <!-- حقل اسم الصف -->
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('keywords.gradename') }}</label>
                                <input type="text" class="form-control" name="name">
                            </div>

                            <!-- حقل الملاحظات -->
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('keywords.notes') }}</label>
                                <textarea class="form-control" name="notes"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ __('keywords.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- عرض الأخطاء إذا كانت موجودة -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endsection
