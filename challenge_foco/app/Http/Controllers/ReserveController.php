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
     *     path="/api/reserve/status",
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

    public function createReserve(Request $request)
    {
        try {

            $request->validate([
                'hotel_id' => 'required|integer|exists:hotels,id',
                'room_id' => 'required|integer|exists:room,id',
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
                        'message' => "Failed to save reserve",
                    ],
                    500);
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "An error occurred while saving the reserve"
                ],
                500
            );
        }
    }
}
