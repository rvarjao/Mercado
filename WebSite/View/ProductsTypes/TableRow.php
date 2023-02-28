<?php

namespace View\ProductsTypes;

use View\View;

class TableRow implements View
{
    public function render($data = null): string
    {
        $data = $data ?? [
            'id' => '',
            'name' => ''
        ];
        return <<<HTML
            <tr dataset-id="{$data['id']}">
                <td>
                    {$data['name']}
                </td>
                <td>
                    <a href="#edit" data-target="modal-newProductType" onclick="">
                        <i class="fa-solid fa-pen-to-square danger"></i>
                    </a>
                    <a href="#delete" onclick=""><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
HTML;
    }
}
