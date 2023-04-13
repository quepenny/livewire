<?php

namespace Quepenny\Livewire\Exports;

use Quepenny\Livewire\Traits\Makeable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;

class BaseExport implements Responsable
{
    use Makeable;
    use Queueable;
    use Exportable;

    protected string $filePath;

    protected string $writerType = Excel::CSV;

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $path): void
    {
        $this->filePath = "exports/{$path}";
    }
}
