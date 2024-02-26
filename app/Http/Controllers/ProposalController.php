<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showStep1()
    {
        return view('proposals.step1');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeStep1(Request $request)
    {
        // Validate and store step 1 data in session
        // $request->validate([...]);
        session(['step1_data' => $request->all()]);
        
        // Redirect to step 2
        return redirect()->route('form.step2');
    }

    public function showStep2()
    {
        return view('proposals.step2');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
