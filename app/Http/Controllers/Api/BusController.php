<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index() : View
    {
        //get all products
        $Bus = Bus::latest()->paginate(10);

        //render view with products
        return view('bus.index', compact('bus'));
    }
}
