#!/usr/bin/php
<?php

namespace App;

use Lack\Invoice\InvoiceFacet;
use Lack\Invoice\Type\T_Customer;
use Lack\Invoice\Type\T_Invoice;
use Lack\Invoice\Type\T_Layout;

if (file_exists(__DIR__ . "/../vendor/autoload.php"))
    require_once __DIR__ . "/../vendor/autoload.php";
else
    require_once __DIR__ . "/../autoload.php";


$tlayout = phore_file("./inv_layout.yml")->get_yaml(T_Layout::class);

$invoiceFile = phore_file($argv[1]);
$outPath = $invoiceFile->getDirname()->asDirectory();

$customer = $invoiceFile->getDirname()->withSubPath("customer.yml")->asFile()->get_yaml(T_Customer::class);
$invoice = $invoiceFile->get_yaml(T_Invoice::class);


$facet = new InvoiceFacet($tlayout, $customer, $invoice);
$facet->generate($outPath->withFileName($invoice->invoiceId . ".pdf"));
