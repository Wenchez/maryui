<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FullReportExport;

class ExportReports extends Component
{
    public function export()
    {
        return response()->streamDownload(function () {
            echo Excel::raw(new FullReportExport, \Maatwebsite\Excel\Excel::XLSX);
        }, 'XimenaBags_Reporte_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }


    public function render()
    {
        return view('livewire.reports.export-reports');
    }
}
