<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReserveController extends Controller
{

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
