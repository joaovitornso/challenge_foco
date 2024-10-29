<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Reserve",
 *     type="object",
 *     description="Reserve model",
 *     @OA\Property(property="id", type="integer", description="Reserve ID"),
 *     @OA\Property(property="hotel_id", type="integer", description="ID of the associated hotel"),
 *     @OA\Property(property="room_id", type="integer", description="ID of the associated room"),
 *     @OA\Property(property="check_in", type="string", format="date", description="Check-in date in YYYY-MM-DD format"),
 *     @OA\Property(property="check_out", type="string", format="date", description="Check-out date in YYYY-MM-DD format"),
 *     @OA\Property(property="total", type="number", format="float", description="Total cost of the reservation"),
 * )
 */
class ReserveController extends Controller
{

    /**
     * @OA\Get(
     *     path="/reserve/status",
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
     *     path="/api/reserves",
     *     tags={"Reserves"},
     *     summary="Get a list of reserves",
     *     description="Retrieve all reserves with pagination",
     *     @OA\Response(
     *         response=200,
     *         description="List of reserves"
     *     )
     * )
     */
    public function reserves()
    {
        try{
            $reserves = Reserve::paginate(10);
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "success",
                    'data' => $reserves
                ],
             200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Error retrieving reserves data"
                ],
                404
            );
        }

    }

    /**
     * @OA\Post(
     *     path="/api/reserve",
     *     tags={"Reserves"},
     *     summary="Get reserve by ID, POST method",
     *     description="Retrieve a reserve record using the reserve ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Reserve ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="hotel_id",
     *         in="query",
     *         description="Hotel ID to which the reserve belongs",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="room_id",
     *         in="query",
     *         description="Room ID to which the reserve belongs",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserve found",
     *
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reserve not found",
     *
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *
     *     )
     * )
     */
    public function reserve(Request $request) #POST
    {
        try {
            $reserve = Reserve::find($request->id);
            if ($reserve) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "success",
                        'data' => $reserve
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Reserve ID is required",
                    ],
                    400
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    "message" => "An unexpected error occurred while retrieving the reserve"
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/create-reserve",
     *     tags={"Reserves"},
     *     summary="Create a new reserve",
     *     description="Create a reserve record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"hotel_id", "room_id", "check_in", "check_out", "total"},
     *             @OA\Property(property="hotel_id", type="integer", description="ID of associated hotel"),
     *             @OA\Property(property="room_id", type="integer", description="ID of associated room"),
     *             @OA\Property(property="check_in", type="string", format="date", description="Check-in date in YYYY-MM-DD format"),
     *             @OA\Property(property="check_out", type="string", format="date", description="Check-out date in YYYY-MM-DD format"),
     *             @OA\Property(property="total", type="number", format="float", description="Total cost of the reservation"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserve created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Reserve created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Reserve")
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
    public function createReserve(Request $request)
    {
        try {

            $request->validate([
                'hotel_id' => 'required|integer|exists:hotels,id',
                'room_id' => 'required|integer|exists:rooms,id',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after:check_in',
                'total' => 'required|numeric|min:0',
            ]);

            $reserve = new Reserve();
            $reserve->hotel_id = $request->hotel_id;
            $reserve->room_id = $request->room_id;
            $reserve->check_in = $request->check_in;
            $reserve->check_out = $request->check_out;
            $reserve->total = $request->total;


            $reserve_saved = $reserve->save();

            if($reserve_saved){
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Reserve created successfully",
                        'data' => $reserve
                    ],
                    200);
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Failed to save reserve"
                    ],
                    500);
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'trace' => $error->getTraceAsString(),
                    'message' => "An error occurred while saving the reserve"
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/update-reserve",
     *     tags={"Reserves"},
     *     summary="Update a reserve",
     *     description="Update a reserve record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", description="ID of the reserve to update"),
     *             @OA\Property(property="hotel_id", type="integer", description="ID of associated hotel"),
     *             @OA\Property(property="room_id", type="integer", description="ID of associated room"),
     *             @OA\Property(property="check_in", type="string", format="date", description="Check-in date in YYYY-MM-DD format"),
     *             @OA\Property(property="check_out", type="string", format="date", description="Check-out date in YYYY-MM-DD format"),
     *             @OA\Property(property="total", type="number", format="float", description="Total cost of the reservation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reserve updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Reserve updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Reserve")
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
    public function updateReserve(Request $request)
    {
        try {
            $reserve = Reserve::find($request->id);

            if (!$reserve) {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Reserve not found",
                    ],
                    400
                );
            }

            $reserve->hotel_id = $request->hotel_id ?? $reserve->hotel_id;
            $reserve->room_id = $request->room_id ?? $reserve->room_id;
            $reserve->check_in = $request->check_in ?? $reserve->check_in;
            $reserve->check_out = $request->check_out ?? $reserve->check_out;
            $reserve->total = $request->total ?? $reserve->total;
            $reserve->save();

            return response()->json(
                [
                    'status' => "OK",
                    'message' => "Reserve updated successfully",
                    'data' => $reserve
                ],
                200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error updating reserve information"
                ],
                500
            );
        }
    }

    public function deleteReserve(Request $request)
    {
        try {
            $reserve = Reserve::find($request->id);


            if(!$reserve){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Reserve not found'
                    ],
                    400
                );
            }

            $reserve->delete();
            return response()->json(
                [
                    'status' => 'OK',
                    'message' => 'Reserve deleted successfully'
                ],
                200
            );

        } catch(\Exception $error){
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error deleting reserve"

                ],
                500
            );
        }
    }


}
