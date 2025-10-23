<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() : View
    {
        //get all products
        $Schedule = Schedule::latest()->paginate(10);

        //render view with products
        return view('schedule.index', compact('schedule'));
    }
}
