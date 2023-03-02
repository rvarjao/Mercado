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

        $total = number_format($data['total'], 2, ',', '.');

        return <<<HTML
            <tr data-id="{$data['id']}">
                <td>
                    {$data['created_at']}
                </td>
                <td>
                    {$total}
                </td>
            </tr>
HTML;
    }
}
