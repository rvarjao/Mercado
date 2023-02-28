<?php

namespace View\Prices;

use View\View;

class Index implements View
{
    public function render($data = null) : string
    {
        return "<h1>Prices</h1>";
    }
}
