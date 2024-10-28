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
     *     tags={"Rooms"},
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

    /**
     * @OA\Post(
     *     path="/api/create-room",
     *     tags={"Rooms"},
     *     summary="Create a new room",
     *     description="Create a room record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="hotel_id", type="integer", description="ID of associated hotel, if any")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room created",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Room created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Room")
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
    public function createRoom(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'hotel_id' => 'required|integer|exists:hotels,id',
            ]);

            $room = new Room();
            $room->name = $request->name;
            $room->hotel_id = $request->hotel_id;
            $room_saved = $room->save();

            if($room_saved){
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Room created successfully",
                        'data' => $room
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Failed to save room",
                    ],
                    500);
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "An error occurred while saving the room"
                ],
                500
            );
        }
    }

    /**
     * @OA\Post(
     *     path="/api/update-room",
     *     tags={"Rooms"},
     *     summary="Update a room",
     *     description="Update a room record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="hotel_id", type="integer", description="Associated hotel ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room Updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="message", type="string", example="Room updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Room")
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
    public function updateRoom(Request $request)
    {
        try {
            $room = Room::find($request->id);

            if (!$room) {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Room not found",
                    ],
                    400
                );
            }

            $request->validate([
                'name' => 'string|nullable',
                'hotel_id' => 'integer|exists:hotels,id|nullable'
            ]);

            if ($request->has("name")){
                $room->name = $request->name;
            }

            if ($request->has('hotel_id')){
                $room->hotel_id = $request->hotel_id;
            }

            $room->save();
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "Room updated successfully",
                    'data' => $room
                ],
                200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error updating room information"
                ],
                500
            );
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/delete-room",
     *     tags={"Rooms"},
     *     summary="Delete a room",
     *     description="Delete a room record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room Deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="message", type="string", example="Room deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Room ID not found")
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
    public function deleteRoom(Request $request)
    {
        try {
            $room = Room::find($request->id);


            if(!$room){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Room not found'
                    ],
                    400
                );
            }

            $room->delete();
            return response()->json(
                [
                    'status' => 'OK',
                    'message' => 'Room deleted successfully'
                ],
                200
            );

        } catch(\Exception $error){
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error deleting room"

                ],
                500
            );
        }
    }





}
