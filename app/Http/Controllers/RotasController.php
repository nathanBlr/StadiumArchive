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

    // Search for stadiums that match the query across multiple fields
    $stadiums = Stadium::query()
        ->where(function ($query) use ($request) {
            $search = $request->input('query');
            $query->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('full_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('address', 'LIKE', '%' . $search . '%')
                  ->orWhere('city', 'LIKE', '%' . $search . '%')
                  ->orWhere('state', 'LIKE', '%' . $search . '%')
                  ->orWhere('country', 'LIKE', '%' . $search . '%')
                  ->orWhere('tenants', 'LIKE', '%' . $search . '%');
        })
        ->orWhereHas('sport', function ($query) use ($request) {
            $search = $request->input('query');
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->get();

    // Return the results to a view
    return view('stadiums.search-results', compact('stadiums'));
}


    public function details($id)
    {   
        $stadium = Stadium::where('id',$id)->first();

        return view('stadiums.stadium', compact('stadium'));
    }
}
