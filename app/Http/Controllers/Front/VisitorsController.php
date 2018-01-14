<?php

namespace App\Http\Controllers\Front;

use App\Festival;
use App\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitorsController extends Controller
{
    public function store(Request $request, Festival $festival)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        $visitor = Visitor::create($data);
        $visitor->festivals()->attach($festival->id);

        $request->session()->flash('message', 'You have successfully applied for the festival.');

        return redirect()->back();
    }
}
