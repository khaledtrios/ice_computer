<!DOCTYPE html>
<html>
<head>
    <title>Votre inscription boutique avec succès</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f9; color: #333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f9; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 600px;">
                    <tr>
                        <td style="background: linear-gradient(90deg, {{ $user->boutique->primary_color ?? '#46D8D5' }}, {{ $user->boutique->secondary_color ?? '#46D8D5' }}); padding: 20px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                            <h1 style="color: #ffffff; font-size: 24px; margin: 0; font-weight: bold;">Confirmation de votre inscription boutique</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                                Cher(e) <strong>{{ $user->first_name ?? 'partenaire' }}</strong>,
                            </p>
                            <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                                Félicitations ! Votre boutique <strong style="color: {{ $user->boutique->primary_color ?? '#46D8D5' }};">{{ $user->boutique->nom_boutique ?? 'votre boutique' }}</strong> a été crée avec succès le <strong style="color: {{ $user->boutique->primary_color ?? '#46D8D5' }};">{{ $user->created_at?->format('d/m/Y à H:i') ?? now()->format('d/m/Y à H:i') }}</strong>.
                            </p>
                            @if($user->boutique->telephone)
                                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                                    Contact boutique : <a href="tel:{{ $user->boutique->telephone }}" style="color: {{ $user->boutique->primary_color ?? '#46D8D5' }}; text-decoration: none; font-weight: bold;">{{ $user->boutique->telephone }}</a>
                                    @if($user->boutique->adresse && $user->boutique->city)
                                        | {{ $user->boutique->adresse[0] ?? '' }}, {{ $user->boutique->city }} {{ $user->boutique->code_postal ?? '' }}
                                    @endif
                                </p>
                            @endif
                            <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #46D8D5; border-radius: 4px; margin: 0 0 20px;">
                                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 10px; font-weight: bold;">
                                    Vos identifiants de connexion :
                                </p>
                                <p style="font-size: 14px; line-height: 1.4; margin: 0 0 5px;">
                                    <strong>Email :</strong> {{ $user->email }}
                                </p>
                                <p style="font-size: 14px; line-height: 1.4; margin: 0 0 10px;">
                                    <strong>Mot de passe :</strong> {{ $plainPassword }}
                                </p>
                                <p style="font-size: 12px; line-height: 1.3; margin: 0; color: #666; font-style: italic;">
                                    Veuillez changer votre mot de passe dès votre première connexion pour des raisons de sécurité.
                                </p>
                            </div>
                            <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                                Votre compte est en attente de validation par un administrateur. Vous recevrez une notification une fois approuvé.
                            </p>
                            <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                                Pour toute question, contactez-nous à <a href="mailto:contact@modelitech.com" style="color: #46D8D5; text-decoration: none; font-weight: bold;">contact@modelitech.com</a>.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f4f4f9; padding: 20px; text-align: center; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                            <p style="font-size: 14px; color: #666; margin: 0; line-height: 1.4;">
                                Cordialement,<br>
                                <strong style="color: #46D8D5;">{{ 'Model Itech' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>