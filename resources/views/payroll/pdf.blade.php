<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulletin de Paie - {{ $user->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; }
        .section { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .total { font-weight: bold; background: #f4f4f4; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BULLETIN DE PAIE</h1>
        <p>Période : {{ $month }}</p>
    </div>

    <div class="section">
        <strong>Employeur :</strong> {{ config('app.name') }} <br>
        <strong>Employé :</strong> {{ $user->name }} <br>
        <strong>Email :</strong> {{ $user->email }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salaire de base</td>
                <td>{{ number_format($amount, 0, ',', ' ') }} FCFA</td>
            </tr>
            </tbody>
        <tfoot>
            <tr class="total">
                <td>NET À PAYER</td>
                <td>{{ number_format($amount, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>