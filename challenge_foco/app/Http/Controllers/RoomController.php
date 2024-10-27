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

    /**
     * @OA\Get(
     *     path="/api/room-by-id/{id}",
     *     tags={"Room"},
     *     summary="Get room by ID, GET Method",
     *     description="Retrieve a room by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Room ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="Room ID"),
     *             @OA\Property(property="name", type="string", description="Room's name"),
     *             @OA\Property(property="hotel_id", type="integer", description="Hotel ID associated with the room")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function roomById(Request $request)
    {
        try{
            $room = Room::find($request->id);
            if($room){
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Room found successfully",
                        'data' => $room
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Room not found",
                    ],
                    400
                );
            }
        } catch(\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Something went wrong while trying to retrieve the room"
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/room",
     *     tags={"Rooms"},
     *     summary="Get room by ID, POST method",
     *     description="Retrieve a room record using the room ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Room ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="hotel_id",
     *         in="query",
     *         description="Hotel ID to which the room belongs",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room found",
     *
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found",
     *
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *
     *     )
     * )
     */
    public function room(Request $request) #POST
    {
        try {
            $room = Room::find($request->id);
            if ($room) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "success",
                        'data' => $room
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Room ID is required",
                    ],
                    400
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    "message" => "An unexpected error occurred while retrieving the room"
                ],
                500
            );
        }
    }



}
