# Builder Pattern in Laravel

## 📖 Introduction

The Builder design pattern is one of the most commonly used Creational design patterns. This pattern is used when you want to construct a complex object step by step.

In this example, we design a Report Generator system in Laravel. Each report can have various sections such as:
Title
Data
Chart

Not all reports necessarily include all sections. Here, the Builder Pattern helps us construct the report piece by piece.

---

## 📂 Folder Structure

```
app/
 └── Patterns/
      └── Builder/
           ├── Report.php
           ├── ReportBuilder.php
           ├── PDFReportBuilder.php
           ├── HTMLReportBuilder.php
           └── ReportDirector.php
```

---

## 1. Product Class (Final Report)

```php
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
```

---

## 2. Builder Interface

```php
<?php

namespace App\Patterns\Builder;

interface ReportBuilder
{
    public function setTitle(string $title): self;
    public function setData(array $data): self;
    public function setChart(string $chart): self;
    public function getReport(): Report;
}
```

---

## 3. A Concrete Builder for PDF

```php
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
```

---

## 4. A Concrete Builder for HTML

```php
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
```

---

## 5. Director

```php
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
```

---

## 66. Test in Controller (or Route)

Add this code to routes/web.php:

```php
use App\Patterns\Builder\PDFReportBuilder;
use App\Patterns\Builder\HTMLReportBuilder;
use App\Patterns\Builder\ReportDirector;

Route::get('/builder-demo', function () {
    $director = new ReportDirector();

    $pdfReport = $director->buildFullReport(new PDFReportBuilder());
    $htmlReport = $director->buildSimpleReport(new HTMLReportBuilder());

    return response()->json([
        'pdf' => $pdfReport->show(),
        'html' => $htmlReport->show(),
    ]);
});
```

---

## 🎯 Final Output

When you visit /builder-demo:

```json
{
  "pdf": {
    "title": "[PDF] Full Report",
    "data": ["row1", "row2", "row3"],
    "chart": "[PDF Chart] Sales Growth Chart"
  },
  "html": {
    "title": "<h1>Simple Report</h1>",
    "data": ["row1", "row2", "row3"],
    "chart": ""
  }
}
```

---

## ✅ Conclusion

By using the Builder Pattern, we were able to:

Build a complex object (Report) step by step.

Produce multiple formats (PDF and HTML) of the same report.

Keep the code clean and flexible.

This pattern is especially useful when you need to construct an object with various configurations and states.
📄 [نسخه فارسی](./README.fa.md)
