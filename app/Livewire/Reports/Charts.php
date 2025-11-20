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
    public string $topUsersChartType = 'pie';

    public function toggleTopUsersChart()
    {
        $this->topUsersChartType = $this->topUsersChartType === 'pie' ? 'bar' : 'pie';
        $this->mount(app(ReportService::class)); // recarga la data de la chart con el nuevo tipo
    }

    public function mount(ReportService $reports)
    {
        $goldColor = 'oklch(0.63 0.12 85)'; // dorado para letras de fondo

        // --- Chart de Ingresos por mes (line) ---
        $income = $reports->getIncomeByMonth();

        // Mapear números de mes a nombres completos
    $monthNames = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    $labels = array_map(fn($monthNum) => $monthNames[(int)$monthNum] ?? $monthNum, array_keys($income));


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

        // --- Chart de Top Usuarios (Pie o Bar dinámica) ---
        $users = $reports->getTopUsers();
        $labels = $users->pluck('name');
        $data = $users->pluck('total_sales');

        $this->topUsersChart = [
            'type' => $this->topUsersChartType,
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    ['label' => 'Ventas generadas', 'data' => $data]
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
