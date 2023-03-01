<?php

namespace View\Products;

use View\View;

class TableRow implements View
{
    public function render($data = null): string
    {
        $data = $data ?? [
            'id' => '',
            'name' => '',
            'product_type_name' => '',
        ];

        return <<<HTML
            <tr dataset-id="{$data['id']}">
                <td>
                    {$data['name']}
                </td>
                <td>
                    {$data['product_type_name']}
                </td>
                <td></td>
            </tr>
HTML;
    }
}
