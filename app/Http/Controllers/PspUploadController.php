<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PspUploadController extends Controller
{
    public function showForm()
    {
        return view('uploader.upload');
    }
}
