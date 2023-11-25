<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable=
    [
        'SystemCode',
        'ServiceCode',
        'Signature',
        'RequestId',
        'SpCode',
        'RtrRespFlg',
        'BillId',
        'SubSpCode',
        'SpSysId',
        'BillAmt',
        'MiscAmt',
        'BillExprDt',
        'PyrId',
        'PyrName',
        'PayCntrNum',
        'BillDesc',
        'BillGenDt',
        'BillGenBy',
        'BillApprBy',
        'PyrCellNum',
        'PyrEmail',
        'Ccy',
        'BillEqvAmt',
        'RemFlag',
        'BillPayOpt',
        'BillItemRef',
        'GfsCode'
    ];
}
