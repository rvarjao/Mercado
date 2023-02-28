<?php

namespace View\Taxes;

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
                    {$data['percentage']}
                </td>
                <td></td>
            </tr>
HTML;
    }
}

