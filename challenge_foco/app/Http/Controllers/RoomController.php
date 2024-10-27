<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Room",
 *     type="object",
 *     description="Room model",
 *     @OA\Property(property="id", type="integer", description="Room ID"),
 *     @OA\Property(property="name", type="string", description="Room's name"),
 *     @OA\Property(property="hotel_id", type="integer", description="ID of the associated hotel"),
 * )
 */
class RoomController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/room/status",
     *     tags={"Status"},
     *     summary="Display API status room",
     *     description="Get the current status room of the API",
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
                    'status' => "OK",
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
     *     path="/api/rooms",
     *     tags={"Rooms"},
     *     summary="Get a list of rooms",
     *     description="Retrieve all rooms with pagination",
     *     @OA\Response(
     *         response=200,
     *         description="List of rooms"
     *     )
     * )
     */
    public function rooms()
    {

        try{
            $rooms = Room::paginate(10);
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "success",
                    'data' => $rooms
                ],
             200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Error retrieving rooms data"
                ],
                404
            );
        }
    }


}
