<?php

namespace Lack\Invoice\Format;

use Fpdf\Fpdf;

class ColumnFpdf extends Fpdf
{

    public int $defaultFontSize = 10;
    public int $defaultLineHeight = 5;
    public string $defaultFont = "Arial";
    public bool $printBorders = true;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }


    public function printRow(Col ...$rowdef)
    {
        $y = $this->GetY();
        $offset = $this->lMargin;
        $maxHeight = 0;
        foreach ($rowdef as $cell) {
            $this->setY($y);
            $width = ceil(($this->GetPageWidth() - $this->lMargin - $this->rMargin) * ($cell->width / 100));
            if ($cell->text !== null) {
                $this->SetX($offset);
                $cell->render($this, $width);
                if ($this->GetY() > $maxHeight)
                    $maxHeight = $this->GetY();
            }
            $offset += $width;

        }
        $this->SetY($maxHeight);
    }







}
