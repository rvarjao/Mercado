<?php

namespace View\ProductsTypes;

use View\View;

class Index implements View
{
    public function render($data = null) : string
    {
        return "<h1>Products Types</h1>";
    }
}
