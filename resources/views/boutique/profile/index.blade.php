@extends('boutique.layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row"></div>
            </div>
        </div>
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5>Ma Boutique</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab"
                                aria-controls="details" aria-selected="true">
                                Détails de la boutique
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="schedule-tab" data-bs-toggle="tab" href="#schedule" role="tab"
                                aria-controls="schedule" aria-selected="false">
                                Horaire d'ouverture
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab"
                                aria-controls="password" aria-selected="false">
                                Mot de passe
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Détails de la boutique -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <form class="row g-3 mt-3" id="details-form" action="{{ route('boutique.update') }}"
                                method="POST">
                                @csrf
                                <div class="col-md-4">
                                    <label class="form-label">Nom de la boutique</label>
                                    <input class="form-control" type="text" name="shop_name"
                                        value="{{ $attributes['nom_boutique'] }}" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nom de l'entreprise</label>
                                    <input class="form-control" type="text" name="company"
                                        value="{{ $attributes['company'] }}" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Téléphone</label>
                                    <input class="form-control" type="tel" name="phone"
                                        value="{{ $attributes['telephone'] }}" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Siret</label>
                                    <input class="form-control" type="text" name="siret"
                                        value="{{ $attributes['siret'] }}" required />
                                </div>
                                {{--  <div class="col-md-4">
                                <label class="form-label">Adresse</label>
                                <input class="form-control" type="text" name="address" value="{{ json_decode($attributes['adresse'])->rue }}" required />
                            </div> --}}
                                <div class="col-md-4">
                                    <label class="form-label">Ville</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ $attributes['city'] }}" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Code postal</label>
                                    <input class="form-control" type="text" name="postal_code"
                                        value="{{ $attributes['code_postal'] }}" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Couleur primaire</label>
                                    <input class="form-control form-control-color" type="color" name="primary_color"
                                        value="{{ $attributes['primary_color'] }}" title="Choisissez une couleur" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Couleur secondaire</label>
                                    <input class="form-control form-control-color" type="color" name="secondary_color"
                                        value="{{ $attributes['secondary_color'] }}" title="Choisissez une couleur" />
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="pointer" type="checkbox" name="qualirepar" id="labelCheck"
                                            {{ $attributes['libalise'] ? 'checked' : '' }} />
                                        <label class="form-check-label" for="labelCheck">
                                            Je suis labellisé QUALIREPAR !
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fa-solid fa-pen-to-square"></i> Modifier
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- Horaire d'ouverture -->
                      <!-- Horaire d'ouverture -->
