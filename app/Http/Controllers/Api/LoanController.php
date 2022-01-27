<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan:: whereUserId(Auth::user()->id)->get();
        return response(['loans' => LoanResource::collection($loans), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['interest'] = 11;

        $validator = Validator::make($data, [
            'loan_term' => 'required|integer|min:1',
            'amount' => 'required|integer|min:5',
            'purpose' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

      /*   $amount = $data['amount'];
        $rate = .( $data['interest'] ) / 52; // Weekly interest rate
        $term = $data['loan_term']; // Term in weeks
        $emi = $amount * $rate * (pow(1 + $rate, $term) / (pow(1 + $rate, $term) - 1)); */
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 0;
        $loan = Loan::create($data);
        return response(['loan' => new LoanResource($loan), 'message' => 'Created successfully'], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\CEO  $ceo
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return response(['loan' => new LoanResource($loan), 'message' => 'Retrieved successfully'], 200);
    }

}
