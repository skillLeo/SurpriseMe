<?php

namespace App\Http\Controllers;

class ShareController extends Controller
{
    public function index()
    {
        if (!session('submission_id')) {
            return redirect()->route('form');
        }
        return view('share');
    }
}