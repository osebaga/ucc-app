<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\RequestProcessing;

class InvoiceController extends Controller
{

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
                $resp = Invoice::where('id', $save->id)->first();

                $request_data =
                    [
                        'FeedbackData' => [
                            'gepgBillSubResp' => [
                                'BillTrxInf' => [
                                    'BillId' => $resp->BillId,
                                    'PayCntrNum' => $resp->PayCntrNum,
                                    'TrxSts' => "GS",
                                    'TrxStsCode' => "7101"
                                ]
                            ]
                        ]
                    ];
                // $signature = RequestProcessing::SignRequest1($request_data);
                // dd($signature);
                return response()->json(
                    [
                        'SystemAuth' => [
                            'ServiceCode' => $resp->ServiceCode,
                            'Signature' => $resp->Signature
                        ],
                        'AckData' => [
                            'RequestId' => $resp->RequestId,
                            'SystemAckCode' => "0",
                            'Description' => "Success",


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
        $ctl = date('Ymd') . random_int(1000, 9999);
        return $ctl;
    }
}
