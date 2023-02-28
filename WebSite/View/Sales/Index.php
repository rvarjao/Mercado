<?php

namespace View\Sales;

use View\View;

class Index implements View
{
    public function render($data = null) : string
    {
        return "<h1>Sales</h1>";
    }
}
