<?php

if (! function_exists('money')) {
    /** Formato de pesos colombianos: $ 12.500 (o con centavos si los hay). */
    function money($value): string
    {
        $value = (float) $value;
        $decimals = fmod($value, 1) == 0.0 ? 0 : 2;

        return '$ ' . number_format($value, $decimals, ',', '.');
    }
}

if (! function_exists('status_label')) {
    function status_label(?string $status): string
    {
        return [
            'VALID' => 'Válida',
            'CANCELED' => 'Anulada',
            'ACTIVE' => 'Activo',
            'DEACTIVATE' => 'Inactivo',
        ][$status] ?? (string) $status;
    }
}
