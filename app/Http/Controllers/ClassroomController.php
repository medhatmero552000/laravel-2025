<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Models\Grade;
// use Illuminate\Console\View\Components\Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH = "admin.Classroom.";
    public function index()
    {
        // الحصول على اللغة الحالية
        $currentLanguage = app()->getLocale();
        $grades = Grade::all();
        // جلب السجلات مع الترجمة بناءً على اللغة الحالية
        $classrooms = Classroom::whereHas('translations', function ($query) use ($currentLanguage) {
            $query->where('locale', $currentLanguage);
        })
            ->withTranslation()
            ->latest() // ✅ الترتيب قبل الـ paginate
            ->paginate(config('pagination.count'));

        // dd($classrooms);
        return view(self::PATH . 'index', get_defined_vars());
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
    public function store(StoreClassroomRequest $request)
    {
        $data = $request->validated();

        // التحقق من وجود الصفوف في المدخلات
        if (!isset($data['inputs']) || empty($data['inputs'])) {
            return redirect()->back()->with('error', 'يجب إضافة صف واحد على الأقل.');
        }

        // التحقق من وجود `Grade` صالح
        $validGradeIds = Grade::pluck('id')->toArray();

        foreach ($data['inputs'] as $input) {
            // التحقق من الحقول المطلوبة
            if (empty($input['text']) || empty($input['select'])) {
                return redirect()->back()->with('error', 'يرجى ملء جميع الحقول بشكل صحيح.');
            }

            // التحقق من أن الصف الدراسي موجود
            if (!in_array($input['select'], $validGradeIds)) {
                return redirect()->back()->with('error', 'الصف الدراسي غير موجود.');
            }

            // إنشاء الفصل الدراسي بدون الترجمة
            $classroom = Classroom::create([
                'grade_id' => $input['select'],
            ]);

            // إضافة الترجمة للحقل `name` بناءً على اللغة الحالية
            $currentLanguage = app()->getLocale();
            $classroom->translateOrNew($currentLanguage)->classroom = $input['text'];
            $classroom->save();
        }

        // إعادة التوجيه مع رسالة النجاح
        return redirect()->route('admin.classrooms.index')->with('success', 'تم إضافة الفصول بنجاح.');
    }




    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return view(self::PATH . 'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        return view(self::PATH . 'edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassroomRequest $request, Classroom $classroom)
    {
        $data = $request->validated(); // لازم تتأكد إن البيانات مش فاضية
    
        // dd($data); // تقدر تستخدمه للتجربة
    
        $classroom->update($data);
    
        Alert::toast('تم التعديل بنجاح', 'success');
        return redirect()->route('admin.classrooms.index');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        // إذا تم الحذف بنجاح
        Alert::toast('تم حذف الصفوف بنجاح', 'success');
        return redirect()->route('admin.classrooms.index');

    }
    public function destroyAll(Request $request)
    {
        $ids = $request->input('ids'); // الحصول على الـ IDs كمصفوفة مباشرة

        try {
            if (empty($ids)) {
                // إذا كانت المصفوفة فارغة
                Alert::toast('لا توجد بيانات للحذف', 'error');
                return response()->json(['success' => false, 'message' => 'لا توجد بيانات للحذف']);
            }

            // تحقق من أن جميع القيم في الـ IDs هي أرقام صحيحة
            $ids = array_map('intval', $ids);

            // إضافة سجل للـ IDs التي سيتم حذفها (للتحقق)
            // \log()::info('Deleting Classrooms with IDs:', $ids);

            // حذف الصفوف المحددة
            $deleted = Classroom::whereIn('id', $ids)->delete();

            if ($deleted) {
                // إذا تم الحذف بنجاح
                Alert::toast('تم حذف الصفوف بنجاح', 'success');
                return response()->json(['success' => true]);
            } else {
                // إذا فشل الحذف
                Alert::toast('فشل في الحذف', 'error');
                return response()->json(['success' => false, 'message' => 'فشل في الحذف']);
            }
        } catch (\Exception $e) {
            // في حال حدوث خطأ أثناء الحذف
            Alert::toast('حدث خطأ أثناء الحذف: ' . $e->getMessage(), 'error');
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()]);
        }
    }
}
