<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Services\ReportService;

class Charts extends Component
{
    public array $incomeByMonthChart = [];
    public array $salesByCategoryChart = [];
    public array $topUsersChart = [];
    public array $topProductsChart = [];

    public function mount(ReportService $reports)
    {
        $income = $reports->getIncomeByMonth();
        $this->incomeByMonthChart = [
            'type' => 'line',
            'data' => [
                'labels' => array_keys($income),
                'datasets' => [['label' => 'Ingresos', 'data' => array_values($income)]]
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ]
        ];

        $users = $reports->getTopUsers();
        $this->topUsersChart = [
            'type' => 'pie',
            'data' => [
                'labels' => $users->pluck('name'),
                'datasets' => [['label' => 'Ventas generadas', 'data' => $users->pluck('total_income_generated')]]
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ]
        ];
    }

    public function render()
    {
        return view('livewire.reports.charts');
    }
}
