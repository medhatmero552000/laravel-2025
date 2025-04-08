<?php

namespace App\Http\Controllers;

use App\Models\GradeTranslation;
use App\Http\Requests\StoreGradeTranslationRequest;
use App\Http\Requests\UpdateGradeTranslationRequest;

class GradeTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH="admin.GradeTranslation."; 
    public function index()
    {
        $gradeTranslation = GradeTranslation::paginate(config('pagenation.count'));
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
    public function store(StoreGradeTranslationRequest $request)
    {
        $data=$request->validated();    
        GradeTranslation::create($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeTranslation $gradeTranslation)
    {
        return view(self::PATH.'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeTranslation $gradeTranslation)
    {
        return view(self::PATH.'edit', get_defined_vars()); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeTranslationRequest $request, GradeTranslation $gradeTranslation)
    {
        $data=$request->validated();
        $gradeTranslation->update($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeTranslation $gradeTranslation)
    {
        $gradeTranslation->delete();
        return to_route(self::PATH.'index')->with('success','Message');
    }
}
