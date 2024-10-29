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
}
