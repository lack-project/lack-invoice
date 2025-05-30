<?php

namespace Lack\Invoice\Type;

class T_Customer
{

    public ?string $customerId = null;

    public string $email;

    /**
     * Multiline (separated by \n) address including full Postal Address
     *
     * Example:
     * Dr. Max Mustermann
     * Musterstraße 1
     * 12345 Musterstadt
     *
     * @var string
     */
    public string $address;


    /**
     * @var string
     */
    public string $info = "";
}
