<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{


    public function discounts()
    {
        try{
            $discounts = Discount::paginate(10);
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "success",
                    'data' => $discounts
                ],
             200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Error retrieving discounts data"
                ],
                404
            );
        }
    }

    public function discount(Request $request) #POST
    {
        try {
            $discount = Discount::find($request->id);
            if ($discount) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "success",
                        'data' => $discount
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "discount ID is required",
                    ],
                    400
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    "message" => "An unexpected error occurred while retrieving the discount"
                ],
                500
            );
        }
    }


    public function deletediscount(Request $request)
    {
        try {
            $discount = Discount::find($request->id);

            if(!$discount){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'discount not found'
                    ],
                    400
                );
            }

            $discount->delete();
            return response()->json(
                [
                    'status' => 'OK',
                    'message' => 'discount deleted successfully'
                ],
                200
            );

        } catch(\Exception $error){
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error deleting discount"

                ],
                500
            );
        }
    }


}
