<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $sale->sale_reference }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .separator {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .items {
            margin: 10px 0;
        }

        .items div {
            display: flex;
            justify-content: space-between;
        }

        .footer {
            margin-top: 10px;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h2>Ximena Bags</h2>
        <p>Ticket de Venta</p>
        <p>Referencia: {{ $sale->sale_reference }}</p>
        <p>Fecha: {{ $sale->sale_date->format('d/m/Y H:i') }}</p>
    </div>

    <div class="separator"></div>

    <div class="items">
        @foreach ($sale->details as $item)
            <div>
                <span>{{ $item->product->product_name }} x{{ $item->quantity }}</span>
                {{-- Usar line_total como número --}}
                <span>${{ number_format($item->line_total, 2) }}</span>
            </div>
        @endforeach
    </div>

    <div class="separator"></div>

    <div class="text-right">
        <p>Subtotal: ${{ number_format($sale->sale_subtotal, 2) }}</p>
        <p>IVA (16%): ${{ number_format($sale->sale_tax, 2) }}</p>
        <p><strong>Total: ${{ number_format($sale->sale_total, 2) }}</strong></p>
    </div>

    <div class="footer">
        ¡Gracias por su compra!
    </div>
</body>

</html>
