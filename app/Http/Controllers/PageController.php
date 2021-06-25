<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware("UserAccess");
    }

    public function todo()
    {
        return view('todolist');
    }
}
