<?php

namespace App\View\Components\ControlClinico;

use App\Models\ProcedimientoClinico;
use Illuminate\View\Component;
use Illuminate\View\View;

class AlertaVacunas extends Component
{
    public int $porVencer;
    public int $vencidas;

    public function __construct(?int $dias = null)
    {
        $this->porVencer = ProcedimientoClinico::vacunasPorVencer($dias)->count();
        $this->vencidas = ProcedimientoClinico::vacunasVencidas()->count();
    }

    public function render(): View
    {
        return view('components.control-clinico.alerta-vacunas');
    }
}
