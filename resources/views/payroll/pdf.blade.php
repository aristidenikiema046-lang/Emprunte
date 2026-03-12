<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin de Paie - {{ $user->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 11pt; margin: 0; padding: 0; }
        .container { padding: 30px; }
        
        /* Header */
        .header { border-bottom: 2px solid #2c3e50; padding-bottom: 10px; margin-bottom: 30px; }
        .company-name { font-size: 18pt; font-weight: bold; color: #2c3e50; text-transform: uppercase; }
        .title { text-align: right; font-size: 14pt; color: #7f8c8d; margin-top: -30px; }

        /* Infos Sections */
        .info-table { width: 100%; margin-bottom: 40px; }
        .info-table td { width: 50%; vertical-align: top; }
        .label { font-weight: bold; color: #2c3e50; }

        /* Main Table */
        .payroll-table { width: 100%; border-collapse: collapse; margin-bottom: 50px; }
        .payroll-table th { background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; padding: 12px; text-align: left; font-size: 10pt; }
        .payroll-table td { border-bottom: 1px solid #eee; padding: 12px; font-size: 10pt; }
        
        /* Totals */
        .totals-section { width: 40%; margin-left: auto; border: 1px solid #2c3e50; }
        .total-row { padding: 10px; background: #2c3e50; color: white; text-align: center; }
        .total-amount { font-size: 14pt; font-weight: bold; }

        /* Footer */
        .footer { position: fixed; bottom: 30px; width: 100%; text-align: center; font-size: 8pt; color: #95a5a6; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">{{ config('app.name') }}</div>
            <div class="title">BULLETIN DE PAIE</div>
        </div>

        <table class="info-table">
            <tr>
                <td>
                    <div class="label">EMPLOYEUR</div>
                    <div>{{ config('app.name') }}</div>
                    <div>Siège Social, Abidjan</div>
                    <div>Contact: contact@ya-consulting.com</div>
                </td>
                <td style="text-align: right;">
                    <div class="label">SALARIÉ</div>
                    <div><strong>{{ strtoupper($user->name) }}</strong></div>
                    <div>ID: #00{{ $user->id }}</div>
                    <div>Période : {{ $month }}</div>
                    <div>Date d'édition : {{ $date }}</div>
                </td>
            </tr>
        </table>

        <table class="payroll-table">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th style="text-align: center;">Nombre / Base</th>
                    <th style="text-align: right;">Taux</th>
                    <th style="text-align: right;">Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaire de base</td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: right;">100%</td>
                    <td style="text-align: right;">{{ number_format($amount, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td>Prime de transport</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right;">-</td>
                    <td style="text-align: right;">0</td>
                </tr>
                <tr style="height: 150px;"> <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="totals-section">
            <div style="padding: 10px; text-align: center; font-weight: bold; color: #2c3e50;">
                NET À PAYER
            </div>
            <div class="total-row">
                <span class="total-amount">{{ number_format($amount, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="footer">
            Bulletin à conserver sans limitation de durée.<br>
            {{ config('app.url') }} - Généré par ManageX System
        </div>
    </div>
</body>
</html>