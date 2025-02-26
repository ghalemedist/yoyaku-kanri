<?php

namespace App\Http\Controllers\Kanri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Line Lists
     */
    public function index()
    {
        return view('kanri.line.index');
    }
}
