<?php

namespace View\Taxes;

use View\View;

class Index implements View
{
    public function render($data = null) : string
    {
        return "<h1>Taxes</h1>";
    }
}
