<?php

namespace Lack\Invoice\Type;

class T_Invoice_Item
{

    public string $title;
    public string $desc = "";
    public int $vat = 19;
    public float $unit_price_net;
    public float $quantity = 1;


}
