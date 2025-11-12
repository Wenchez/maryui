<?php

namespace App\Livewire;

use Illuminate\Support\Arr;
use Livewire\Component;

class Dashboard extends Component
{
    public array $categoryChart = [
        'type' => 'pie',
        'data' => [
            'labels' => ['Bolsas', 'Accesorios', 'Ropa'],
            'datasets' => [
                [
                    'label' => 'Ventas por Categoría',
                    'data' => [45, 32, 23],
                    'backgroundColor' => ['#059669', '#3b82f6', '#f59e0b'],
                    'borderColor' => ['#047857', '#1d4ed8', '#d97706'],
                ]
            ]
        ]
    ];

    public function render()
    {
        return view('livewire.dashboard');
    }

    public function randomizeChart()
    {
        Arr::set($this->categoryChart, 'data.datasets.0.data', [
            fake()->randomNumber(2),
            fake()->randomNumber(2),
            fake()->randomNumber(2)
        ]);
    }

    public function switchChartType()
    {
        $type = $this->categoryChart['type'] == 'bar' ? 'pie' : 'bar';
        Arr::set($this->categoryChart, 'type', $type);
    }
}
