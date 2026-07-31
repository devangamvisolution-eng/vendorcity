<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GeneralEnquiriesExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $enquiries;
    protected $source_leads;
    protected $subservice_summary;
    protected $source_summary;
    protected $status_summary;

    public function __construct($enquiries, $source_leads, $subservice_summary, $source_summary, $status_summary)
    {
        $this->enquiries = $enquiries;
        $this->source_leads = $source_leads;
        $this->subservice_summary = $subservice_summary;
        $this->source_summary = $source_summary;
        $this->status_summary = $status_summary;
    }

    public function view(): View
    {
        return view('admin.general_enquiries.excel', [
            'enquiries' => $this->enquiries,
            'source_leads' => $this->source_leads,
            'subservice_summary' => $this->subservice_summary,
            'source_summary' => $this->source_summary,
            'status_summary' => $this->status_summary,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
