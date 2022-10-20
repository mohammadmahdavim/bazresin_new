<?php

namespace App\Http\Controllers\Api\v1;

use App\AzmoonModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamsController extends Controller
{
    public function exams()
    {
    	$exams = AzmoonModel::orderby('id', 'desc')->paginate(6);
    	return response()->json([
    		'data' => $exams,
    		'status' => 'success'
    	],200);
    }


    

}
