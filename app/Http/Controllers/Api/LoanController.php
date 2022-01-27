<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\LoanHistories;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * [user LoanController]
 */
class LoanController extends Controller
{

    /**
     * @return response
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

        $data['user_id'] = Auth::user()->id;
        $data['status'] = 0;
        $loan = Loan::create($data);
        return response(['loan' => new LoanResource($loan), 'message' => 'Created successfully'], 200);
    }


    /**
     * @param mixed $id
     *
     * @return response
     */
    public function show($id)
    {
        $loan = Loan::whereUserId(Auth::user()->id)->find($id);
        return response(['loan' => new LoanResource($loan), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param Request $request
     *
     * @return response
     */
    public function nextLoanPayments(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'loan_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $loan = Loan::whereUserId(Auth::user()->id)->find($request->loan_id);
        if (is_null($loan)) {
            return response(['loan' => new LoanResource($loan), 'message' => 'No Loan Found.'], 200);
        }

        $Loan_historie = LoanHistories::whereLoanId($request->loan_id)->wherePaidDate(null)
                                        ->orderBy('loan_term','ASC')
                                        ->first();

        return response(['Loan Histories' => new LoanResource($Loan_historie), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param Request $request
     *
     * @return response
     */
    public function payLoanPayments(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'loan_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Loan_historie = LoanHistories::whereLoanId($request->loan_id)->wherePaidDate(null)->orderBy('loan_term', 'ASC')->first();
        if( !empty($Loan_historie) ){
            $Loan_historie->paid_date = date('Y-m-d');
            $Loan_historie->save();
        }
        return response(['Loan Histories' => new LoanResource($Loan_historie), 'message' => 'Retrieved successfully'], 200);
    }
}
