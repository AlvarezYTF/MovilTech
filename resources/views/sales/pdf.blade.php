<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .company-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-details {
            flex: 1;
        }
        
        .customer-info {
            flex: 1;
            text-align: right;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }
        
        .info-row {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #4b5563;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border: 1px solid #d1d5db;
        }
        
        .items-table td {
            padding: 10px;
            border: 1px solid #d1d5db;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals-section {
            margin-top: 20px;
            margin-left: auto;
            width: 300px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
        }
        
        .total-row.final {
            border-top: 2px solid #374151;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 10px;
        }
        
        .notes-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #d1d5db;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">MovilTech</div>
        <div class="company-subtitle">Sistema de Gestión de Ventas</div>
        <div style="font-size: 12px; color: #6b7280;">
            Teléfono: (555) 123-4567 | Email: info@moviltech.com
        </div>
    </div>

    <!-- Invoice Information -->
    <div class="invoice-info">
        <div class="invoice-details">
            <div class="section-title">Información de la Factura</div>
            <div class="info-row">
                <span class="info-label">Número de Factura:</span> {{ $sale->invoice_number }}
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Venta:</span> {{ $sale->sale_date->format('d/m/Y') }}
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Emisión:</span> {{ $sale->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="info-row">
                <span class="info-label">Estado:</span> 
                <span class="status-badge status-{{ $sale->status }}">
                    {{ ucfirst($sale->status) }}
                </span>
            </div>
        </div>
        
        <div class="customer-info">
            <div class="section-title">Información del Cliente</div>
            <div class="info-row">
                <span class="info-label">Nombre:</span> {{ $sale->customer->name }}
            </div>
            @if($sale->customer->email)
            <div class="info-row">
                <span class="info-label">Email:</span> {{ $sale->customer->email }}
            </div>
            @endif
            @if($sale->customer->phone)
            <div class="info-row">
                <span class="info-label">Teléfono:</span> {{ $sale->customer->phone }}
            </div>
            @endif
            @if($sale->customer->address)
            <div class="info-row">
                <span class="info-label">Dirección:</span> {{ $sale->customer->address }}
            </div>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <div class="section-title">Productos Vendidos</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 40%;">Producto</th>
                <th style="width: 15%;" class="text-center">Cantidad</th>
                <th style="width: 20%;" class="text-right">Precio Unitario</th>
                <th style="width: 25%;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
            <tr>
                <td>
                    <strong>{{ $item->product->name }}</strong><br>
                    <small style="color: #6b7280;">SKU: {{ $item->product->sku }}</small>
                    @if($item->product->category)
                        <br><small style="color: #6b7280;">Categoría: {{ $item->product->category->name }}</small>
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">${{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($sale->subtotal, 2) }}</span>
        </div>
        
        @if($sale->tax_amount > 0)
        <div class="total-row">
            <span>Impuestos:</span>
            <span>${{ number_format($sale->tax_amount, 2) }}</span>
        </div>
        @endif
        
        @if($sale->discount_amount > 0)
        <div class="total-row">
            <span>Descuento:</span>
            <span>-${{ number_format($sale->discount_amount, 2) }}</span>
        </div>
        @endif
        
        <div class="total-row final">
            <span>TOTAL:</span>
            <span>${{ number_format($sale->total, 2) }}</span>
        </div>
    </div>

    <!-- Notes -->
    @if($sale->notes)
    <div class="notes-section">
        <div class="section-title">Notas Adicionales</div>
        <div style="background-color: #f9fafb; padding: 15px; border-radius: 4px; border-left: 4px solid #3b82f6;">
            {{ $sale->notes }}
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div>Factura generada el {{ now()->format('d/m/Y H:i') }} por {{ $sale->user->name }}</div>
        <div style="margin-top: 10px;">
            <strong>MovilTech</strong> - Sistema de Gestión de Ventas<br>
            Este documento es una factura oficial generada electrónicamente.
        </div>
    </div>
</body>
</html>
