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
     * @OA\Post(
     *     path="/create-reserve",
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
}
