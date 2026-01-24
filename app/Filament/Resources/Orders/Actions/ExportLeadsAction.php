<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Enums\OrderStatus;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Database\Eloquent\Collection;

class ExportLeadsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'export_leads';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Exportar Leads')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->color('success')
            ->action(function () {
                return $this->exportToExcel();
            });
    }

    protected function exportToExcel(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir cabeçalhos
        $headers = [
            'Código',
            'Status',
            'Nome',
            'E-mail',
            'Telefone',
            'Instagram',
            'Pacote',
            'Valor',
            'Criado em',
            'Contatado?',
            'Contatado em',
            'Contatado por',
            'Notas de Contato'
        ];

        // Aplicar estilo ao cabeçalho
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Buscar pedidos pendentes de pagamento
        $orders = \App\Models\Order::where('status', OrderStatus::AwaitingPayment)
            ->orderBy('created_at', 'desc')
            ->get();

        // Preencher dados
        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $row, $order->public_code);
            $sheet->setCellValue('B' . $row, $order->status->label());
            $sheet->setCellValue('C' . $row, $order->customer_name);
            $sheet->setCellValue('D' . $row, $order->customer_email);
            $sheet->setCellValue('E' . $row, $order->customer_phone);
            $sheet->setCellValue('F' . $row, $order->instagram_username ? '@' . $order->instagram_username : '');
            $sheet->setCellValue('G' . $row, $order->package->name ?? '');
            $sheet->setCellValue('H' . $row, 'R$ ' . number_format($order->amount / 100, 2, ',', '.'));
            $sheet->setCellValue('I' . $row, $order->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('J' . $row, $order->contacted_at ? 'Sim' : 'Não');
            $sheet->setCellValue('K' . $row, $order->contacted_at ? $order->contacted_at->format('d/m/Y H:i') : '');
            $sheet->setCellValue('L' . $row, $order->contacted_by ?? '');
            $sheet->setCellValue('M' . $row, $order->contact_notes ?? '');

            $row++;
        }

        // Ajustar largura das colunas
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Criar o arquivo Excel e fazer download
        $writer = new Xlsx($spreadsheet);

        $filename = 'leads_aguardando_pagamento_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
