<!DOCTYPE html>
<html lang="fr" class="light-style layout-wide" dir="ltr" data-theme="theme-default"
    data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $boutique->config_type }} | {{ $boutique->nom_boutique ?? 'Model Itech' }}</title>
    <meta name="description" content="" />
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .invoice-print {
            flex: 1;
            padding: 1.5rem;
            max-width: 21cm;
            margin: auto;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h4 {
            margin: 0;
        }

        p {
            margin: 0.3rem 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #e0e0e0;
        }

        th {
            background-color: #46d8d5;
            color: white;
            font-weight: bold;
        }

        .table-light {
            background-color: #f5f5f5;
        }

        .table-responsive {
            margin-bottom: 1rem;
        }

        .total-table {
            width: 40%;
            border-collapse: collapse;
            margin-left: auto;
            border: 2px solid #46d8d5;
            border-radius: 8px;
            overflow: hidden;
        }

        .total-table td {
            padding: 12px;
            text-align: left;
            border: none;
        }

        .total-table td:first-child {
            font-weight: bold;
            background-color: #f0fafa;
        }

        .total-table tr:last-child td {
            background-color: #46d8d5;
            color: white;
            font-weight: bold;
            font-size: 1.1em;
        }

        .note {
            font-size: 1rem;
            margin-top: 20px;
            padding: 15px;
            background-color: #f0fafa;
            border-left: 4px solid #46d8d5;
            border-radius: 4px;
        }

        .text-center {
            text-align: center;
        }

        .text-client {
            margin-top: 0;
        }

        .text-soscite {
            margin-top: 0;
        }

        .text-muted {
            color: #6c757d;
        }

        .footer {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            text-align: center;
            gap: 1rem;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 1000;
            background-color: #46d8d5;
            color: white;
            font-weight: 500;
        }

        .footer span {
            margin: 0;
            font-size: 0.9rem;
        }

        .invoice-title {
            position: fixed;
            top: 1rem;
            right: 1rem;
            background-color: #46d8d5;
            color: white;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .ql-tooltip {
            display: none;
        }

        .ql-hidden {
            display: none;
        }

        .signature-box {
            margin: 0%;
            position: relative;
            height: 80px;
            border-bottom: 2px dashed #46d8d5;
        }

        .signature_container {
            width: 250px;
            margin-left: auto;
            margin-top: 15px;
            border-radius: 8px;
            padding: 15px;
            border: 2px solid #46d8d5;
            background-color: #f0fafa;
        }

        #client-signature {
            max-width: 100%;
            max-height: 170px;
            object-fit: contain;
        }

        .text-nowrap {
            white-space: nowrap;
        }

        .badag {
            display: inline-block;
            background-color: #46d8d5;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            text-align: center;
            line-height: 24px;
            margin-right: 8px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .header-decor {
            height: 8px;
            background: linear-gradient(90deg, #46d8d5, #3bc4c1);
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .company-info {
            background-color: #f0fafa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #46d8d5;
            width: 48%;
            float: left;
        }

        .client-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-right: 4px solid #46d8d5;
            width: 48%;
            float: right;
        }

        .clearfix {
            clear: both;
        }

        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, #46d8d5, transparent);
            margin: 25px 0;
        }

        .remise-text {
            color: #dc3545;
            font-size: 0.85em;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .product-table th {
            background-color: #46d8d5;
            color: white;
            padding: 12px 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .product-table td {
            padding: 10px 8px;
            border: 1px solid #e0e0e0;
            vertical-align: top;
        }

        .price-cell {
            text-align: center;
            white-space: nowrap;
        }

        .remise-row td {
            color: #dc3545;
            font-style: italic;
        }

        .total-section {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .final-total {
            background-color: #46d8d5;
            color: white;
            font-weight: bold;
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }



        .info-separator {
            background-color: #46d8d5;
            flex-shrink: 0;
            opacity: 0.6;
        }

        .info-separator {
            background-color: #46d8d5;
            margin: 0 10px;
            flex-shrink: 0;
        }

        .info-item {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="invoice-print p-5">
        <div class="invoice-title">Devis N° : {{ $demande->numero_devis ?? 'Non spécifié' }}</div>

        <div class="header-decor"></div>

        <!-- Informations société et client sur la même ligne -->
        <div class="info-container">
            <div class="company-info">
                <p><strong
                        style="color: #46d8d5; font-size: 1.2em;">{{ $boutique->nom_boutique ?? 'Model Itech' }}</strong>
                </p>
                @if ($boutique->adresse && is_array($boutique->adresse) && !empty(array_filter($boutique->adresse, 'is_string')))
                    <p>{{ implode(', ', array_filter($boutique->adresse, 'is_string')) }}</p>
                @elseif($boutique->adresse && is_string($boutique->adresse) && trim($boutique->adresse) !== '')
                    <p>{{ $boutique->adresse }}</p>
                @endif
                @if (($boutique->city ?? '') || ($boutique->code_postal ?? ''))
                    <p>{{ $boutique->city ?? '' }} {{ $boutique->code_postal ?? '' }}</p>
                @endif
                @if ($boutique->telephone ?? '')
                    <p>{{ $boutique->telephone }}</p>
                @endif
                @if ($boutique->user->email ?? '')
                    <p>{{ $boutique->user->email }}</p>
                @endif
                @if ($boutique->siret ?? '')
                    <p>N° SIRET: {{ $boutique->siret }}</p>
                @endif
                <p><b>Magazin:</b> {{ $demande->magazin }}</p>
            </div>

            <div class="client-info">
                @php
                    $styleClass = $demande->client->siret ? 'text-soscite' : 'text-client';
                @endphp
                <div class="{{ $styleClass }}">
                    <p><strong
                            style="color: #46d8d5;">{{ $demande->client->nom . ' ' . $demande->client->prenom ?? 'Kamel Sta' }}</strong>
                    </p>
                    @if ($demande->client->adresse ?? '')
                        <p>{{ $demande->client->adresse }}</p>
                    @endif
                    @if (($demande->client->city ?? '') && ($demande->client->code_postal ?? ''))
                        <p>{{ $demande->client->city }} {{ $demande->client->code_postal }}</p>
                    @endif
                    @if ($demande->client->telephone ?? '')
                        <p>{{ $demande->client->telephone }}</p>
                    @endif
                    @if ($demande->client->email ?? '')
                        <p>{{ $demande->client->email }}</p>
                    @endif
                    @if ($demande->client->siret ?? '')
                        <p>N° SIRET: {{ $demande->client->siret }}</p>
                    @endif
                    <p><strong>Date :</strong>
                        {{ $demande->created_at ? \Carbon\Carbon::parse($demande->created_at)->format('d/m/Y') : 'Non spécifiée' }}
                    </p>
                    <p><strong>Date de validité :</strong>
                        {{ $demande->created_at ? \Carbon\Carbon::parse($demande->created_at)->addDays(30)->format('d/m/Y') : 'Non spécifiée' }}
                    </p>
                    @if ($demande->date_rendez_vous ?? '')
                        <p><strong>Date de rendez-vous :</strong>
                            {{ \Carbon\Carbon::parse($demande->date_rendez_vous)->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <hr>

        <table class="info-appareil" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="info-item">
                    <strong>Matériel :</strong>
                    {{ $demande->modele->marque->materiel->nom_materiel ?? 'Non spécifié' }}
                </td>
                <td class="info-separator">|</td>
                <td class="info-item">
                    <strong>Marque :</strong> {{ $demande->modele->marque->nom_marques ?? 'Non spécifié' }}
                </td>
                <td class="info-separator">|</td>
                <td class="info-item">
                    <strong>Modèle :</strong> {{ $demande->modele->nom_modele ?? 'Non spécifié' }}
                </td>
                @if ($demande->imei ?? '')
                    <td class="info-separator">|</td>
                    <td class="info-item">
                        <strong>IMEI :</strong> {{ $demande->imei }}
                    </td>
                @endif
            </tr>
        </table>


        <div class="table-responsive">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Panne</th>
                        <th>QTE</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalHT = 0;
                        $totalTVA = 0;
                        $totalRemiseHT = 0;
                        $totalRemiseTTC = 0;
                    @endphp

                    @php
                        $totalQualirepar = 0;
                        $totalRemise = 0;
                        $totalTTC = 0;
                    @endphp
                    @foreach ($demande->pannes as $panne)
                        @php
                            $produit = $panne['name'] ?? 'Produit non spécifié';
                            $quantite = floatval($panne['quantite'] ?? 1);
                            $tauxTVA = 0.2;
                            if (@$panne['type']['is_qualirepar'] && $demande->is_qualirepar) {
                                $totalQualirepar = floatVal(@$panne['type']['montant']);
                            }
                            if (floatVal(@$panne['remiseOnline']) > 0) {
                                $remise = number_format(
                                    @$panne['price'] * (floatVal(@$panne['remiseOnline']) / 100),
                                    2,
                                );
                                $totalRemise += $remise;
                            }
                            $totalTTC += @$panne['price'];
                        @endphp

                        <tr>
                            <td>{{ $produit }}</td>
                            {{-- <td class="price-cell">{{ number_format($prixHT, 2, ',', ' ') }} €</td> --}}
                            <td class="price-cell">{{ $quantite }}</td>
                            {{-- <td class="price-cell">20.00%</td> --}}
                            <td class="price-cell">{{ number_format(@$panne['price'], 2, ',', ' ') }} €</td>
                        </tr>
                    @endforeach
                    @php
                        $totalProduct = 0;
                    @endphp
                    @if (is_array(@$demande->produit_additionnel))
                        @php
                            $totalProduct = @$demande->produit_additionnel['price'];
                        @endphp
                        <tr>
                            <td>{{ @$demande->produit_additionnel['name'] }}</td>
                            {{-- <td class="price-cell">{{ number_format($prixHT, 2, ',', ' ') }} €</td> --}}
                            <td class="price-cell">1</td>
                            {{-- <td class="price-cell">20.00%</td> --}}
                            <td class="price-cell">
                                {{ number_format(@$demande->produit_additionnel['price'], 2, ',', ' ') }} €</td>
                        </tr>
                    @endif
                    <tr class="final-total">
                        <td colspan="1">Sous Total </td>
                        <td colspan="2" class="price-cell">{{ number_format($totalTTC + (float)$totalProduct, 2, ',', ' ') }} €</td>
                    </tr>
                    @if ($totalRemise > 0)
                        <tr class="total-section">
                            <td colspan="1">Total Remise</td>
                            <td colspan="2" class="price-cell">-{{ $totalRemise }} €
                            </td>
                        </tr>
                    @endif

                    @php
                        $totalOption = 0;
                    @endphp
                    @if (@$demande->repair_options['price'] > 0)
                        @php
                            $totalOption = @$demande->repair_options['price'];
                        @endphp
                        <tr class="total-section">
                            <td colspan="1">{{ $demande->repair_options['label'] }}</td>
                            <td colspan="2" class="price-cell">+{{ number_format($totalOption, 2, ',', ' ') }} €
                            </td>
                        </tr>
                    @endif

                    @if ($totalQualirepar > 0)
                        <tr class="total-section">
                            <td colspan="1">Qualirepar</td>
                            <td colspan="2" class="price-cell">
                                -{{ number_format($totalQualirepar, 2, ',', ' ') }} €
                            </td>
                        </tr>
                    @endif

                    <tr class="final-total">
                        <td colspan="1">Total </td>
                        <td colspan="2" class="price-cell">
                            {{ number_format($totalTTC + $totalOption - ($totalRemise + $totalQualirepar) + (float)$totalProduct, 2, ',', ' ') }}
                            €</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($demande->commentaire && $demande->commentaire !== 'Ajoutez un commentaire...')
            <div class="note">
                <strong>Commentaire :</strong> {{ $demande->commentaire }}
            </div>
        @endif

        <div class="signature_container text-end">
            <h6 class="text-center" style="color: #46d8d5;">Signature de
                {{ $demande->client->nom . ' ' . $demande->client->prenom ?? 'Model Itech' }}</h6>
            <div class="signature-box">
            </div>
        </div>

        <div class="footer">
            <span><strong>Model Itech</strong></span>
            - <span>Téléphone: 09 86 40 22 79</span>
            - <span>Email: contact@modelitech.com</span>
        </div>
    </div>
</body>

</html>
