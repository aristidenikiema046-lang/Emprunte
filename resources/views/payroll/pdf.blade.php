<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin de Paie - {{ $user->name }}</title>
    <style>
        /* Base & Responsive */
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #333; 
            line-height: 1.5; 
            font-size: 11pt; 
            margin: 0; 
            padding: 0; 
            background-color: #fff;
        }
        
        .container { 
            width: 90%; 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px; 
        }

        /* Header Responsive */
        .header { 
            border-bottom: 2px solid #2c3e50; 
            padding-bottom: 10px; 
            margin-bottom: 30px; 
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            flex-wrap: wrap;
        }
        .company-name { font-size: 18pt; font-weight: bold; color: #2c3e50; text-transform: uppercase; }
        .title { font-size: 14pt; color: #7f8c8d; text-align: right; flex-grow: 1; }

        /* Infos Sections - Tableaux fluides */
        .info-table { width: 100%; margin-bottom: 40px; border-collapse: collapse; }
        .info-table td { width: 50%; vertical-align: top; padding: 5px; }
        .label { font-weight: bold; color: #2c3e50; }

        /* Main Table */
        .payroll-table { width: 100%; border-collapse: collapse; margin-bottom: 50px; table-layout: fixed; }
        .payroll-table th { background-color: #f8f9fa; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; padding: 12px; text-align: left; font-size: 10pt; }
        .payroll-table td { border-bottom: 1px solid #eee; padding: 12px; font-size: 10pt; word-wrap: break-word; }
        
        /* Totals - Adaptable */
        .totals-section { 
            width: 100%; 
            max-width: 250px; 
            margin-left: auto; 
            border: 1px solid #2c3e50; 
        }
        .total-row { padding: 10px; background: #2c3e50; color: white; text-align: center; }
        .total-amount { font-size: 14pt; font-weight: bold; }

        /* Footer */
        .footer { 
            text-align: center; 
            font-size: 8pt; 
            color: #95a5a6; 
            border-top: 1px solid #eee; 
            padding-top: 10px; 
            margin-top: 50px;
        }

        /* Media Query pour les petits écrans */
        @media screen and (max-width: 600px) {
            .header { flex-direction: column; text-align: center; }
            .title { text-align: center; margin-top: 10px; width: 100%; }
            .info-table td { display: block; width: 100%; text-align: left !important; }
            .totals-section { margin-right: auto; }
            .payroll-table { font-size: 9pt; }
            .payroll-table th, .payroll-table td { padding: 8px 4px; }
        }

        /* Conservation du format PDF */
        @media print {
            .container { width: 100%; padding: 0; }
            .footer { position: fixed; bottom: 30px; width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-name">Ya-consulting</div>
            <div class="title">BULLETIN DE PAIE</div>
        </div>

        <table class="info-table">
            <tr>
                <td>
                    <div class="label">EMPLOYEUR</div>
                    <div>Ya-consulting</div>
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

        <div style="overflow-x: auto;">
            <table class="payroll-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Désignation</th>
                        <th style="text-align: center; width: 20%;">Nombre / Base</th>
                        <th style="text-align: right; width: 20%;">Taux</th>
                        <th style="text-align: right; width: 20%;">Montant (FCFA)</th>
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
                    <tr style="height: 100px;"> 
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

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