<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use Illuminate\Http\Request;

class RotasController extends Controller
{
    public function index(){
        $stadium = Stadium::get()->last();
        return view('stadiums.index',['stadium'=> $stadium]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search for stadiums that match the query
        $stadiums = Stadium::where('name', 'LIKE', '%' . $query . '%')->get();

        // Return the results to a view
        return view('stadiums.search-results', compact('stadiums'));
    }
}
