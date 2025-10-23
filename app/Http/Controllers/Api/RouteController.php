<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index() : View
    {
        //get all products
        $Route = Route::latest()->paginate(10);

        //render view with products
        return view('route.index', compact('route'));
    }
}
