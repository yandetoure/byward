<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande - Byward Logistics</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #1a202c;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .email-header {
            background-color: #0b1f3f;
            padding: 24px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 20px;
            margin-top: 8px;
        }
        .badge-quote { background-color: #c8202c; color: #ffffff; }
        .badge-contact { background-color: #2b6cb0; color: #ffffff; }
        .badge-career { background-color: #2f855a; color: #ffffff; }
        
        .email-body {
            padding: 30px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 6px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .info-table td {
            padding: 8px 0;
            vertical-align: top;
        }
        .info-table td.label {
            width: 35%;
            color: #4a5568;
            font-weight: 600;
        }
        .info-table td.value {
            color: #1a202c;
        }
        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #c8202c;
            padding: 16px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 24px;
            font-style: italic;
            color: #2d3748;
        }
        .btn-container {
            text-align: center;
            margin: 28px 0 16px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #c8202c;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
            font-size: 14px;
        }
        .email-footer {
            background-color: #edf2f7;
            padding: 16px 30px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Byward Logistics</h1>
            @if($lead->type === 'quote')
                <span class="badge badge-quote">Demande de devis</span>
            @elseif($lead->type === 'career')
                <span class="badge badge-career">Candidature</span>
            @else
                <span class="badge badge-contact">Demande de contact</span>
            @endif
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="section-title">Informations du prospect</div>
            <table class="info-table">
                <tr>
                    <td class="label">Nom complet :</td>
                    <td class="value"><strong>{{ $lead->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Adresse Email :</td>
                    <td class="value"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></td>
                </tr>
                <tr>
                    <td class="label">Téléphone :</td>
                    <td class="value">{{ $lead->phone ?? 'Non renseigné' }}</td>
                </tr>
                @if($lead->company)
                <tr>
                    <td class="label">Entreprise :</td>
                    <td class="value">{{ $lead->company }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Date de réception :</td>
                    <td class="value">{{ $lead->created_at->format('d/m/Y à H:i') }}</td>
                </tr>
            </table>

            @if($lead->type === 'quote')
                <div class="section-title">Détails de la demande d'estimation / devis</div>
                <table class="info-table">
                    <tr>
                        <td class="label">Origine :</td>
                        <td class="value"><strong>{{ $lead->origin ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Destination :</td>
                        <td class="value"><strong>{{ $lead->destination ?? 'N/A' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Type de fret :</td>
                        <td class="value">{{ strtoupper($lead->shipment_type ?? 'N/A') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Poids total :</td>
                        <td class="value">{{ $lead->weight ? $lead->weight . ' kg' : 'N/A' }}</td>
                    </tr>
                    @if($lead->pickup_date)
                    <tr>
                        <td class="label">Date d'enlèvement :</td>
                        <td class="value">{{ $lead->pickup_date }}</td>
                    </tr>
                    @endif
                </table>
            @elseif($lead->type === 'career')
                <div class="section-title">Détails de la candidature</div>
                <table class="info-table">
                    <tr>
                        <td class="label">Poste souhaité :</td>
                        <td class="value"><strong>{{ $lead->position ?? 'N/A' }}</strong></td>
                    </tr>
                    @if($lead->resume_path)
                    <tr>
                        <td class="label">CV Joint :</td>
                        <td class="value">Fichier enregistré dans l'admin</td>
                    </tr>
                    @endif
                </table>
            @endif

            @if($lead->message)
                <div class="section-title">Message du prospect</div>
                <div class="message-box">
                    "{!! nl2br(e($lead->message)) !!}"
                </div>
            @endif

            <div class="btn-container">
                <a href="mailto:{{ $lead->email }}" class="btn">Répondre directement par email</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            Cet email a été envoyé automatiquement depuis le système Byward Logistics.<br>
            &copy; {{ date('Y') }} Byward Logistics. Tous droits réservés.
        </div>
    </div>
</body>
</html>
