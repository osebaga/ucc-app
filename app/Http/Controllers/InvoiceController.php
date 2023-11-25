<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {
        try {
            $data = $request->json()->all();

            $inv_data = [
                'SystemCode' => $data['SystemAuth']['SystemCode'],
                'ServiceCode' => $data['SystemAuth']['ServiceCode'],
                'Signature' => $data['SystemAuth']['Signature'],
                'RequestId' => $data['RequestData']['RequestId'],
                'SpCode' => $data['RequestData']['BillHdr']['SpCode'],
                'RtrRespFlg' => $data['RequestData']['BillHdr']['RtrRespFlg'],
                'BillId' => $data['RequestData']['BillTrxInf']['BillId'],
                'SubSpCode' => $data['RequestData']['BillTrxInf']['SubSpCode'],
                'SpSysId' => $data['RequestData']['BillTrxInf']['SpSysId'],
                'BillAmt' => $data['RequestData']['BillTrxInf']['BillAmt'],
                'MiscAmt' => $data['RequestData']['BillTrxInf']['MiscAmt'],
                'BillExprDt' => $data['RequestData']['BillTrxInf']['BillExprDt'],
                'PyrId' => $data['RequestData']['BillTrxInf']['PyrId'],
                'PyrName' => $data['RequestData']['BillTrxInf']['PyrName'],
                'BillDesc' => $data['RequestData']['BillTrxInf']['BillDesc'],
                'BillGenDt' => $data['RequestData']['BillTrxInf']['BillGenDt'],
                'BillGenBy' => $data['RequestData']['BillTrxInf']['BillGenBy'],
                'PayCntrNum' => $this->generate_ctl(),
                'BillApprBy' => $data['RequestData']['BillTrxInf']['BillApprBy'],
                'PyrCellNum' => $data['RequestData']['BillTrxInf']['PyrCellNum'],
                'PyrEmail' => $data['RequestData']['BillTrxInf']['PyrEmail'],
                'Ccy' => $data['RequestData']['BillTrxInf']['Ccy'],
                'BillEqvAmt' => $data['RequestData']['BillTrxInf']['BillEqvAmt'],
                'RemFlag' => $data['RequestData']['BillTrxInf']['RemFlag'],
                'BillPayOpt' => $data['RequestData']['BillTrxInf']['BillPayOpt'],
                'BillItemRef' => $data['RequestData']['BillTrxInf']['BillItems']['BillItem'][0]['BillItemRef'],
                'GfsCode' => $data['RequestData']['BillTrxInf']['BillItems']['BillItem'][0]['GfsCode'],
            ];

             $save = Invoice::create($inv_data);
            if ($save) {
                $resp = Invoice::where('id',$save->id)->first();
                return response()->json(
                    [
                        'SystemAuth' => [
                            'ServiceCode' => $resp->ServiceCode,
                            'Signature' => $resp->Signature
                        ],
                        'FeedbackData' => [
                            'gepgBillSubResp' => [
                                'BillTrxInf' => [
                                    'BillId' => $resp->BillId,
                                    'PayCntrNum' => $resp->PayCntrNum,
                                    'TrxSts' => "GS",
                                    'TrxStsCode' => "7101"
                                ]
                            ]
                        ],
                        'Status' =>
                        [
                            'RequestId' => $resp->RequestId,
                            'Code' => "7101",
                            'Description' => "Success"
                        ]
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('Failed' . $e->getMessage());
            return response()->json(
                [
                    'status' => '501',
                    'description' => 'Error',
                ],
                501,
            );
        }
    }


    public function generate_ctl()
    {
        $ctl = date('Ymd').random_int(1000,9999);
        return $ctl;
    }
    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
