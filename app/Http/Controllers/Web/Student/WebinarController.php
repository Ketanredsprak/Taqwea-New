<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        $params['currentPage'] = 'myWebinars';
        $params['classType'] = 'webinar';
        $params['title'] = trans("labels.my_webinars");
        return view('frontend.student.class.index', $params);
    }

}
