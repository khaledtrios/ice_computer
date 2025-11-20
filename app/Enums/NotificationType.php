<?php

namespace App\Enums;

class NotificationType
{
    //  Notifications pour l'admin
    const NOUVEAU_TICKET = 'admin_nouveau_ticket';
    const NOUVELLE_BOUTIQUE = 'admin_nouvelle_boutique';
    const NOUVELLE_DEMANDE = 'admin_nouvelle_demande';

    const NOUVELLE_DOMAINS = 'admin_nouvelle_domain';

    // Notifications pour la boutique
    const TICKET_REPONDU = 'boutique_ticket_repondu';
    const DEMANDE_TRAITEE = 'boutique_demande_traitee';
    const COMPTE_VALIDÉ = 'boutique_compte_valide';
    const MISE_A_JOUR_PROFIL = 'boutique_profil_modifie';

    const DESACTIVATION_COMPTE = 'boutique_desactivation_compte';

    const resinstallerConfiguration = 'boutique_resinstaller_configuration';


}
