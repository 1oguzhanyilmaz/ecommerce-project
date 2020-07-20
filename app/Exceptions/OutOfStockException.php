<?php

namespace App\Exceptions;

use Exception;

class OutOfStockException extends Exception
{
    // additional logging
    public function report(){
        \Log::debug('The product is out of stock');
    }
}
