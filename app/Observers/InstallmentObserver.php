<?php

namespace App\Observers;

use App\Installment;
use Illuminate\Support\Facades\Auth;

class InstallmentObserver
{
    public function creating(Installment $installment){
        $installment->created_by=Auth::id();
    }
    public function saving(Installment $installment) {
        $installment->updated_by=Auth::id();
    }
    public function deleting(Installment $installment) {
        $installment->deleted_by=Auth::id();
        $installment->save();
    }
}
