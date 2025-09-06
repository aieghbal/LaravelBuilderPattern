<?php


namespace App\Patterns\Builder;

class PDFReportBuilder implements ReportBuilder
{
    protected Report $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function setTitle(string $title): self
    {
        $this->report->title = "[PDF] " . $title;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->report->data = $data;

        return $this;
    }

    public function setChart(string $chart): self
    {
        $this->report->chart = "[PDF Chart] " . $chart;

        return $this;
    }

    public function getReport(): Report
    {
        return $this->report;
    }
}
