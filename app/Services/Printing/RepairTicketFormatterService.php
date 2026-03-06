<?php

namespace App\Services\Printing;

use App\Models\Repair;
use Illuminate\Support\Str;

class RepairTicketFormatterService
{
    private const LINE_WIDTH = 24;
    private const AMOUNT_WIDTH = 10;

    /**
     * Build an ESC/POS payload array compatible with qz.print(config, data).
     *
     * @return array<int, string>
     */
    public function buildEscPosPayload(Repair $repair): array
    {
        $repairDate = $repair->repair_date?->format('Y-m-d') ?? $repair->created_at?->format('Y-m-d') ?? now()->format('Y-m-d');
        $createdAt = $repair->created_at?->format('Y-m-d H:i') ?? now()->format('Y-m-d H:i');
        $customerName = $this->sanitizeText($repair->customer?->name ?? 'Cliente');
        $phoneModel = $this->sanitizeText((string) $repair->phone_model);
        $imei = $this->sanitizeText((string) ($repair->imei ?: 'N/A'));
        $status = $this->sanitizeText($this->statusLabel((string) $repair->repair_status));
        $issue = $this->sanitizeText((string) $repair->issue_description);
        $notes = $this->sanitizeText((string) ($repair->notes ?: 'Sin notas'));
        $separator = str_repeat('-', self::LINE_WIDTH) . "\n";

        $payload = [
            "\x1B\x40", // ESC @ - Initialize printer
            "\x1B\x61\x01", // Center align
            "\x1B\x45\x01", // Bold on
            $this->sanitizeText(Str::upper((string) config('app.name', 'MovilTech'))) . "\n",
            "ORDEN REPARACION\n",
            "\x1B\x45\x00", // Bold off
            "\x1B\x61\x00", // Left align
            $separator,
        ];

        $payload = [
            ...$payload,
            ...$this->buildLabelValueLines('Orden', '#' . (string) $repair->id),
            ...$this->buildLabelValueLines('Fecha rep', $repairDate),
            ...$this->buildLabelValueLines('Creado', $createdAt),
            ...$this->buildLabelValueLines('Estado', $status),
            ...$this->buildLabelValueLines('Cliente', $customerName),
            ...$this->buildLabelValueLines('Equipo', $phoneModel),
            ...$this->buildLabelValueLines('IMEI', $imei),
            $separator,
            $this->sanitizeText('Falla:') . "\n",
            ...$this->buildWrappedLines($issue),
            $separator,
            $this->sanitizeText('Notas:') . "\n",
            ...$this->buildWrappedLines($notes),
            $separator,
            "\x1B\x45\x01", // Bold on
            $this->buildTotalRow('TOTAL', (float) $repair->repair_cost),
            "\x1B\x45\x00", // Bold off
            $separator,
            "\x1B\x61\x01", // Center align
            $this->sanitizeText('Gracias por preferirnos!') . "\n",
            $this->sanitizeText('Conserve este ticket') . "\n",
            "\x1B\x64\x03", // Feed 3 lines
            "\x1D\x56\x41\x10", // Partial cut
        ];

        return $payload;
    }

    private function buildTotalRow(string $label, float $amount): string
    {
        $labelWidth = self::LINE_WIDTH - self::AMOUNT_WIDTH;

        return $this->padRight($this->sanitizeText($label), $labelWidth)
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
    private function buildWrappedLines(string $value): array
    {
        $wrapped = $this->wrapText($value, self::LINE_WIDTH);

        if (empty($wrapped)) {
            return ["-\n"];
        }

        return array_map(static fn (string $line): string => $line . "\n", $wrapped);
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

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Pendiente',
            'in_progress' => 'En progreso',
            'completed' => 'Completado',
            'delivered' => 'Entregado',
            default => 'Desconocido',
        };
    }
}
