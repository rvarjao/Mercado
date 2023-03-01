<?php

namespace View\Prices;

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
                    {$data['product_name']}
                </td>
                <td>
                    {$data['product_type_name']}
                </td>
                <td>
                    {$data['price']}
                </td>
                <td>
                    {$data['created_at']}
                </td>
                <td></td>
            </tr>
HTML;
    }
}


