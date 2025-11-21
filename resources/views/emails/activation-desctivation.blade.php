<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Changement de statut de votre boutique</title>
  <style>
    @media (max-width: 600px) { 
      .email-container { padding: 20px !important; } 
      .email-header h1 { font-size: 20px !important; }
    }
  </style>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 20px;">
  <div class="email-container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    
    <div class="email-header" style="text-align: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 2px solid #46D8D5;">
      <h1 style="color: #46D8D5; margin: 0; font-size: 24px;">Notification de Statut Boutique</h1>
    </div>

    <div class="email-content" style="margin-bottom: 20px;">
      <p style="margin-bottom: 15px;">Bonjour {{ $boutique->user->fullName() ?? 'Cher client' }},</p>

      <p style="margin-bottom: 15px;">
        Nous vous informons que le statut de votre boutique <strong>{{ $boutique->nom_boutique }}</strong> a été mis à jour.
      </p>

      <ul style="padding-left: 20px; margin-bottom: 20px;">
        <li style="margin-bottom: 8px;"><strong>Boutique :</strong> {{ $boutique->nom_boutique }}</li>
        <li style="margin-bottom: 8px;"><strong>Ville :</strong> {{ $boutique->city ?? 'Non spécifiée' }}</li>
        <li style="margin-bottom: 8px;"><strong>Nouveau statut :</strong> 
          <span style="display: inline-block; padding: 8px 16px; border-radius: 20px; font-weight: bold; text-transform: uppercase; font-size: 0.9em;
            {{ $newStatus === 'Actif' 
              ? 'background-color: #46D8D5; color: #ffffff; box-shadow: 0 2px 4px rgba(70, 216, 213, 0.3);' 
              : 'background-color: #f8d7da; color: #721c24;' }}">
            {{ $newStatus }}
          </span>
        </li>
      </ul>

      @if($newStatus === 'Actif')
        <p style="margin-bottom: 15px;">
          <strong>Félicitations !</strong> Votre boutique est maintenant active et visible sur la plateforme. 
          Vous pouvez vous connecter et commencer à gérer vos opérations.
        </p>
      @else
        <p style="margin-bottom: 15px;">
          Votre boutique est actuellement inactive. Pour plus d'informations ou pour la réactiver, 
          veuillez contacter notre support.
        </p>
      @endif

      <p style="margin-bottom: 15px;">
        Si vous avez des questions, contactez-nous à 
        <a href="mailto:support@Ice-Computer.com" style="color: #46D8D5; text-decoration: none;">support@Ice-Computer.com</a>.
      </p>
    </div>

    <div class="email-footer" style="text-align: center; font-size: 0.9em; color: #666; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
      <p style="margin: 0 0 10px 0;">Cordialement,<br>L'équipe Ice-Computer</p>
      <p style="margin: 0; font-size: 0.8em;">
        <small>Ce message a été envoyé automatiquement. Ne répondez pas à cet email.</small>
      </p>
    </div>

  </div>
</body>
</html>
