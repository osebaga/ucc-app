<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('SystemCode');
            $table->string('ServiceCode');
            $table->text('Signature');
            $table->string('RequestId');
            $table->string('SpCode');
            $table->string('RtrRespFlg');
            $table->string('BillId');
            $table->string('SubSpCode');
            $table->string('SpSysId');
            $table->double('BillAmt', 8, 2);
            $table->double('MiscAmt',8,2);
            $table->string('BillExprDt');
            $table->string('PyrId');
            $table->string('PyrName');
            $table->string('PayCntrNum')->nullable();
            $table->string('BillDesc');
            $table->string('BillGenDt');
            $table->string('BillGenBy');
            $table->string('BillApprBy');
            $table->string('PyrCellNum');
            $table->string('PyrEmail');
            $table->string('Ccy');
            $table->double('BillEqvAmt',8,2);
            $table->string('RemFlag');
            $table->string('BillPayOpt');
            $table->string('BillItemRef');
            $table->string('GfsCode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
