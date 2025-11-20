<!DOCTYPE html>
<html>

<head>
    <title>Votre {{$boutique->config_type}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f9; color: #333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color: #f4f4f9; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0"
                    style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <!-- Header -->
					@if($isClient == 1)
                    <tr>
                        <td
                            style="background: linear-gradient(90deg, #46D8D5, #0056b3); padding: 20px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                            @if ($boutique->config_type === "Devis")
                                <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Votre devis</h1>
                            @else
                                <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Confirmation de votre Rendez-vous
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
                            @if($boutique->config_type !== 'Devis')

                                <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
                                    Votre rendez-vous est prévu pour le
                                    <strong
                                        style="color: #46D8D5;">{{$demande->date_rendez_vous ?? 'non spécifiée' }}</strong>.
                                </p>
                            @endif
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
                                Pour toute question, contactez-nous à
                                <a href="mailto:contact@modelitech.com"
                                    style="color: #46D8D5; text-decoration: none;">{{$boutique->user->email}}</a>.
                            </p>
                        </td>
                    </tr>
					@else
					<tr>
                        <td
                            style="background: linear-gradient(90deg, #46D8D5, #0056b3); padding: 20px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                             
                            <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Nouvelle demande de {{$boutique->config_type}}
                                </h1> 
                        </td>
                    </tr>
					<tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">Cher(e) boutique(e),</p>
                            <p style="font-size: 16px; line-height: 24px; margin: 0 0 20px;">
								une nouvelle demande de {{ $boutique->config_type }} est envoyé sous le numéro
                                <a href="url('boutique.demandes.index')" target="_blank"><strong style="color: #46D8D5;">{{ $demande->numero_devis ?? 'non spécifié' }}</strong></a>.
                            </p>
                            
                             
                        </td>
                    </tr>
					
					@endif
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
