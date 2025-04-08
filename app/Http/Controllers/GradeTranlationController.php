<?php

namespace App\Http\Controllers;

use App\Models\GradeTranlation;
use App\Http\Requests\StoreGradeTranlationRequest;
use App\Http\Requests\UpdateGradeTranlationRequest;

class GradeTranlationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const PATH="admin.GradeTranlation."; 
    public function index()
    {
        $gradeTranlation = GradeTranlation::paginate(config('pagenation.count'));
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
    public function store(StoreGradeTranlationRequest $request)
    {
        $data=$request->validated();    
        GradeTranlation::create($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeTranlation $gradeTranlation)
    {
        return view(self::PATH.'show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeTranlation $gradeTranlation)
    {
        return view(self::PATH.'edit', get_defined_vars()); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeTranlationRequest $request, GradeTranlation $gradeTranlation)
    {
        $data=$request->validated();
        $gradeTranlation->update($data);
        return to_route(self::PATH.'index')->with('success','Message');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeTranlation $gradeTranlation)
    {
        $gradeTranlation->delete();
        return to_route(self::PATH.'index')->with('success','Message');
    }
}
