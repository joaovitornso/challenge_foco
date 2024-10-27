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

    public function hotelById(Request $request)
    {
        $hotel = Hotel::find($request->id);
        return response()->json(
            [
                'status' => "OK",
                'message' => "sucess",
                'data' => $hotel
            ],
            200
        );

    }

    public function hotel(Request $request)
    {
        try {
            $hotel = Hotel::find($request->id);
            if ($hotel) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "sucess",
                        'data' => $hotel
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Hotel ID is required",
                    ],
                    404
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }

    public function createHotel(Request $request)
    {
        try {
            $hotel = new Hotel();
            $hotel->name = $request->name;
            $hotel->save();

            return response()->json(
                [
                    'status' => "OK",
                    'message' => "sucess",
                    'data' => $hotel
                ],
                200);

        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage()
                ],
                400);
        }
    }

}


