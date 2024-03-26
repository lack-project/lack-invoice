<?php

namespace Lack\Invoice;

use Lack\Invoice\Sheet\InvoiceSheet;
use Lack\Invoice\Type\T_Customer;
use Lack\Invoice\Type\T_Invoice;
use Lack\Invoice\Type\T_Layout;
use Phore\FileSystem\PhoreFile;

class InvoiceFacet
{

    public function __construct(
        public T_Layout $layout,
        public T_Customer $customer,
        public T_Invoice $invoice
    ){}


    public function generate(PhoreFile $outFile = null) {
        $p = new InvoiceSheet($this->layout, $this->customer, $this->invoice);
        $p->setHeaderImage($this->layout->logoUrl, 30, 10);
        $p->printBorders = false;
        $p->SetFont("Arial");
        $p->AddPage();
        $p->printAddress();
        $p->printInvoiceHeader();

        $p->printItemHeader();
        $total = 0.;
        foreach ($this->invoice->items as $item) {
            $total += $item->unit_price_net * $item->quantity;
            $p->printItemLine($item->title, $item->unit_price_net, $item->quantity, $item->desc);
        }

        $p->printTotals($total, 19);
        
        if ($this->layout->exclamationText !== null) {
            $p->printExclamationBox($this->layout->exclamationText);
        }
        
        if ($this->invoice->attachment !== "") {
            $p->AddPage();
            $p->printAttachment($this->invoice->attachment);
        }
        
        if ($outFile !== null)
            return $p->Output("F", $outFile, true);
        return $p->Output("S","", true);
    }

}
