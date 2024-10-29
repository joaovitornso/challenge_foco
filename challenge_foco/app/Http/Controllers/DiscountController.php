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

    public function createDiscount(Request $request)
    {
        try {
            $request->validate([
                'reserve_id' => 'required|integer|exists:reserves,id',
                'coupon_id' => 'nullable|integer|exists:coupon_codes,id',
                'discount_type' => 'required|in:percent,fixed',
                'value' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:255',
            ]);

            $discount = new Discount();
            $discount->reserve_id = $request->reserve_id;
            $discount->coupon_id = $request->coupon_id;
            $discount->discount_type = $request->discount_type;
            $discount->value = $request->value;
            $discount->description = $request->description;

            $discount_saved = $discount->save();

            if ($discount_saved) {
                return response()->json(
                    [
                        'status' => "OK",
                        'message' => "Discount created successfully",
                        'data' => $discount
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Failed to save discount"
                    ],
                    500
                );
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'trace' => $error->getTraceAsString(),
                    'message' => "An error occurred while saving the discount"
                ],
                500
            );
        }
    }

    public function updateDiscount(Request $request)
    {
        try {
            $discount = Discount::find($request->id);

            if (!$discount) {
                return response()->json(
                    [
                        'status' => "error",
                        'message' => "Discount not found",
                    ],
                    400
                );
            }

            $discount->reserve_id = $request->reserve_id ?? $discount->reserve_id;
            $discount->coupon_id = $request->coupon_id ?? $discount->coupon_id;
            $discount->discount_type = $request->discount_type ?? $discount->discount_type;
            $discount->value = $request->value ?? $discount->value;
            $discount->description = $request->description ?? $discount->description;
            $discount->save();
            return response()->json(
                [
                    'status' => "OK",
                    'message' => "Discount updated successfully",
                    'data' => $discount
                ],
                200
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'error' => $error->getMessage(),
                    'message' => "Error updating discount information"
                ],
                500
            );
        }
    }

    public function deleteDiscount(Request $request)
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
