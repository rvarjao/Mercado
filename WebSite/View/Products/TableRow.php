<?php

namespace View\Products;

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
                    {$data['type']}
                </td>
                <td>
                    {$data['value']}
                </td>
                <td></td>
            </tr>
HTML;
    }
}


