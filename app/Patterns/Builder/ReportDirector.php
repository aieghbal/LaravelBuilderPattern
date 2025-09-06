<?php


namespace App\Patterns\Builder;

class ReportDirector
{
    public function buildSimpleReport(ReportBuilder $builder): Report
    {
        return $builder
            ->setTitle('Simple Report')
            ->setData(['row1', 'row2', 'row3'])
            ->getReport();
    }

    public function buildFullReport(ReportBuilder $builder): Report
    {
        return $builder
            ->setTitle('Full Report')
            ->setData(['row1', 'row2', 'row3'])
            ->setChart('Sales Growth Chart')
            ->getReport();
    }
}
