# Builder Pattern در لاراول

## 📖 مقدمه

الگوی طراحی **Builder** یکی از پرکاربردترین الگوهای طراحی (Design Patterns) در دسته‌ی **Creational** است. این الگو زمانی استفاده می‌شود که می‌خواهیم یک آبجکت پیچیده را مرحله به مرحله بسازیم.

در این مثال، ما یک **سیستم تولید گزارش (Report Generator)** در لاراول طراحی می‌کنیم. هر گزارش می‌تواند بخش‌های مختلفی مثل:

* عنوان (Title)
* داده‌ها (Data)
* نمودار (Chart)

داشته باشد. اما همه‌ی گزارش‌ها الزاما همه‌ی بخش‌ها را ندارند. اینجا **Builder Pattern** کمک می‌کند بخش به بخش گزارش ساخته شود.

---

## 📂 ساختار پوشه‌ها

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

## 1. کلاس Product (گزارش نهایی)

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

## 2. اینترفیس Builder

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

## 3. یک Concrete Builder برای PDF

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

## 4. یک Concrete Builder برای HTML

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

## 5. Director (مدیر ساخت)

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

## 6. تست در Controller (یا Route)

در `routes/web.php` این کد را اضافه کنید:

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

## 🎯 خروجی نهایی

وقتی به `/builder-demo` بروید:

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

## ✅ نتیجه‌گیری

با استفاده از **Builder Pattern** توانستیم:

* بخش به بخش یک آبجکت پیچیده (Report) را بسازیم.
* چندین شکل مختلف (PDF و HTML) از یک گزارش تولید کنیم.
* کد تمیز و منعطف داشته باشیم.

> این الگو مخصوصا وقتی مفید است که بخواهید یک آبجکت را با **تنظیمات و حالات مختلف** بسازید.
📄 [نسخه انگلیسی](./README.md)
