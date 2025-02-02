<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntryController extends Controller
{
    //

    public function store(Request $request) {
        $data = $request->all();

        return response()->json($data, 200);
    }
}
