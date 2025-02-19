<?php

namespace App\Html;

class Table
{
    /**
     * @var array
     */
    private array $data;
    /**
     * @var array
     */
    private array $headers;

    /**
     * @param array $data
     * @param array $headers
     */
    public function __construct(array $data = [], array $headers = [])
    {
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * Render the table
     * @return string
     */
    public function render(): string
    {
        $html = '<table>';
        $html .= $this->renderHeader();
        $html .= $this->renderBody();
        $html .= '</table>';
        return $html;
    }

    /**
     * Render table header
     * @return string
     */
    private function renderHeader(): string
    {
        $header = "<thead><tr>";

        foreach ($this->headers as $h) {
            $header .= "<th>" . htmlspecialchars($h) . "</th>";
        }

        $header .= "</tr></thead>";

        return $header;
    }

    /**
     * Render table body
     * @return string
     */
    private function renderBody(): string
    {
        if (count($this->data) === 0 ) {
            return $this->renderEmptyState();
        }

        $body = "<tbody>";

        foreach ($this->data as $row) {
            $body .= "<tr>";
            foreach ($row as $cell) {
                $body .= "<td>" . htmlspecialchars($cell) . "</td>";
            }
            $body .= "</tr>";
        }

        $body .= "</tbody>";

        return $body;
    }

    /**
     * Render empty table state
     * @return string
     */
    private function renderEmptyState(): string
    {
        return '<tbody><tr><td class="text-center" colspan="'.count($this->headers).'">No data found</td></tr></tbody>';
    }
}