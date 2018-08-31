<?php

namespace App\Http\Controllers;

use App\Models\Moment;
use Illuminate\Http\Request;

class MomentController extends Controller
{
    //
    public function index(Request $request, Moment $moment)
    {
        $data = $moment->orderBy('created_at', 'desc')->paginate(20);
        return view('moment.index', compact('data'));
    }
}
