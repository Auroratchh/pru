<?php

namespace App\Http\Controllers;


use App\Mail\SendPasswordMail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }

    public function index( Request $request){

        return view('admin.index');
    }




}
