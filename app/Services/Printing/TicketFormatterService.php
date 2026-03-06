<?php

namespace App\Services\Printing;

use App\Models\Sale;
use Illuminate\Support\Str;

class TicketFormatterService
{
    // 35mm paper is very narrow; use a compact layout to prevent clipping.
    private const LINE_WIDTH = 24;
    private const QTY_WIDTH = 3;
    private const PRODUCT_WIDTH = 12;
    private const AMOUNT_WIDTH = 9;

    /**
     * Build an ESC/POS payload array compatible with qz.print(config, data).
     *
     * @return array<int, string>
     */
    public function buildEscPosPayload(Sale $sale): array
    {
        $saleDate = $sale->sale_date?->format('Y-m-d H:i') ?? $sale->created_at?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i');
        $customerName = $this->sanitizeText($sale->customer?->name ?? 'Consumidor final');
        $sellerName = $this->sanitizeText($sale->user?->name ?? 'Caja');
        $items = $sale->saleItems;
        $separator = str_repeat('-', self::LINE_WIDTH) . "\n";

        $payload = [
            "\x1B\x40", // ESC @ - Initialize printer
            "\x1B\x61\x01", // Center align
            "\x1B\x45\x01", // Bold on
            $this->sanitizeText(Str::upper((string) config('app.name', 'MovilTech'))) . "\n",
            "\x1B\x45\x00", // Bold off
            "\x1B\x61\x00", // Left align
        ];

        $payload = [
            ...$payload,
            ...$this->buildLabelValueLines('Factura', $this->sanitizeText((string) $sale->invoice_number)),
            ...$this->buildLabelValueLines('Fecha', $saleDate),
            ...$this->buildLabelValueLines('Cliente', $customerName),
            ...$this->buildLabelValueLines('Atendido', $sellerName),
            $separator,
            $this->buildHeaderRow(),
            $separator,
        ];

        foreach ($items as $item) {
            $productName = $this->sanitizeText((string) ($item->product->name ?? 'Producto'));
            $itemRows = $this->buildItemRows(
                (int) $item->quantity,
                $productName,
                (float) $item->total_price
            );

            foreach ($itemRows as $row) {
                $payload[] = $row;
            }
        }

        $payload[] = $separator;
        $payload[] = $this->buildTotalRow('Subtotal', (float) $sale->subtotal);

        if ((float) $sale->tax_amount > 0) {
            $payload[] = $this->buildTotalRow('Impuestos', (float) $sale->tax_amount);
        }

        if ((float) $sale->discount_amount > 0) {
            $payload[] = $this->buildTotalRow('Descuento', (float) ($sale->discount_amount * -1));
        }

        $payload[] = "\x1B\x45\x01"; // Bold on
        $payload[] = $this->buildTotalRow('TOTAL', (float) $sale->total);
        $payload[] = "\x1B\x45\x00"; // Bold off
        $payload[] = $separator;
        $payload[] = "\x1B\x61\x01"; // Center align
        $payload[] = $this->sanitizeText('Gracias por su compra!') . "\n";
        $payload[] = $this->sanitizeText('Lo esperamos pronto') . "\n";
        $payload[] = "\x1B\x64\x03"; // Feed 3 lines
        $payload[] = "\x1D\x56\x41\x10"; // Partial cut

        return $payload;
    }

    private function buildHeaderRow(): string
    {
        return $this->padRight('Cant', self::QTY_WIDTH)
            . $this->padRight('Producto', self::PRODUCT_WIDTH)
            . $this->padLeft('Subtotal', self::AMOUNT_WIDTH)
            . "\n";
    }

    /**
     * @return array<int, string>
     */
    private function buildItemRows(int $quantity, string $productName, float $subtotal): array
    {
        $rows = [];
        $wrappedProduct = $this->wrapText($productName, self::PRODUCT_WIDTH);
        if (empty($wrappedProduct)) {
            $wrappedProduct = ['Producto'];
        }

        $rows[] = $this->padRight((string) $quantity, self::QTY_WIDTH)
            . $this->padRight($wrappedProduct[0], self::PRODUCT_WIDTH)
            . $this->padLeft($this->formatMoney($subtotal), self::AMOUNT_WIDTH)
            . "\n";

        for ($i = 1; $i < count($wrappedProduct); $i++) {
            $rows[] = $this->padRight('', self::QTY_WIDTH)
                . $this->padRight($wrappedProduct[$i], self::PRODUCT_WIDTH)
                . $this->padLeft('', self::AMOUNT_WIDTH)
                . "\n";
        }

        return $rows;
    }

    private function buildTotalRow(string $label, float $amount): string
    {
        $cleanLabel = $this->sanitizeText($label);
        $labelWidth = self::QTY_WIDTH + self::PRODUCT_WIDTH;

        return $this->padRight($cleanLabel, $labelWidth)
            . $this->padLeft($this->formatMoney($amount), self::AMOUNT_WIDTH)
            . "\n";
    }

    /**
     * @return array<int, string>
     */
    private function buildLabelValueLines(string $label, string $value): array
    {
        $cleanLabel = $this->sanitizeText($label);
        $cleanValue = $this->sanitizeText($value);
        $prefix = $cleanLabel . ': ';
        $valueWidth = max(8, self::LINE_WIDTH - strlen($prefix));
        $wrappedValue = $this->wrapText($cleanValue, $valueWidth);

        if (empty($wrappedValue)) {
            $wrappedValue = ['-'];
        }

        $lines = [];
        $lines[] = $prefix . $wrappedValue[0] . "\n";
        $indent = str_repeat(' ', strlen($prefix));

        for ($i = 1; $i < count($wrappedValue); $i++) {
            $lines[] = $indent . $wrappedValue[$i] . "\n";
        }

        return $lines;
    }

    /**
     * @return array<int, string>
     */
    private function wrapText(string $text, int $width): array
    {
        $cleanText = trim($text);
        if ($cleanText === '') {
            return [];
        }

        return explode("\n", wordwrap($cleanText, $width, "\n", true));
    }

    private function sanitizeText(string $value): string
    {
        $ascii = (string) Str::of($value)
            ->ascii()
            ->replace(["\r\n", "\r", "\n"], ' ')
            ->trim();

        return $ascii;
    }

    private function formatMoney(float $amount): string
    {
        return '$' . number_format($amount, 2, '.', ',');
    }

    private function padRight(string $value, int $length): string
    {
        return str_pad($value, $length);
    }

    private function padLeft(string $value, int $length): string
    {
        return str_pad($value, $length, ' ', STR_PAD_LEFT);
    }
}
