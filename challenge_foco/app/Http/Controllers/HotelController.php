<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

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
        try{
            return response()->json(
                [
                    'hotels' => "OK",
                    'message' => "API is up and running!"
                ],
                200
            );
        } catch (\Exception $error) {
            return response()-> json(
                [
                    "error" => $error->getMessage(),
                    "message" => "Error checking API status"
                ],
                404
            );
        }
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
        try{
            $hotels = Hotel::paginate(10);
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "success",
                    'data' => $hotels
                ],
             200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Error retrieving hotels data"
                ],
                404
            );
        }

    }
    public function hotels1()
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
    public function hotelById(Request $request) #POST
    {
        try{
            $hotel = Hotel::find($request->id);
            if($hotel){
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
                        'message' => "Hotel not found",
                    ],
                    400
                );
            }
        } catch(\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Something went wrong while trying to retrieve the hotel"
                ],
                500
            );
        }
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
    public function hotel(Request $request) #POST
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
                    400
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    "message" => "An unexpected error occurred while retrieving the hotel"
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
            $hotel_saved = $hotel->save();

            if($hotel_saved){
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Hotel created successfully",
                        'data' => $hotel
                    ],
                    200);
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Failed to save hotel",
                    ],
                    500);
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "An error occurred while saving the hotel"
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/update-hotel",
     *     tags={"Hotels"},
     *     summary="Update a hotel",
     *     description="Update a hotel record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel Updated",
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
    public function updateHotel(Request $request)
    {
        try {
            $hotel = Hotel::find($request->id);

            if (!$hotel) {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Hotel not found",
                    ],
                    400
                );
            }

            $hotel->name = $request->name;
            $request->save();
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "Hotel updated successfully",
                    'data' => $hotel
                ],
                200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error updating hotel information"
                ],
                500
            );
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/delete-hotel",
     *     tags={"Hotels"},
     *     summary="Delete a hotel",
     *     description="Delete a hotel record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel Deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="message", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Hotel ID not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Server error")
     *         )
     *     )
     * )
    */
    public function deleteHotel(Request $request)
    {
        try {
            $hotel = Hotel::find($request->id);

            if(!$hotel){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Hotel not found'
                    ],
                    400
                );
            }

            $hotel->delete();
            return response()->json(
                [
                    'status' => 'OK',
                    'message' => 'Hotel deleted successfully'
                ],
                200
            );

        } catch(\Exception $error){
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error deleting hotel"

                ],
                500
            );
        }
    }



}


