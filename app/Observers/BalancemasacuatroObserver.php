<?php

namespace App\Observers;

use App\Models\Balancemasacuatro;

class BalancemasacuatroObserver
{
    public function creating(Balancemasacuatro $masa)
    {
        $masa->sort=Balancemasacuatro::max('sort')+1;
    }
}
