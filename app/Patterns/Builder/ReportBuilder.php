<?php


namespace App\Patterns\Builder;

interface ReportBuilder
{
    public function setTitle(string $title): self;

    public function setData(array $data): self;

    public function setChart(string $chart): self;

    public function getReport(): Report;
}
