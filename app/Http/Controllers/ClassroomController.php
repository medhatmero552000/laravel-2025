<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Models\Grade;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH = "admin.Classroom.";
    public function index()
    {
        $classrooms = Classroom::all();
        $grades = Grade::all();
        $classroom = Classroom::paginate(config('pagenation.count'));
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
        $data = $request->all();
        dd($data);

        // $data=$request->validated();  is this?no  
        // Classroom::create($data);
        // return to_route(self::PATH.'index')->with('success','Message');
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
        $data = $request->validated();
        $classroom->update($data);
        return to_route(self::PATH . 'index')->with('success', 'Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return to_route(self::PATH . 'index')->with('success', 'Message');
    }
}
