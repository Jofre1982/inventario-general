<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        body { margin: 0; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        h2 { font-size: 15px; margin: 0; }
        .muted { color: #666; }
        .header { width: 100%; border-bottom: 2px solid #444; padding-bottom: 8px; margin-bottom: 14px; }
        .header td { vertical-align: top; }
        .doc { text-align: right; }
        .doc .number { font-size: 20px; font-weight: bold; }
        .info { width: 100%; margin-bottom: 14px; }
        .info td { width: 50%; vertical-align: top; padding: 6px 8px; background: #f2f2f2; }
        table.items { width: 100%; border-collapse: collapse; }
        table.items th { background: #444; color: #fff; padding: 6px; text-align: left; }
        table.items td { padding: 6px; border-bottom: 1px solid #ddd; }
        .r { text-align: right; }
        .totals td { border: none; padding: 4px 6px; }
        .totals .grand td { font-size: 14px; font-weight: bold; border-top: 2px solid #444; }
        .canceled { color: #c00; font-weight: bold; font-size: 14px; text-align: center; border: 2px solid #c00; padding: 4px; margin-bottom: 10px; }
        .footer { margin-top: 30px; text-align: center; }
        img.logo { max-height: 60px; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td>
                @if ($business->logo && file_exists(public_path('image/' . $business->logo)))
                    <img class="logo" src="{{ public_path('image/' . $business->logo) }}"><br>
                @endif
                <h1>{{ $business->name }}</h1>
                @if ($business->nit)<div>NIT {{ $business->nit }}</div>@endif
                @if ($business->address)<div class="muted">{{ $business->address }}</div>@endif
                @if ($business->mail)<div class="muted">{{ $business->mail }}</div>@endif
            </td>
            <td class="doc">
                <h2>{{ $title }}</h2>
                <div class="number">N.º {{ $number }}</div>
                <div class="muted">{{ $date->format('d/m/Y h:i a') }}</div>
            </td>
        </tr>
    </table>
    @yield('body')
    <div class="footer muted">Generado el {{ now()->format('d/m/Y h:i a') }}</div>
</body>
</html>
