<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function status()
    {
        return response()->json(
        [
            'hotels' => "OK",
            'message' => "API is running!"


        ],
        200
    );
    }

    public function hotels()
    {
        $hotels = Hotel::paginate(10);
        return response()->json(
            [
                'status' => "OK",
                'message' => "sucess",
                'data' => $hotels


            ],
            200
        );
    }
}
