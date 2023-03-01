<?php

namespace View\Sales;

use View\View;

class TableRow implements View
{
    public function render($data = null): string
    {
        $data = $data ?? [
            'id' => '',
            'created_at' => '',
            'total' => '',
        ];
        return <<<HTML
            <tr dataset-id="{$data['id']}">
                <td>
                    {$data['created_at']}
                </td>
                <td>
                    {$data['total']}
                </td>
            </tr>
HTML;
    }
}
