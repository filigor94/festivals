<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Festival;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFestivalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.festivals.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.festivals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'daterange' => 'required',
            'image' => 'required|image|mimes:jpeg,png,bmp,gif',
            'description' => 'nullable'
        ]);

        $address = $request->validate([
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required',
            'map_lat' => 'required',
            'map_lng' => 'required'
        ]);

        $dates = explode('-', $data['daterange']);
        $data['start_date'] = Carbon::createFromFormat('m/d/Y H:i A', trim($dates[0]))->toDateTimeString();
        $data['end_date'] = Carbon::createFromFormat('m/d/Y H:i A', trim($dates[1]))->toDateTimeString();

        unset($data['daterange']);
        $data = array_filter($data);

        $festival = Festival::create($data);
        $festival->address()->create($address);

        $image_name = $festival->id . '.' . $request->file('image')->getClientOriginalExtension();

        $request->file('image')->storeAs('public/festivals', $image_name);

        $festival->update([
            'image' => $image_name
        ]);

        $request->session()->flash('message', 'The festival has been successfully created.');

        return redirect()->route('festivals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
