<?php

namespace App\Http\Controllers;

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
}
