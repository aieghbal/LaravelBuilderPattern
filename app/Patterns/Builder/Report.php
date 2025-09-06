<?php


namespace App\Patterns\Builder;

class Report
{
    public string $title;
    public array $data = [];
    public string $chart = '';

    public function show()
    {
        return [
            'title' => $this->title ?? '',
            'data'  => $this->data,
            'chart' => $this->chart ?? '',
        ];
    }
}
