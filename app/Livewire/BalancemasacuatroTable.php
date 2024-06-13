<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Balancemasacuatro;

class BalancemasacuatroTable extends DataTableComponent
{
    protected $model = Balancemasacuatro::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Sales Date", "Sales_date")
                ->sortable(),
            Column::make("Arrival Date", "Arrival_Date")
                ->sortable(),
            Column::make("N Pallet", "N_Pallet")
                ->sortable(),
            Column::make("Variedad", "Variedad")
                ->sortable(),
            Column::make("Etiqueta", "Etiqueta")
                ->sortable(),
            Column::make("Calibre y Color", "Calibre_y_Color")
                ->sortable(),
            Column::make("Cajas", "Cajas")
                ->sortable(),
            Column::make("Precio Venta Yen", "Precio_Venta_Yen")
                ->sortable(),
            Column::make("Total Venta", "Total_Venta")
                ->sortable(),
            Column::make("Contenedor", "Contenedor")
                ->sortable(),
            Column::make("Peso Total", "PESO_TOTAL")
                ->sortable(),
            Column::make("Cajas Despachadas", "CAJAS_DESPACHADAS")
                ->sortable(),
            Column::make("Dif", "DIF")
                ->sortable(),
            Column::make("Peso Caja", "PESO_CAJA")
                ->sortable(),
            Column::make("Color", "COLOR")
                ->sortable(),
            Column::make("Sig Color", "SIG_COLOR")
                ->sortable(),
            Column::make("Calibre", "CALIBRE")
                ->sortable(),
            Column::make("TC", "TC")
                ->sortable(),
            Column::make("Venta USD", "VENTA_USD")
                ->sortable(),
            Column::make("Comision", "COMISION")
                ->sortable(),
            Column::make("Flete", "FLETE")
                ->sortable(),
            Column::make("Otros Gastos", "OTROS_GASTOS")
                ->sortable(),
            Column::make("Apoyo Liquidaciones", "Apoyo_Liquidaciones")
                ->sortable(),
            Column::make("Liq Cliente", "LIQ_CLIENTE")
                ->sortable(),
            Column::make("Promocion Asoex", "PROMOCION_ASOEX")
                ->sortable(),
            Column::make("Seguro Carga", "SEGURO_CARGA")
                ->sortable(),
            Column::make("Liq Productor", "LIQ_PRODUCTOR")
                ->sortable(),
            Column::make("Retorno Productor Estimado", "RETORNO_PRODUCTOR_ESTIMADO")
                ->sortable(),
            Column::make("Nave", "NAVE")
                ->sortable(),
            Column::make("Cliente", "CLIENTE")
                ->sortable(),
            Column::make("Pais", "PAIS")
                ->sortable(),
            Column::make("Mercado", "MERCADO")
                ->sortable(),
            Column::make("Unir Cade", "UNIR_CADE")
                ->sortable(),
            Column::make("Sort", "sort")
                ->sortable(),
            Column::make("Semana", "semana")
                ->sortable(),

            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
