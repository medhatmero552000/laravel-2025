<?php

namespace App\Http\Controllers;

use App\Models\ClassroomTranslation;
use App\Http\Requests\StoreClassroomTranslationRequest;
use App\Http\Requests\UpdateClassroomTranslationRequest;

class ClassroomTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH="admin.ClassroomTranslation."; 
    public function index()
    {
        $classroomTranslation = ClassroomTranslation::paginate(config('pagenation.count'));
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
    public function store(StoreClassroomTranslationRequest $request)
    {
        $data=$request->validated();    
        ClassroomTranslation::create($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassroomTranslation $classroomTranslation)
    {
        return view(self::PATH.'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassroomTranslation $classroomTranslation)
    {
        return view(self::PATH.'edit', get_defined_vars()); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassroomTranslationRequest $request, ClassroomTranslation $classroomTranslation)
    {
        $data=$request->validated();
        $classroomTranslation->update($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassroomTranslation $classroomTranslation)
    {
        $classroomTranslation->delete();
        return to_route(self::PATH.'index')->with('success','Message');
    }
}
