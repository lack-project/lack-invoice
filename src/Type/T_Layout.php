<?php

namespace Lack\Invoice\Type;

class T_Layout
{

    public string $logoUrl;

    public string $footer1;

    public string $footer2;

    public string $footer3;

    public string $windowAddress = "Undefined Window Address";

    /**
     * Special Text box for urgent messages
     * 
     * @var string|null 
     */
    public ?string $exclamationText = null;
    
}
