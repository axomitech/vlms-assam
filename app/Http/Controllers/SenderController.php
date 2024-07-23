<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSenderRequest;
use App\Http\Requests\UpdateSenderRequest;
use App\Models\Sender;

class SenderController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSenderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sender $sender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sender $sender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSenderRequest $request, Sender $sender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sender $sender)
    {
        //
    }
}
