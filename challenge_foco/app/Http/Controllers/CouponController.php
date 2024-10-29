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


    public function createCouponCode(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|max:50|unique:coupon_codes,code',
                'discount_type' => 'required|in:percent,fixed',
                'value' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'max_uses' => 'nullable|integer|min:1',
            ]);

            $coupon = new CouponCode();
            $coupon->code = $request->code;
            $coupon->discount_type = $request->discount_type;
            $coupon->value = $request->value;
            $coupon->description = $request->description;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->max_uses = $request->max_uses ?? 1;

            $coupon_saved = $coupon->save();

            if ($coupon_saved) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Coupon created successfully",
                        'data' => $coupon
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Failed to save coupon"
                    ],
                    500
                );
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



    public function updateCouponCode(Request $request)
    {
        try {
            $coupon = CouponCode::find($request->id);

            if (!$coupon) {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Coupon not found",
                    ],
                    400
                );
            }

            $coupon->code = $request->code ?? $coupon->code;
            $coupon->discount_type = $request->discount_type ?? $coupon->discount_type;
            $coupon->value = $request->value ?? $coupon->value;
            $coupon->description = $request->description ?? $coupon->description;
            $coupon->start_date = $request->start_date ?? $coupon->start_date;
            $coupon->end_date = $request->end_date ?? $coupon->end_date;
            $coupon->max_uses = $request->max_uses ?? $coupon->max_uses;
            $coupon->save();

            return response()->json(
                [
                    'status' => "OK",
                    'message' => "Coupon updated successfully",
                    'data' => $coupon
                ],
                200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error updating coupon information"
                ],
                500
            );
        }
    }

    public function deleteCoupon(Request $request)
    {
        try {
            $coupon = CouponCode::find($request->id);

            if(!$coupon){
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Coupon not found'
                    ],
                    400
                );
            }

            $coupon->delete();
            return response()->json(
                [
                    'status' => 'OK',
                    'message' => 'Coupon deleted successfully'
                ],
                200
            );

        } catch(\Exception $error){
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error deleting coupon"

                ],
                500
            );
        }
    }


}
