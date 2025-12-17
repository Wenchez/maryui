<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Services\ReportService;

class Charts extends Component
{
    public $from_date;
    public $to_date;

    public array $incomeByMonthChart = [];
    public array $topUsersChart = [];
    public string $topUsersChartType = 'pie';

    protected $listeners = ['report-filters-updated' => 'applyFilters'];

    public function mount(ReportService $reports)
    {
        $this->loadCharts($reports);
    }

    public function applyFilters($filters)
    {
        $this->from_date = $filters['from_date'];
        $this->to_date   = $filters['to_date'];

        $this->loadCharts(app(ReportService::class));
    }

    public function toggleTopUsersChart()
    {
        $this->topUsersChartType = $this->topUsersChartType === 'pie' ? 'bar' : 'pie';
        $this->loadCharts(app(ReportService::class));
    }

    protected function loadCharts(ReportService $reports)
    {
        $goldColor = 'oklch(0.63 0.12 85)';

        /* ========= INGRESOS POR MES ========= */
        $income = $reports->getIncomeByMonth($this->from_date, $this->to_date);

        $monthNames = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo',
            4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre',
            10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        $labels = array_map(
            fn ($month) => $monthNames[(int)$month] ?? $month,
            array_keys($income)
        );

        $this->incomeByMonthChart = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    ['label' => 'Ingresos', 'data' => array_values($income)]
                ],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => true,
                'plugins' => [
                    'legend' => [
                        'labels' => [
                            'color' => $goldColor,
                            'font' => ['weight' => 'bold'],
                        ],
                    ],
                    'tooltip' => [
                        'titleColor' => $goldColor,
                        'bodyColor' => $goldColor,
                    ],
                ],
                'scales' => [
                    'x' => [
                        'ticks' => ['color' => $goldColor],
                        'grid' => [
                            'color' => $goldColor . '55',
                            'borderColor' => $goldColor,
                        ],
                    ],
                    'y' => [
                        'ticks' => ['color' => $goldColor],
                        'grid' => [
                            'color' => $goldColor . '55',
                            'borderColor' => $goldColor,
                        ],
                    ],
                ],
            ],
        ];

        /* ========= TOP USUARIOS ========= */
        $users = $reports->getTopUsers($this->from_date, $this->to_date);

        $this->topUsersChart = [
            'type' => $this->topUsersChartType,
            'data' => [
                'labels' => $users->pluck('name'),
                'datasets' => [
                    ['label' => 'Ventas generadas', 'data' => $users->pluck('total_sales')]
                ],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'plugins' => [
                    'legend' => [
                        'labels' => [
                            'color' => $goldColor,
                            'font' => ['weight' => 'bold'],
                        ],
                    ],
                    'tooltip' => [
                        'titleColor' => $goldColor,
                        'bodyColor' => $goldColor,
                    ],
                ],
                'scales' => $this->topUsersChartType === 'bar' ? [
                    'x' => [
                        'ticks' => ['color' => $goldColor],
                        'grid' => [
                            'color' => $goldColor . '55',
                            'borderColor' => $goldColor,
                        ],
                    ],
                    'y' => [
                        'ticks' => ['color' => $goldColor],
                        'grid' => [
                            'color' => $goldColor . '55',
                            'borderColor' => $goldColor,
                        ],
                    ],
                ] : [],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.reports.charts');
    }
}