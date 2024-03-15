<?php

namespace App\Repository\Factures;
use App\Models\Controlefacture;

class ControlefacturesRepository implements ControlefacturesInterface
{
    public function getAll($fields = '*'){
        $invoices = Controlefacture::all($fields);
        return $invoices->toArray();
    }
}