<?php

namespace App\Http\Controllers;

use App\Models\CouponCode;
use Illuminate\Http\Request;

class CouponController extends Controller
{


    public function coupons()
    {
        try{
            $coupons = CouponCode::paginate(10);
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "success",
                    'data' => $coupons
                ],
             200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    'message' => "Error retrieving coupons data"
                ],
                404
            );
        }
    }

    public function coupon(Request $request) #POST
    {
        try {
            $coupon = CouponCode::find($request->id);
            if ($coupon) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "success",
                        'data' => $coupon
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Coupon ID is required",
                    ],
                    400
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    "message" => "An unexpected error occurred while retrieving the coupon"
                ],
                500
            );
        }
    }
}
