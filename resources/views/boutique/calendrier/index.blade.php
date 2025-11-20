@extends('boutique.layouts.app')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row align-items-center">


                </div>
            </div>
        </div>
        <div class="container-fluid calendar-basic">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Gestion du Calendrier</h5>
                    <button data-bs-target="#dayoffModal" class="btn btn-light text-white bg-white" data-bs-toggle="modal">
                        <i class="fas fa-plus"></i> Ajouter un Jour de Congé
                    </button>
                </div>
                <div class="card-body">
                    <div class="row" id="wrap">
                        <div class="col-12">
                            <div class="calendar-default" id="calendar-container">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Managing Day-offs -->
        <div class="modal fade" id="dayoffModal" tabindex="-1" aria-labelledby="dayoffModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="dayoffModalLabel">Gérer le Jour de Congé</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="dayoff-form">
                            <div class="mb-3">
                                <label class="form-label"><strong>Date :</strong></label>
                                <input type="date" class="form-control" id="modal-date">
                            </div>
                            <div class="mb-3" id="dayoff-status">
                                <!-- Status will be updated dynamically -->
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="add-dayoff" class="btn btn-primary w-100">Ajouter comme Jour de
                                    Congé</button>
                                <button type="button" id="remove-dayoff" class="btn btn-danger w-100"
                                    style="display: none;">Supprimer le Jour de Congé</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/calendar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .closed-day {
            background-color: #f8d7da !important;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .closed-day .fc-daygrid-day-number {
            color: #721c24 !important;
        }

        .fc-daygrid-day-number {
            font-weight: 500;
        }

        .fc-event-dayoff {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
            font-size: 0.9em;
        }

        .modal-content {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #b02a37;
            border-color: #a71d2a;
        }

        .toast-message {
            color: white;
        }
    </style>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        $(document).ready(function () {
            var calendarEl = $('#calendar')[0];
            var closedDays = [];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: false,
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.description) {
                        info.el.setAttribute('title', info.event.extendedProps.description);
                    }
                    if (info.event.extendedProps.type === 'dayoff') {
                        info.el.classList.add('fc-event-dayoff');
                    }
                },
                dayCellClassNames: function (arg) {
                    var dayOfWeek = arg.date.getDay();
                    return closedDays.includes(dayOfWeek) ? ['closed-day'] : [];
                },
                dateClick: function (info) {
                    var selectedDate = info.dateStr;
                    var dayOfWeek = info.date.getDay();

                    if (closedDays.includes(dayOfWeek)) {
                        toastr.warning('Ce jour est fermé.');
                        return;
                    }

                    $.ajax({
                        url: '{{ route("boutique.dayoff.check") }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { date: selectedDate },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-date').val(selectedDate);
                                if (response.isDayoff) {
                                    $('#dayoff-status').html('<span class="text-danger">Ce jour est marqué comme congé.</span>');
                                    $('#add-dayoff').hide();
                                    $('#remove-dayoff').show();
                                } else {
                                    $('#dayoff-status').html('<span class="text-success">Ce jour est disponible.</span>');
                                    $('#add-dayoff').show();
                                    $('#remove-dayoff').hide();
                                }
                                $('#dayoffModal').modal('show');
                            } else {
                                toastr.error('Erreur: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            toastr.error('Erreur lors de la vérification du jour de congé. Erreur: ' + xhr.statusText);
                        }
                    });
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{ route("boutique.events.index") }}',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log('API Response:', data);
                            // Update closedDays from the response
                            closedDays = Array.isArray(data.closedDays) ? data.closedDays : [];

                            // Combine all events
                            const validEvents = [
                                ...(Array.isArray(data.appointments) ? data.appointments.filter(event =>
                                    event && typeof event === 'object' && event.start && event.title
                                ) : []),
                                ...(Array.isArray(data.workingHours) ? data.workingHours.filter(event =>
                                    event && typeof event === 'object' && event.startTime && event.daysOfWeek && event.display
                                ) : []),
                                ...(Array.isArray(data.dayoffs) ? data.dayoffs.filter(event =>
                                    event && typeof event === 'object' && event.start && event.title
                                ) : [])
                            ];

                            successCallback(validEvents);
                        },
                        error: function (xhr) {
                            console.error('Error fetching events:', xhr.responseText);
                            toastr.error('Échec du chargement des événements du calendrier. Erreur: ' + xhr.statusText);
                            failureCallback(xhr);
                        }
                    });
                },
                locale: 'fr',
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour'
                },
                firstDay: 1
            });
            calendar.render();

            // Add Day-off
            $('#add-dayoff').click(function () {
                var date = $('#modal-date').val();
                $.ajax({
                    url: '{{ route("boutique.dayoff.store") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { jour_conge: date },
                    success: function (response) {
                        if (response.success) {
                            calendar.addEvent({
                                title: 'Jour de Congé',
                                start: date,
                                allDay: true,
                                color: '#dc3545',
                                type: 'dayoff'
                            });
                            $('#dayoff-status').html('<span class="text-danger">Ce jour est marqué comme congé.</span>');
                            $('#add-dayoff').hide();
                            $('#remove-dayoff').show();
                            toastr.success('Jour de congé ajouté avec succès.');
                        } else {
                            toastr.error('Erreur: ' + response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Erreur lors de l\'ajout du jour de congé. Erreur: ' + xhr.statusText);
                    }
                });
            });

            // Remove Day-off
            $('#remove-dayoff').click(function () {
                var date = $('#modal-date').val();
                $.ajax({
                    url: '{{ route("boutique.dayoff.destroy") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { jour_conge: date },
                    success: function (response) {
                        if (response.success) {
                            calendar.getEvents().forEach(function (event) {
                                if (event.startStr === date && event.extendedProps.type === 'dayoff') {
                                    event.remove();
                                }
                            });
                            $('#dayoff-status').html('<span class="text-success">Ce jour est disponible.</span>');
                            $('#add-dayoff').show();
                            $('#remove-dayoff').hide();
                            toastr.success('Jour de congé supprimé avec succès.');
                        } else {
                            toastr.error('Erreur: ' + response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Erreur lors de la suppression du jour de congé. Erreur: ' + xhr.statusText);
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.js') }}"></script>
    <script src="{{ asset('assets/js/header-slick.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/select2/tagify.js') }}"></script>
    <script src="{{ asset('assets/js/select2/tagify.polyfills.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/intltelinput.min.js') }}"></script>

@endsection