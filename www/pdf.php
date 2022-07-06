<?php

namespace Demo;
use Lack\Invoice\Format\ColumnFpdf;
use Lack\Invoice\Sheet\InvoiceSheet;

require __DIR__ . "/../vendor/autoload.php";

$p = new InvoiceSheet();
$p->setHeaderImage("leuffen-logo-header-big.png", 30, 10);
$p->printBorders = false;
$p->SetFont("Arial");
$p->AddPage();
$p->printAddress();
$p->printInvoiceHeader();

$p->printItemHeader();
$p->printItemLine("Webdesign Paket A", 375, 1, "Das Paket ist \nMultiline fähig");
$p->printItemLine("Webdesign Paket A", 375, 1, "Das Paket ist \nMultiline fähig");
$p->printTotals(1234, 19);
$p->Output('', '', true);



