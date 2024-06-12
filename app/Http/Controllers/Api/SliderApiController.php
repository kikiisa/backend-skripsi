<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderApiController extends Controller
{
    public function index()
    {
        $data = Slider::all();
        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

}
