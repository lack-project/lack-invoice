<?php

namespace Lack\Invoice\Type;

class T_Customer
{

    public string $customerId;
    
    public string $email;
    public string $address;


    /**
     * @var string 
     */
    public string $info = "";
}
