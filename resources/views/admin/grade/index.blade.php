<style>
   .table-compact td,
    .table-compact th {
        padding: 1px 3px !important;
        line-height: 1 !important;
        font-size: 12px !important;
        vertical-align: middle !important;
    }



</style>

@extends('admin.master')
@section('title', __('keywords.gradeList'))
@section('pagetitle', __('keywords.add_new_grade'))
@section('content')
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="mb-3 btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">{{ __('keywords.add_new_grade') }}<i data-feather="plus"></i></button>
                                
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
                                    @if ($grades->count() > 0)
                                        @foreach ($grades as $key => $grade)
                                            <tr>
                                                <th scope="row">{{ $grades->firstitem() + $loop->index }}</th>
                                                <td>{{ $grade->name }}</td>
                                                <td>{{ $grade->notes }}</td>
                                                <td>{{ $grade->created_at->diffForHumans() }}</td>
                                                <td class="">
                                                    {{-- Edit Link --}}
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#edit{{ $grade->id }}"
                                                        ><i data-feather="edit"></i></a>
                                                        {{-- Show link --}}
                                                    {{-- <a href="#" data-bs-toggle="modal"
                                                        data-bs-target=""
                                                        ><i data-feather="eye" class=" text-success"></i></a> --}}
                                                        {{-- Delete Link --}}
                                                    <form action="{{ route('admin.grade.destroy',['grade'=>$grade->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger"
                                                            onclick="return confirm('{{ __('keywords.confirm_delete') }}')"><i data-feather="trash-2"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            {{-- /* ----------------------------- Edit grades modal ----------------------------- */ --}}
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
                                                                <div class="mb-3">
                                                                    <label>اسم الصف</label>
                                                                    <input type="text" name="name" class="form-control" value="{{ $grade->name }}">
                                                                </div>
                                            
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
                                            <td colspan="100%" class="text-center"> <!-- Update the colspan value -->
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
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('keywords.add_new_grade') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('keywords.gradename') }}</label>
                                <input type="text" class="form-control" name="name">
                                {{--
                                <label class="col-form-label">{{ __('keywords.gradename_en') }}</label>
                                <input type="text" class="form-control" name="name_en"> --}}
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">{{ __('keywords.notes') }}</label>
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
        {{-- @if(session('toast'))
        <script>
            Swal.fire({
                icon: '{{ session('toast')['type'] }}', // تحديد نوع الأيقونة (success, error, etc.)
                title: '{{ session('toast')['message'] }}', // النص المعروض
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 10000, // مدة عرض الإشعار
                background: '#90C67C', // تخصيص الخلفية
                color: '#fff !important', // تخصيص لون النص
                customClass: {
                    icon: 'custom-icon', // تخصيص الأيقونة
                    title: '' // تخصيص النص
                }
            });
            
        </script>
        
        @endif --}}
        
        
    
 
    
    
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
