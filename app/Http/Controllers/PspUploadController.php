<?php

namespace App\Http\Controllers;

class PspUploadController extends Controller
{
    public function showForm()
    {
        return view('uploader.upload');
    }
}
