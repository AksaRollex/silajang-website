<?php

namespace App\Http\Controllers;

use App\Models\JenisParameter;
use Illuminate\Http\Request;

class JenisParameterController extends Controller
{
    public function get()
    {
        return response()->json([
            'status' => 'success',
            'data' => JenisParameter::get()
        ]);
    }
}
