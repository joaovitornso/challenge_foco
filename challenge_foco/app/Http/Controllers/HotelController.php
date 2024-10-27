<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;


/**
 * @OA\Schema(
 *     schema="Hotel",
 *     type="object",
 *     description="Hotel model",
 *     @OA\Property(property="id", type="integer", description="Hotel ID"),
 *     @OA\Property(property="name", type="string", description="Hotel's name"),
 * )
 */

class HotelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/status",
     *     tags={"Status"},
     *     summary="Display API status",
     *     description="Get the current status of the API",
     *     @OA\Response(
     *         response=200,
     *         description="API is running"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/hotels",
     *     tags={"Hotels"},
     *     summary="Get a list of hotels",
     *     description="Retrieve all hotels with pagination",
     *     @OA\Response(
     *         response=200,
     *         description="List of hotels"
     *     )
     * )
     */
    public function hotels()
    {
        $hotels = Hotel::paginate(10);
        return response()->json(
            [
                'status' => "OK",
                'message' => "success",
                'data' => $hotels
            ],
         200
        );
    }

    /**
     * @OA\Get(
     *     path="/api/hotel-by-id/{id}",
     *     tags={"Hotels"},
     *     summary="Get hotel by ID, GET Method",
     *     description="Retrieve a hotel by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Hotel ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel not found"
     *     )
     * )
     */
    public function hotelById(Request $request)
    {
        $hotel = Hotel::find($request->id);
        return response()->json(
            [
                'status' => "OK",
                'message' => "success",
                'data' => $hotel
            ],
            200
        );
    }

    /**
     * @OA\Post(
     *     path="/api/hotel",
     *     tags={"Hotels"},
     *     summary="Get hotel by ID, POST method",
     *     description="Retrieve a hotel record using the hotel ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Hotel ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel found",
     *
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel not found",
     *
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *
     *     )
     * )
     */
    public function hotel(Request $request)
    {
        try {
            $hotel = Hotel::find($request->id);
            if ($hotel) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "success",
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

    /**
     * @OA\Post(
     *     path="/api/create-hotel",
     *     tags={"Hotels"},
     *     summary="Create a new hotel",
     *     description="Create a hotel record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Hotel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="error", type="string", example="Bad request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Server error message")
     *         )
     *     )
     * )
     */
    public function createHotel(Request $request)
    {
        try {
            $hotel = new Hotel();
            $hotel->name = $request->name;
            $hotel->save();

            return response()->json(
                [
                    'status' => "OK",
                    'message' => "success",
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

    public function updateHotel(Request $request)
    {
        try {
            $hotel = Hotel::find($request->id);
            $hotel->name = $request->name;
            $request->save();
            if ($hotel) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "success",
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

}


