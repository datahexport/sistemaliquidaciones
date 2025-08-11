<?php

namespace App\Exports;

use App\Models\Balancemasacuatro;
use App\Models\Balancemasatres;
use App\Models\Ventacomercial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaExport implements  FromCollection, WithHeadings, ShouldAutoSize
{
    protected $temporada, $type;

    public function __construct($temporada,$type)
    {
        $this->temporada = $temporada;
        $this->type= $type;
    }

    public function collection()
    {
        if ($this->type=="detalleliquidacion") {
            return Balancemasacuatro::where('temporada_id', $this->temporada)->get([
                'Sales_date',
                'Arrival_Date',
                'N_Pallet',
                'Variedad',
                'Etiqueta',
                'Calibre_y_Color',
                'Cajas',
                'Precio_Venta_Yen',
                'Total_Venta',
                'Contenedor',
                'PESO_TOTAL',
                'CAJAS_DESPACHADAS',
                'DIF',
                'PESO_CAJA',
                'COLOR',
                'SIG_COLOR',
                'CALIBRE',
                'TC',
                'VENTA_USD',
                'COMISION',
                'FLETE',
                'OTROS_GASTOS',
                'Apoyo_Liquidaciones',
                'LIQ_CLIENTE',
                'PROMOCION_ASOEX',
                'SEGURO_CARGA',
                'LIQ_PRODUCTOR',
                'RETORNO_PRODUCTOR_ESTIMADO',
                'NAVE',
                'CLIENTE',
                'PAIS',
                'MERCADO',
                'UNIR_CADE',
                'semana',
            ]);
        } elseif($this->type=="basedespacho") {
               return Balancemasatres::where('temporada_id', $this->temporada)
                ->limit(5)
                ->get([
                    'Temporada', 'Estado', 'Packing', 'Folio', 'N_GuiaSII_Rec', 'N_lote', 'Peido', 'Fecha_Emb', 'Cliente',
                    'CSG', 'Csg_Rot', 'Nombre_Huerto', 'Nombre_CSG_Rot', 'Nombre_Productor', 'Etiqueta', 'C_Envase', 'Envase',
                    'Especie', 'Variedad_Real', 'Variedad_Rot', 'Categoria', 'Calidad', 'Calibre', 'Cajas_INICIAL',
                    'Dif_Cajas', 'Cajas', 'Cajas_Pallet', 'Kilos_INICIAL', 'Dif_Kilos_proc', 'Kilos_prod', 'Kilos_emb',
                    'Proceso', 'Tipo_Pallet', 'Base_Pallet', 'Altura', 'C_Packing', 'C_Variedad_real', 'C_Variedad_Rot',
                    'C_Categoria', 'C_Cliente', 'C_Etiqueta', 'C_Especie', 'C_Recibidor', 'C_Mercado', 'Nave', 'Fecha_Salida',
                    'Exportador', 'Mercado', 'Despacho', 'Folio_Sag', 'Fecha_despacho', 'Recibidor_comprador',
                    'Numero_Inspeccion', 'Fecha_Inspeccion', 'Estado_Inspeccion', 'Guia_sii', 'Contenedor', 'Peso_Neto',
                    'Peso_Bruto', 'Fecha_Digitacion', 'N_Reserva', 'Fecha_Reserva', 'Planta', 'planta_despacho', 'liquidado',
                    'liq_real', 'liquidacion_ajuste', 'venta', 'retorno_productor', 'kg_liq', 'fob2', 'npk', 'fob_x_caja',
                    'ajuste_kilos', 'ajuste_final', 'semana', 'variedad_real2', 'calibre_real', 'productor_real',
                    'busqueda_proceso', 'observacion', 'cliente_china', 'transporte', 'mercado2', 'productor_facturacion',
                    'csg_fact', 'obs', 'unir_cad', 'caja_desp', 'comision', 'otros_costos', 'materiales', 'proceso2', 'tipo',
                ]);
        }elseif($this->type=="ventacomercial") {
               return Ventacomercial::where('temporada_id', $this->temporada)
                 ->get([
                    'fecha',
                    'cliente',
                    'cantidad_kilos',
                    'cajas',
                    'tipo',
                    'descripcion',
                    'precio_unitario',
                    'total_iva_incluido',
                    'condicion_de_pago',
                    'neto',
                    'iva',
                    'tc',
                    'venta_usd',
                    'semana',
                ]);
        }else{
                return Balancemasacuatro::where('temporada_id', $this->temporada)->get([
                'Sales_date',
                'Arrival_Date',
                'N_Pallet',
                'Variedad',
                'Etiqueta',
                'Calibre_y_Color',
                'Cajas',
                'Precio_Venta_Yen',
                'Total_Venta',
                'Contenedor',
                'PESO_TOTAL',
                'CAJAS_DESPACHADAS',
                'DIF',
                'PESO_CAJA',
                'COLOR',
                'SIG_COLOR',
                'CALIBRE',
                'TC',
                'VENTA_USD',
                'COMISION',
                'FLETE',
                'OTROS_GASTOS',
                'Apoyo_Liquidaciones',
                'LIQ_CLIENTE',
                'PROMOCION_ASOEX',
                'SEGURO_CARGA',
                'LIQ_PRODUCTOR',
                'RETORNO_PRODUCTOR_ESTIMADO',
                'NAVE',
                'CLIENTE',
                'PAIS',
                'MERCADO',
                'UNIR_CADE',
                'semana',
            ]);
        }
        
       
    }

    public function headings(): array
    {   if ($this->type=="detalleliquidacion") {
            return [
                'Sales Date',
                'Arrival Date',
                'N° Pallet',
                'Variedad',
                'Etiqueta',
                'Calibre y Color',
                'Cajas',
                'Precio Venta Yen',
                'Total Venta',
                'Contenedor',
                'Peso Total',
                'Cajas Despachadas',
                'Diferencia',
                'Peso Caja',
                'Color',
                'Sig Color',
                'Calibre',
                'TC',
                'Venta USD',
                'Comisión',
                'Flete',
                'Otros Gastos',
                'Apoyo Liquidaciones',
                'Liq Cliente',
                'Promoción Asoex',
                'Seguro Carga',
                'Liq Productor',
                'Retorno Productor Estimado',
                'Nave',
                'Cliente',
                'País',
                'Mercado',
                'Unir CADE',
                'Semana',
            ];
        }elseif($this->type=="basedespacho") {
             return [
            'Temporada', 'Estado', 'Packing', 'Folio', 'N° Guía SII Rec', 'N° Lote', 'Pedido', 'Fecha Emb.',
            'Cliente', 'CSG', 'CSG Rot', 'Nombre Huerto', 'Nombre CSG Rot', 'Nombre Productor', 'Etiqueta',
            'Código Envase', 'Envase', 'Especie', 'Variedad Real', 'Variedad Rot', 'Categoría', 'Calidad', 'Calibre',
            'Cajas Inicial', 'Diferencia Cajas', 'Cajas', 'Cajas/Pallet', 'Kilos Inicial', 'Dif. Kilos Procesados',
            'Kilos Producción', 'Kilos Embarcados', 'Proceso', 'Tipo Pallet', 'Base Pallet', 'Altura', 'Código Packing',
            'Código Variedad Real', 'Código Variedad Rot', 'Código Categoría', 'Código Cliente', 'Código Etiqueta',
            'Código Especie', 'Código Recibidor', 'Código Mercado', 'Nave', 'Fecha Salida', 'Exportador', 'Mercado',
            'Despacho', 'Folio SAG', 'Fecha Despacho', 'Recibidor Comprador', 'N° Inspección', 'Fecha Inspección',
            'Estado Inspección', 'Guía SII', 'Contenedor', 'Peso Neto', 'Peso Bruto', 'Fecha Digitación', 'N° Reserva',
                'Fecha Reserva', 'Planta', 'Planta Despacho', '¿Liquidado?', 'Liquidación Real', 'Liquidación Ajuste',
                'Venta', 'Retorno Productor', 'Kilos Liquidación', 'FOB2', 'NPK', 'FOB x Caja', 'Ajuste Kilos',
                'Ajuste Final', 'Semana', 'Variedad Real 2', 'Calibre Real', 'Productor Real', 'Búsqueda Proceso',
                'Observación', 'Cliente China', 'Transporte', 'Mercado 2', 'Productor Facturación', 'CSG Fact.',
                'Observaciones', 'Unir CAD', 'Cajas Desp.', 'Comisión', 'Otros Costos', 'Materiales', 'Proceso 2', 'Tipo',
            ];
        }elseif($this->type=="ventacomercial") {
             return [
                'Fecha',
                'Cliente',
                'Cantidad Kilos',
                'Cajas',
                'Tipo',
                'Descripción',
                'Precio Unitario',
                'Total IVA Incluido',
                'Condición de Pago',
                'Neto',
                'IVA',
                'TC',
                'Venta USD',
                'Semana',
            ];
        }else{
             return [
                'Sales Date',
                'Arrival Date',
                'N° Pallet',
                'Variedad',
                'Etiqueta',
                'Calibre y Color',
                'Cajas',
                'Precio Venta Yen',
                'Total Venta',
                'Contenedor',
                'Peso Total',
                'Cajas Despachadas',
                'Diferencia',
                'Peso Caja',
                'Color',
                'Sig Color',
                'Calibre',
                'TC',
                'Venta USD',
                'Comisión',
                'Flete',
                'Otros Gastos',
                'Apoyo Liquidaciones',
                'Liq Cliente',
                'Promoción Asoex',
                'Seguro Carga',
                'Liq Productor',
                'Retorno Productor Estimado',
                'Nave',
                'Cliente',
                'País',
                'Mercado',
                'Unir CADE',
                'Semana',
            ];
        }
    }
}
