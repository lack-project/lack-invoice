<?php

namespace Lack\Invoice\Format;

use Fpdf\Fpdf;

class Col
{

    public function __construct(
        public int $width,
        public ?string $text = null,
        public ?int $fontsize = null,
        public ?int $height = null,
        public ?string $align = "L",
        public string $style = "",
        public mixed $border = null,
        public bool $fill = false
    ){}


    public function render(ColumnFpdf $fpdf, int $width) {
        $fpdf->SetFont($fpdf->defaultFont, $this->style);
        $fpdf->SetFontSize($fpdf->defaultFontSize);
        if ($this->fontsize !== null)
            $fpdf->SetFontSize($this->fontsize);

        if ($this->text !== null) {
            $fpdf->MultiCell(
                $width,
                $this->height ?? $fpdf->defaultLineHeight,
                utf8_decode($this->text),
                $this->border ?? $fpdf->printBorders,
                $this->align,
                $this->fill
            );
        }
    }

}
