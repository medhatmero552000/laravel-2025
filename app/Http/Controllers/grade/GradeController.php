<?php

namespace App\Http\Controllers\grade;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\gradeTranslations;
use Database\Seeders\GradeTranslationSeeder;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH="admin.Grade."; 
    public function index()
    {
        $grades = Grade::paginate(10);
        return view(self::PATH.'index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view(self::PATH.'create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
{
    // dd($request);
    $data = $request->validated();
    // dd($data);
    Grade::create([
        'ar' => [
            'name' => $data['name_ar'],
            'notes' => $data['notes_ar'],
        ],
        'en' => [
            'name' => $data['name_en'],
            'notes' => $data['notes_en'],
        ]
    ]);
    return to_route(self::PATH.'index')->with('success', 'تم إضافة الصف بنجاح');
}


    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view(self::PATH.'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return view(self::PATH.'edit', get_defined_vars()); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $data=$request->validated();
        $grade->update($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return to_route(self::PATH.'index')->with('success','Message');
    }
}
