<?php

namespace Lack\Invoice\Type;

class T_Invoice
{

    public string $invoiceId;

    public string $invoiceDate;

    public string $payMethod = "Rechnung";

    public string $dueDate;

    /**
     * @var string|null
     */
    public ?string $notice = null;

    /**
     * @var T_Invoice_Item[]
     */
    public array $items = [];


    public bool $net_invoice = true;

}
