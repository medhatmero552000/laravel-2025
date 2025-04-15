<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use RealRashid\SweetAlert\Facades\Alert;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH = "admin.grade.";
    public function index()
    {
        // الحصول على اللغة الحالية
        $currentLanguage = app()->getLocale();

        // جلب السجلات مع الترجمة بناءً على اللغة الحالية
        $grades = Grade::whereHas('translations', function ($query) use ($currentLanguage) {
            $query->where('locale', $currentLanguage); // تحقق من وجود الترجمة بناءً على اللغة الحالية
        })
            ->withTranslation() // تحميل الترجمة لجميع اللغات المدعومة
            ->paginate(config('pagination.count'));

        return view(self::PATH . 'index', compact('grades'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH . 'create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        try {
            $data = $request->validated();
    
            // التحقق مما إذا كانت المرحلة موجودة مسبقًا في قاعدة البيانات
            $exists = Grade::whereTranslation('name', $data['name'])->exists();

            
            if ($exists) {
                // إرسال رسالة الخطأ عبر التوست
                Alert::toast('المرحلة موجودة مسبقًا', 'error');
                return to_route('admin.grades.index');
            } else {
                // إضافة البيانات إلى قاعدة البيانات
                Grade::create([
                    'name' => $data['name'],
                    'notes' => $data['notes']
                ]);
    
                // إرسال رسالة النجاح عبر التوست
                Alert::toast('تمت إضافة المرحلة بنجاح', 'success');
                return to_route('admin.grades.index');
            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            // إرسال رسالة الخطأ في حالة حدوث مشكلة
            Alert::toast('حدث خطأ أثناء إضافة المرحلة', 'error');
            return to_route('admin.grades.index');
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view(self::PATH . 'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return view(self::PATH . 'edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.UpdateGradeRequest
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
{
    try {
        $data = $request->validated();

        // $grade = Grade::findOrFail($data['id']);

        $grade->update([
            'name' => $data['name'],
            'notes' => $data['notes'],
        ]);
        Alert::toast('    تم تعديل المرحلة بنجاح', 'success');

        return redirect()->route('admin.grades.index')->with('success', 'تم تحديث الصف بنجاح.');
    } catch (\Throwable $e) {
        Alert::toast('حدث خطأ أثناء تعديل المرحلة', 'error');

        return back()->withErrors(['error' => 'حدث خطأ أثناء التحديث']);
    }
}


    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        // تحقق من وجود فصول مرتبطة
        if ($grade->grade_calssroom()->exists()) {
            Alert::toast('لا يمكن حذف المرحلة نظرًا لوجود صفوف تابعة', 'error');
            return to_route('admin.grades.index');
        }
    
        try {
            // حذف الصف المرتبط بالمرحلة
            $grade->forceDelete();
    
            // تنبيه النجاح
            Alert::toast('تم حذف المرحلة بنجاح', 'success');
            return to_route('admin.grades.index');
        } catch (\Throwable $th) {
            // في حال حدوث خطأ
            Alert::toast('حدث خطأ أثناء الحذف، الرجاء المحاولة لاحقًا.', 'error');
            return to_route('admin.grades.index');
        }
    }
}
