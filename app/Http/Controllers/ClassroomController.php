<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Models\Grade;
// use Illuminate\Console\View\Components\Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\ProgressBar;

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
            // ✅ الترتيب قبل الـ paginate
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
        try {
            $data = $request->validated(); // التحقق من البيانات المرسلة

            // تأكد من أن البيانات غير فارغة قبل التحديث
            if (empty($data)) {
                return redirect()->back()->with('error', 'لا توجد بيانات للتحديث.');
            }

            // التحديث في قاعدة البيانات
            $classroom->update($data);

            // عرض رسالة النجاح
            Alert::toast('تم التعديل بنجاح', 'success')->position('top-start')->autoClose(3000)->timerProgressBar(3000);

            // إعادة التوجيه بعد التعديل
            return redirect()->route('admin.classrooms.index');
        } catch (\Exception $e) {
            Alert::toast('  خطأ لم يتم التعديل ', 'error')->autoClose(3000)->timerProgressBar(3000);
            // في حالة حدوث خطأ، سيتم إدخال الخطأ هنا
            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
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
    public function filter(Request $request)
    {
        $currentLanguage = app()->getLocale(); // الحصول على لغة التطبيق

        // الحصول على القيمة من الـ select
        $grade_id = $request->input('grade_id');

        // تصفية الدرجات بناءً على اللغة الحالية
        $grades = Grade::withTranslation()
            ->whereHas('translations', function ($query) use ($currentLanguage) {
                $query->where('locale', $currentLanguage); // تصفية الترجمة بناءً على اللغة
            })
            ->get();

        // تصفية الصفوف الدراسية بناءً على grade_id إذا تم تحديده
        $classrooms = Classroom::where(function ($query) use ($grade_id) {
            if ($grade_id) {
                $query->where('grade_id', $grade_id);
            }
        })
            ->withTranslation() // لضمان تحميل الترجمة للصفوف الدراسية
            ->latest()
            ->paginate(config('pagination.count')); // استخدم paginate بدلاً من get()

        // إرجاع العرض مع البيانات
        return view(self::PATH . 'index', compact('grades', 'classrooms', 'currentLanguage'));
    }
}
