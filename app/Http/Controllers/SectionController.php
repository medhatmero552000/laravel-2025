<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH="admin.Section."; 
    public function index()
    {
        $grade_section=Grade::with('sections')->get();
        $grade=Grade::all();
        $section = Section::paginate(config('pagenation.count'));
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
    public function store(Request $request)
    {
        $data=$request->validated();    
        Section::create($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return view(self::PATH.'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        return view(self::PATH.'edit', get_defined_vars()); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $data=$request->validated();
        $section->update($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return to_route(self::PATH.'index')->with('success','Message');
    }
}
