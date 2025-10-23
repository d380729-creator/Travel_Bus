<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() : View
    {
        //get all products
        $Booking = Booking::latest()->paginate(10);

        //render view with products
        return view('booking.index', compact('booking'));
    }
}
