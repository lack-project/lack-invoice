<?php

namespace Lack\Invoice\Sheet;

use Lack\Invoice\Format\Col;
use Lack\Invoice\Format\ColumnFpdf;
use Lack\Invoice\Type\T_Customer;
use Lack\Invoice\Type\T_Invoice;
use Lack\Invoice\Type\T_Layout;

class InvoiceSheet extends ColumnFpdf
{
    public string $headerImage;
    public int $headerImageWidth;
    public int $headerImageHeight;

    public function __construct(
        public T_Layout $layout,
        public T_Customer $customer,
        public T_Invoice $invoice
    )
    {
        parent::__construct("P", "mm", "A4");
    }


    public function setHeaderImage($headerImage, $width=null, $height=null)
    {
        $this->headerImage = $headerImage;
        $this->headerImageWidth = $width;
        $this->headerImageHeight = $height;
    }


    public function printAddress()
    {
        $this->SetFont('Arial','',10);
        $this->setY(50);
        $this->SetFontSize(6);
        $this->printRow(
            new Col(6),
            new Col(39, $this->layout->windowAddress, style: "i", fontsize: 7, height: 8)
        );


        $this->SetFontSize(12);
        $this->printRow(
            new Col(6),
            new Col(39, $this->customer->address, fontsize: 11, height: 5, style: "B")
        );
    }

    public function printInvoiceHeader()
    {
        $this->setY(10);
        $this->SetFillColor(230,230,230);

        $this->printRow(
            new Col(55),
            new Col(45, "Rechnung", 28,15)
        );
        $this->printRow(
            new Col(55),
            new Col(45, "", 28,15)
        );
        $this->printRow(
            new Col(55, ),
            new Col(45, "Bitte bei Zahlungen oder Rückfragen angeben:", 10,5, fill: true)
        );
        $this->printRow(
            new Col(55),
            new Col(15, "RechnungsNr:", 10,8, style: "b", fill: true),
            new Col(30, $this->invoice->invoiceId, 12,8, style: "b", fill: true)
        );

        $this->printRow(
            new Col(55),
            new Col(15, "Kunden-Id:", style: "", fontsize: 10, height: 10),
            new Col(30, $this->customer->customerId, style: "", fontsize: 12, height: 10)
        );
        $this->printRow(
            new Col(55),
            new Col(15, "Zahlart:", style: "", fontsize: 10, height: 6),
            new Col(30, $this->invoice->payMethod, style: "", fontsize: 10, height: 6)
        );
        if ($this->invoice->dueDate !== null) {
            $this->printRow(
                new Col(55),
                new Col(15, "Zahlungsziel:", style: "", fontsize: 10, height: 6),
                new Col(30, $this->invoice->dueDate, style: "", fontsize: 10, height: 6)
            );
        }
        $this->printRow(
            new Col(55),

            new Col(30, "", 3, style: "b", fill: false)
        );
        $this->printRow(
            new Col(55),
            new Col(15, "Datum", 10,6, style: "", fill: false),
            new Col(30, $this->invoice->invoiceDate, 12,6, style: "", fill: false)
        );
    }


    public function printItemHeader() {
        $this->SetY(100);
        $this->printRow(
            new Col(5),
            new Col(5, "Pos", border: "B"),

            new Col(35, "Bezeichnung", border: "B"),
            new Col(10, "USt", align: 'R', border: "B"),
            new Col(15, "Einzelpreis", align: 'R', border: "B"),
            new Col(10, "Menge", align: 'R', border: "B"),
            new Col(15, "Gesamt", align: 'R', border: "B"),
        );
    }

    public function printItemLine($desc, $price, $quantity, $optDescription=null) {
        static $i=1;
        $this->printRow(
            new Col(100, "", height: 3),

        );
        $this->printRow(
            new Col(5),
            new Col(5, $i++),
            new Col(35, "$desc", style: "b"),
            new Col(10, "19%", align: 'R'),
            new Col(15, number_format($price, 2, ",", "."), align: 'R'),
            new Col(10, $quantity . "x", align: 'R'),
            new Col(15, number_format($price * $quantity, 2, ",", "."), align: 'R', style: "b"),
        );
        if ($optDescription !== null) {
            $this->printRow(
                new Col(5),
                new Col(5),
                new Col(45, $optDescription, fontsize: 10, height: 5),
            );
        }
    }


    public function printTotals($totalNet, $vat) {
        $this->printRow(
            new Col(100, "", height: 3),

        );
        $this->printRow(
            new Col(5),
            new Col(5),
            new Col(45),
            new Col(21, "Summe Netto", align: 'R', border: "T"),
            new Col(20, number_format($totalNet, 2, ",", "."), align: 'R', style: "", border: "T"),
        );
        $this->printRow(
            new Col(5),
            new Col(5),
            new Col(45),
            new Col(21, "zzgl. 19% USt.", align: 'R', style: "i"),
            new Col(20, number_format($totalNet * ( $vat/100), 2, ",", "."), align: 'R', style: "i"),
        );
        $this->printRow(
            new Col(55, $this->invoice->notice ?? "Bitte überweisen Sie den Rechnungsbetrag auf das u.a. Konto."),
            new Col(21, "Rechnungsbetrag", align: 'L', style: "b", fill: true, fontsize: 12, height: 10),
            new Col(20, number_format($totalNet * ( 1 + $vat/100), 2, ",", ".") . " EUR", align: 'R', style: "b", fontsize: 12, height: 10, fill: true),
        );
    }


    public function Header()
    {
        parent::Header(); // TODO: Change the autogenerated stub
        $this->SetY(10);
        if ($this->headerImage !== null)
            $this->Image($this->headerImage, null, null, $this->headerImageWidth, $this->headerImageHeight);
    }


    public function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial','',9);

        $this->printRow(
            new Col(33, $this->layout->footer1, border: 'T', height: 4),
            new Col(33, $this->layout->footer2, align: "C", border: "T"),
            new Col(33, $this->layout->footer3, align: "R", border: "T")
        );
    }
}
