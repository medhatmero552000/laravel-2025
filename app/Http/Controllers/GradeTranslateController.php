<?php

namespace App\Http\Controllers;

use App\Models\GradeTranslate;
use App\Http\Requests\StoreGradeTranslateRequest;
use App\Http\Requests\UpdateGradeTranslateRequest;
use App\Models\GradeTranslation;

class GradeTranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH="admin.GradeTranslate."; 
    public function index()
    {
        $gradeTranslate = GradeTranslation::paginate(10);
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
    public function store(StoreGradeTranslateRequest $request)
    {
        $data=$request->validated();    
        GradeTranslation::create($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeTranslation $gradeTranslate)
    {
        return view(self::PATH.'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeTranslation $gradeTranslate)
    {
        return view(self::PATH.'edit', get_defined_vars()); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeTranslateRequest $request, GradeTranslation $gradeTranslate)
    {
        $data=$request->validated();
        $gradeTranslate->update($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeTranslation $gradeTranslate)
    {
        $gradeTranslate->delete();
        return to_route(self::PATH.'index')->with('success','Message');
    }
}
