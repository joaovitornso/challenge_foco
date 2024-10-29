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


    public function createCoupon(Request $request)
    {
        try {

            $request = $request->validate([
                'code' => 'required|string|unique:coupon_codes,code',
                'discount_type' => 'required|in:percent,fixed',
                'value' => 'required|numeric',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'max_uses' => 'nullable|integer|min:1',
            ]);

            // $coupon = new CouponCode();
            // $coupon->code = $request->coupon;

            // $coupon->code = $request->coupon;
            // $coupon->discount_type = $request->discount_type;
            // $coupon->value = $request->value;
            // $coupon->description = $request->description;
            // $coupon->start_date = $request->start_date;
            // $coupon->end_date = $request->end_date;
            // $coupon->max_uses = $request->max_uses;


            $coupon = CouponCode::create($request);

            // $coupon_saved = $coupon->save();

            if($coupon){
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Coupon created successfully",
                        'data' => $coupon
                    ],
                    200);
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Failed to save coupon"
                    ],
                    500);
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'trace' => $error->getTraceAsString(),
                    'message' => "An error occurred while saving the coupon"
                ],
                500
            );
        }
    }
}
