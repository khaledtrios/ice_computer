<!DOCTYPE html>
<html>

<head>
    <title>Votre {{ $boutique->config_type }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .td-border {
            border-bottom: 1px solid black;
            padding: 10px 20px;
        }

        .table-recap {
            width: 100%
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f9; color: #333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color: #f4f4f9; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0"
                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <!-- Header -->

                    <tr>
                        <td
                            style="background: linear-gradient(90deg, #46D8D5, #0056b3); padding: 20px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                            @if ($boutique->config_type === 'Devis')
                                <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Votre devis</h1>
                            @else
                                <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Confirmation de votre
                                    Rendez-vous
                                </h1>
                            @endif
                        </td>
                    </tr>
                    <!-- Content -->

                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">Cher(e) client(e),</p>
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
                                Merci pour votre demande. Veuillez trouver ci-joint votre devis détaillé pour la date
                                <strong style="color: #46D8D5;">{{ $demande->created_at ?? 'non spécifiée' }}</strong>,
                                sous le numéro
                                <strong style="color: #46D8D5;">{{ $demande->numero_devis ?? 'non spécifié' }}</strong>.
                            </p>
                            @if ($boutique->config_type !== 'Devis')
                                <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
                                    Votre rendez-vous est prévu pour le
                                    <strong
                                        style="color: #46D8D5;">{{ $demande->date_rendez_vous ?? 'non spécifiée' }}</strong>.
                                </p>
                            @endif
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
                                Pour toute question, contactez-nous à
                                <a href="mailto:contact@modelitech.com"
                                    style="color: #46D8D5; text-decoration: none;">{{ $boutique->user->email }}</a>.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <h2>Récapitulatif du devis n° {{ $demande->numero_devis }}</h2>
                            <table class="table-recap">
                                <tr>
                                    <td class="td-border"
                                        style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px">
                                        <div style="font-family:sans-serif">
                                            <div
                                                style="font-size:14px;color:#2b324d;line-height:1.2;font-family:Arial,Helvetica Neue,Helvetica,sans-serif">
                                                <p style="margin:0;font-size:14px">Marque :
                                                    {{ $demande->modele->marque->nom_marques }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-border"
                                        style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px">
                                        <div style="font-family:sans-serif">
                                            <div
                                                style="font-size:14px;color:#2b324d;line-height:1.2;font-family:Arial,Helvetica Neue,Helvetica,sans-serif">
                                                <p style="margin:0;font-size:14px">Modèle :
                                                    {{ $demande->modele->nom_modele }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table class="table-recap">

                                @php
                                    $totalQualirepar = 0;
                                    $totalRemise = 0;
                                    $totalTTC = 0;
                                @endphp
                                @foreach ($demande->pannes as $panne)
                                    <tr>
                                        <td class="td-border">
                                            <div align="center" style="line-height:10px">
                                                <img src="{{ asset('storage/' . @$panne['image']) }}" width="29"
                                                    class="CToWUd" data-bit="iit">
                                            </div>
                                        </td>
                                        <td class="td-border">
                                            <div>
                                                <b>{{ @$panne['name'] }}</b>
                                                @if (floatVal(@$panne['remiseOnline']) > 0)
                                                    <p style="margin:0;font-size:14px">
                                                        <span
                                                            style="background-color:#1caa19;border-radius:8px;border:1px solid #1caa19">
                                                            <strong>
                                                                <span
                                                                    style="color:#ffffff">&nbsp;-{{ @$panne['remiseOnline'] }}%</span>
                                                            </strong>
                                                        </span>
                                                        <span style="color:#1caa19;font-size:12px">&nbsp;en prenant
                                                            rendez-vous en ligne**</span>
                                                    </p>
                                                @endif
                                                @if (@$panne['type']['is_qualirepar'] && $demande->is_qualirepar)
                                                    <p style="margin:0;font-size:14px">
                                                        <span
                                                            style="background-color:#107fda;border-radius:8px;border:1px solid #107fda;display:inline-block">
                                                            <strong>
                                                                <span style="color:#ffffff">&nbsp;Eligible au bonus
                                                                    réparation !&nbsp;***</span>
                                                            </strong>
                                                        </span>
                                                    </p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="td-border">
                                            @php
                                                $total = @$panne['price'];
                                                $hasPromo = floatVal(@$panne['remiseOnline']) > 0 ? true : false;

                                                if (floatVal(@$panne['remiseOnline']) > 0) {
                                                    $remise = number_format(
                                                        @$panne['price'] * (floatVal(@$panne['remiseOnline']) / 100),
                                                        2,
                                                    );
                                                    $total -= $remise;
                                                    $totalRemise += $remise;
                                                }
                                                if (@$panne['type']['is_qualirepar'] && $demande->is_qualirepar) {
                                                    $totalQualirepar = floatVal(@$panne['type']['montant']);
                                                }
                                            @endphp
                                            <div
                                                style="font-size:14px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;color:#2b324d;line-height:1.2">
                                                @if ($hasPromo)
                                                    <p style="margin:0;font-size:14px;text-align:right">
                                                        <span style="text-decoration:line-through">
                                                            <span style="font-size:10px">{{ @$panne['price'] }}€</span>
                                                        </span>
                                                    </p>
                                                @endif
                                                <p style="margin:0;font-size:14px;text-align:right">
                                                    <strong>{{ $total }}€</strong>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $totalTTC += $total;
                                    @endphp
                                @endforeach
                                @php
                                    $totalProduct =  0;
                                @endphp
                                @if(is_array(@$demande->produit_additionnel))
                                    <tr>
                                        <td class="td-border">
                                            <div align="center" style="line-height:10px">
                                                <img src="{{ asset(@$demande->produit_additionnel['image']) }}" width="29"
                                                    class="CToWUd" data-bit="iit">
                                            </div>
                                        </td>
                                        <td class="td-border">
                                            <div>
                                                <b>{{ @$demande->produit_additionnel['name'] }}</b> 
                                            </div>
                                        </td>
                                        <td class="td-border">
                                            @php
                                                 $totalProduct =  @$demande->produit_additionnel['price'];
                                            @endphp
                                            <div
                                                style="font-size:14px;font-family:Roboto,Tahoma,Verdana,Segoe,sans-serif;color:#2b324d;line-height:1.2">
                                                 
                                                <p style="margin:0;font-size:14px;text-align:right">
                                                    <strong>{{ @$demande->produit_additionnel['price'] }}€</strong>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                <tr style="background: #34cfb694;">
                                    <td colspan="3" class="td-border">
                                        <table class="table-recap">
                                            <tr>
                                                <td colspan="2"><b>Total: </b></td>
                                                <td align="right">
                                                    <span style="color: #5d42f3; font-size: 16px;font-weight: 800;">
                                                        {{ $totalTTC + (float)$totalProduct }} €</span>
                                                </td>
                                            </tr>
                                            @php
                                                $totalOption = 0;
                                            @endphp
                                            @if (@$demande->repair_options['price'] > 0)
                                                @php
                                                    $totalOption = @$demande->repair_options['price'];
                                                @endphp
                                                <tr>
                                                    <td colspan="2">
                                                        <div
                                                            style="font-size:14px;font-family:Montserrat,'Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;color:#2b324d;line-height:1.2">
                                                            <p>
                                                                <span
                                                                    style="background-color:#107fda;border-radius:8px;border:1px solid #107fda">
                                                                    <strong>
                                                                        <span
                                                                            style="color:#ffffff">&nbsp;+{{ $demande->repair_options['price'] }}€</span>
                                                                    </strong>
                                                                </span>
                                                                <span
                                                                    style="color:#000000;font-size:12px">&nbsp;{{ $demande->repair_options['label'] }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td align="right">
                                                        <span
                                                            style="color: #c84af1; font-size: 16px;font-weight: 800;">{{ $totalTTC - $totalQualirepar + $totalOption }}
                                                            €</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            @if ($totalRemise > 0)
                                                <tr>
                                                    <td colspan="2">TTC pièce et main d’œuvre </td>
                                                    <td align="right"><span>Vous économisez <b>{{ $totalRemise }}
                                                                €</b></span></td>
                                                </tr>
                                            @endif
                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f4f4f9; padding: 20px; text-align: center; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                            <p style="font-size: 14px; color: #666; margin: 0;">
                                Cordialement,<br>
                                <strong>{{ $boutique->nom_boutique ?? 'Model Itech' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
