<?php

namespace View;

interface View
{
    public function render($data = null) : string;
}
