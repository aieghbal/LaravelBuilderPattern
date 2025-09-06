<?php


namespace App\Patterns\Builder;

class HTMLReportBuilder implements ReportBuilder
{
    protected Report $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function setTitle(string $title): self
    {
        $this->report->title = "<h1>{$title}</h1>";

        return $this;
    }

    public function setData(array $data): self
    {
        $this->report->data = $data;

        return $this;
    }

    public function setChart(string $chart): self
    {
        $this->report->chart = "<div>Chart: {$chart}</div>";

        return $this;
    }

    public function getReport(): Report
    {
        return $this->report;
    }
}
