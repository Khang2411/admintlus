<?php

namespace App\Http\Controllers;

use App\Models\cv;
use Illuminate\Http\Request;

class CvController extends Controller
{
    function list()
    {
        $cvs=cv::paginate(1);
        return view('admin.cv.index',compact("cvs"));
    }
}