<div class="tab-pane fade mt-4" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
    <form id="schedule-form" action="{{ route('boutique.schedule.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <div class="row">
                @php
                    $days = [
                        'lundi' => 'Monday',
                        'mardi' => 'Tuesday',
                        'mercredi' => 'Wednesday',
                        'jeudi' => 'Thursday',
                        'vendredi' => 'Friday',
                        'samedi' => 'Saturday',
                        'dimanche' => 'Sunday',
                    ];
                @endphp
                @foreach ($days as $frenchDay => $englishDay)
                    @php
                        $schedule = $attributes[$englishDay];
                        $isOpen = isset($schedule['is_open']) && $schedule['is_open'] == 1;
                    @endphp
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card border p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">{{ ucfirst($frenchDay) }}</label>
                                <div class="form-check form-switch mb-0">
                                    <input class="pointer {{ $frenchDay }}-switch"
                                           type="checkbox" id="{{ $frenchDay }}-switch"
                                           {{ $isOpen ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="mb-2">
                                    <label class="form-label">Matin</label>
                                    <div class="d-flex gap-2">
                                        <input type="time"
                                               class="form-control {{ $frenchDay }}-time-morning"
                                               name="{{ $frenchDay }}[morning][start]"
                                               value="{{ $isOpen && isset($schedule['midi_debut']) ? $schedule['midi_debut'] : '00:00' }}"
                                               {{ $isOpen ? '' : 'readonly' }}>
                                        <input type="time"
                                               class="form-control {{ $frenchDay }}-time-morning"
                                               name="{{ $frenchDay }}[morning][end]"
                                               value="{{ $isOpen && isset($schedule['midi_fin']) ? $schedule['midi_fin'] : '00:00' }}"
                                               {{ $isOpen ? '' : 'readonly' }}>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Après-midi</label>
                                    <div class="d-flex gap-2">
                                        <input type="time"
                                               class="form-control {{ $frenchDay }}-time-afternoon"
                                               name="{{ $frenchDay }}[afternoon][start]"
                                               value="{{ $isOpen && isset($schedule['apres_midi_debut']) ? $schedule['apres_midi_debut'] : '00:00' }}"
                                               {{ $isOpen ? '' : 'readonly' }}>
                                        <input type="time"
                                               class="form-control {{ $frenchDay }}-time-afternoon"
                                               name="{{ $frenchDay }}[afternoon][end]"
                                               value="{{ $isOpen && isset($schedule['apres_midi_fin']) ? $schedule['apres_midi_fin'] : '00:00' }}"
                                               {{ $isOpen ? '' : 'readonly' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 text-end">
                <button class="btn btn-success" type="submit">
                    <i class="fa-solid fa-pen-to-square"></i> Enregistrer les horaires
                </button>
            </div>
        </div>
    </form>
</div>
                        <!-- Mot de passe -->
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form id="password-form" class="row g-3 mt-3"
                                action="{{ route('boutique.password.update') }}" method="POST">
                                @csrf
                                <div class="col-md-4">
                                    <label class="form-label">Ancien mot de passe</label>
                                    <input class="form-control" type="password" name="old_password" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input class="form-control" type="password" name="new_password" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Confirmez le mot de passe</label>
                                    <input class="form-control" type="password" name="new_password_confirmation"
                                        required />
                                </div>
                                <div class="col-12 text-end">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fa-solid fa-lock"></i> Changer mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-switch.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .toast-message{
            color: white;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Librairies de base --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>

    {{-- Toastr déjà importé dans le layout principal --}}

    <script>
     $(document).ready(function() {
    /* ###########################################################
       #  CONFIGURATION GLOBALE TOASTR
       ########################################################### */
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": 4000,
        "extendedTimeOut": 2000
    };

    /* ###########################################################
       #  FONCTIONS UTILITAIRES
       ########################################################### */
    const days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

    function toggleTimeInputs(day, isChecked) {
        const $morningInputs = $(`.${day}-time-morning`);
        const $afternoonInputs = $(`.${day}-time-afternoon`);

        $morningInputs.prop('readonly', !isChecked);
        $afternoonInputs.prop('readonly', !isChecked);

        if (!isChecked) {
            $morningInputs.val('00:00');
            $afternoonInputs.val('00:00');
        } else if ($morningInputs.val() === '00:00' && $afternoonInputs.val() === '00:00') {
            $morningInputs.eq(0).val('09:00');
            $morningInputs.eq(1).val('12:00');
            $afternoonInputs.eq(0).val('14:00');
            $afternoonInputs.eq(1).val('18:00');
        }
    }

    /* ###########################################################
       #  INITIALISATION
       ########################################################### */
    days.forEach(day => toggleTimeInputs(day, $(`#${day}-switch`).is(':checked')));

    /* ###########################################################
       #  SWITCH D’OUVERTURE / FERMETURE JOUR
       ########################################################### */
    days.forEach(day => {
        $(`#${day}-switch`).on('change', function() {
            toggleTimeInputs(day, this.checked);
        });
    });

    /* ###########################################################
       #  FORMULAIRE « Détails »
       ########################################################### */
    $('#details-form').on('submit', function(e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize())
            .done(() => toastr.success('Détails de la boutique mis à jour avec succès !'))
            .fail(xhr => toastr.error('Erreur lors de la mise à jour : ' + (xhr.responseJSON?.message ?? '')));
    });

    /* ###########################################################
       #  FORMULAIRE « Horaires »
       ########################################################### */
    $('#schedule-form').on('submit', function(e) {
        e.preventDefault();

        let valid = true;
        const schedule = {};

        days.forEach(day => {
            const isOpen = $(`#${day}-switch`).is(':checked');
            const morningTimes = $(`.${day}-time-morning`).map((_, el) => $(el).val()).get();
            const afternoonTimes = $(`.${day}-time-afternoon`).map((_, el) => $(el).val()).get();

            if (isOpen) {
                // Validate morning times
                if (morningTimes[0] >= morningTimes[1] && morningTimes[0] !== '00:00') {
                    toastr.warning(`L'heure de fin du matin doit être postérieure à l'heure de début pour ${day}.`);
                    valid = false;
                }
                // Validate afternoon times
                if (afternoonTimes[0] >= afternoonTimes[1] && afternoonTimes[0] !== '00:00') {
                    toastr.warning(`L'heure de fin de l'après-midi doit être postérieure à l'heure de début pour ${day}.`);
                    valid = false;
                }
                // Validate morning end vs. afternoon start
                if (morningTimes[1] > afternoonTimes[0] && afternoonTimes[0] !== '00:00') {
                    toastr.warning(`L'heure de début de l'après-midi doit être postérieure à l'heure de fin du matin pour ${day}.`);
                    valid = false;
                }
            }

            schedule[day] = {
                morning: { start: isOpen ? morningTimes[0] : null, end: isOpen ? morningTimes[1] : null },
                afternoon: { start: isOpen ? afternoonTimes[0] : null, end: isOpen ? afternoonTimes[1] : null }
            };
        });

        if (!valid) return;

        $.post($(this).attr('action'), {
            _token: $('input[name="_token"]').val(),
            schedule
        })
            .done(() => toastr.success('Horaires mis à jour avec succès !'))
            .fail(xhr => toastr.error('Erreur lors de la mise à jour des horaires : ' + (xhr.responseJSON?.message ?? '')));
    });

    /* ###########################################################
       #  FORMULAIRE « Mot de passe »
       ########################################################### */
    $('#password-form').on('submit', function(e) {
        e.preventDefault();

        const oldPassword = $(this).find('input[name="old_password"]').val();
        const newPassword = $(this).find('input[name="new_password"]').val();
        const confirmPwd = $(this).find('input[name="new_password_confirmation"]').val();

        if (!oldPassword || !newPassword || !confirmPwd) {
            toastr.info('Veuillez remplir tous les champs.');
            return;
        }
        if (newPassword !== confirmPwd) {
            toastr.warning('Les nouveaux mots de passe ne correspondent pas.');
            return;
        }

        $.post($(this).attr('action'), $(this).serialize())
            .done(() => {
                toastr.success('Mot de passe changé avec succès !');
                $('#password-form')[0].reset();
            })
            .fail(xhr => toastr.error('Erreur lors du changement de mot de passe : ' + (xhr.responseJSON?.message ?? '')));
    });
});
    </script>
@endsection
