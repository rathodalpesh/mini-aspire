<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\LoanHistories;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use Illuminate\Support\Facades\Validator;

class AdminLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::all();
        return response(['loans' => LoanResource::collection($loans), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CEO  $ceo
     * @return \Illuminate\Http\Response
     */
    public function approvalLoan( Request $request )
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $loan = Loan::find($request->id);

        if (is_null($loan)) {
            return response(['loan' => new LoanResource($loan), 'message' => 'No Loan Found.'], 200);
        }

        if($request->status == "2" ){
            $loan->status = 2;
            $loan->save();
        }

        if( $loan->status != 1 && $request->status == "1" ){

            $loanHistories = [];
            $today_date = date('Y-m-d');

            $loan->status = 1;
            $loan->start_date = $today_date;

            for ($i=1; $i <= $loan->loan_term ; $i++) {
                $amount = $loan->amount;
                $rate = ($loan->interest / 100) / 52; // Weekly interest rate
                $term = $loan->loan_term; // Term in weeks
                $emi = $amount * $rate * (pow(1 + $rate, $term) / (pow(1 + $rate, $term) - 1));
                $date = strtotime("+7 day", strtotime($today_date));
                $today_date = date('Y-m-d', $date);

                $loanHistories[] = [
                    'loan_id' => $loan->id,
                    'loan_term' => $i,
                    'amount_paid' => $emi,
                    'pay_date' => $today_date,
                ];
            }

            $loan->end_date = $today_date;
            LoanHistories::insert($loanHistories);
            $loan->save();
        }
        return response(['loan' => new LoanResource($loan), 'message' => 'Retrieved successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CEO $ceo
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy( $id)
    {
        $loan = Loan::find($id);

        if (is_null($loan)) {
            return response(['loan' => new LoanResource($loan), 'message' => 'No Loan Found.'], 200);
        }

        LoanHistories::where('loan_id', $id )->delete();
        $loan->delete();
        return response(['message' => 'Deleted']);
    }
}
