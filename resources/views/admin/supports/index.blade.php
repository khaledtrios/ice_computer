@extends('admin.layouts.app')

@section('title', 'Liste des Tickets | model-itech')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <h3>Liste des Tickets</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Liste des Tickets</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="ticketsTable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Boutique</th>
                                    <th>Objet</th>
                                    <th>Message</th>
                                    <th>Statut</th>
                                    <th>Ouvert</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal pour modifier un ticket -->
            <div class="modal fade" id="EditTicket" tabindex="-1" role="dialog" aria-labelledby="EditTicketLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="EditTicketLabel">Modifier un Ticket</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="editTicketForm" class="row g-3" enctype="multipart/form-data">
                                <input type="hidden" class='edit_ticket_id' name="id">
                                <input type="hidden" name="_method" value="PUT">

                                <div class="col-md-6">
                                    <label class="form-label" for="edit_ticketObjet">Objet</label>
                                    <input class="form-control" id="edit_ticketObjet" name="objet" type="text"
                                        placeholder="Entrez l'objet du ticket" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="edit_ticketStatus">Statut</label>
                                    <select class="form-control" id="edit_ticketStatus" name="status" required>
                                        <option value="1">Ouvert</option>
                                        <option value="0">Fermé</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="updateTicket">Mettre à jour</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.select.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/select.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        'use strict';
        window.isDarkStyle = false;
        window.config = {
            colors: {
                borderColor: '#dfe3e8',
                bodyBg: '#fff',
                headingColor: '#333',
            },
            colors_dark: {
                borderColor: '#444',
                bodyBg: '#222',
                headingColor: '#fff',
            }
        };

        // Function to clean up modal backdrop
        function cleanModalBackdrop() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }

        $(document).ready(function () {
            var dt_ticket_table = $('#ticketsTable');
            if (dt_ticket_table.length) {
                var dt_tickets = dt_ticket_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('superadmin.api.getTickets') }}",
                        type: "GET",
                        error: function (xhr, error, thrown) {
                            console.error('DataTables AJAX error:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur de chargement',
                                text: 'Impossible de charger les données. Vérifiez la console pour plus de détails.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'boutique' },
                        { data: 'objet' },
                        { data: 'message' },
                        { data: 'status' },
                        { data: 'is_oppen' },
                        { data: 'created_at' },
                        { data: null, orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            render: function (data, type, full) {
                                return '<span>#' + full.id + '</span>';
                            }
                        },
                        {
                            targets: 1,
                            render: function (data, type, full) {
                                return full.boutique || 'N/A';
                            }
                        },
                        {
                            targets: 4,
                            render: function (data, type, full) {
                                var badgeClass = full.status ? 'badge-success' : 'badge-danger';
                                var statusText = full.status ? 'Ouvert' : 'Fermé';
                                return '<span class="badge ' + badgeClass + '">' + statusText + '</span>';
                            }
                        },
                        {
                            targets: 5,
                            render: function (data, type, full) {
                                var badgeClass = full.is_oppen ? 'badge-success' : 'badge-danger';
                                var statusText = full.is_oppen ? 'Ouvert' : 'Fermé';
                                return '<span class="badge ' + badgeClass + '">' + statusText + '</span>';
                            }
                        },
                        {
                            targets: 7,
                            render: function (data, type, full) {
                                var linkShow = '{{ route('superadmin.tickets.show', ':id') }}'.replace(':id', encodeURIComponent(full.id));

                                return (
                                    '<ul class="action d-flex align-items-center list-unstyled gap-2 m-0">' +
                                    // Modifier
                                    '<li>' +
                                    '<a href="javascript:;" data-id="' + encodeURIComponent(full.id) + '" class="btn btn-sm btn-icon btn-primary edit-record" title="Modifier">' +
                                    '<i class="fa-regular fa-pen-to-square"></i>' +
                                    '</a>' +
                                    '</li>' +

                                    // Afficher ou envoyer message
                                    '<li>' +
                                    '<a href="' + linkShow + '" class="btn btn-sm btn-icon btn-info message-record" title="Voir le ticket">' +
                                    '<i class="fa-solid fa-message"></i>' +
                                    '</a>' +
                                    '</li>' +

                                    // Supprimer
                                    '<li>' +
                                    '<a href="javascript:;" data-id="' + encodeURIComponent(full.id) + '" class="btn btn-sm btn-icon btn-danger delete-record" title="Supprimer">' +
                                    '<i class="fa-solid fa-trash-can"></i>' +
                                    '</a>' +
                                    '</li>' +
                                    '</ul>'
                                );
                            }
                        }


                    ],
                    order: [[6, 'desc']],
                    dom: '<"card-header d-flex flex-column flex-md-row align-items-start align-items-md-center"<f><"d-flex align-items-md-center justify-content-md-end mt-2 mt-md-0 gap-2"l<"dt-action-buttons">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    lengthMenu: [10, 20, 30, 40],
                    language: {
                        sEmptyTable: "Aucune donnée disponible dans le tableau",
                        sInfo: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                        sInfoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
                        sInfoFiltered: "(filtré à partir de _MAX_ éléments au total)",
                        sLengthMenu: "Afficher _MENU_ éléments",
                        sLoadingRecords: "Chargement...",
                        sProcessing: "Traitement...",
                        sSearch: "",
                        sZeroRecords: "Aucun résultat trouvé",
                        oPaginate: {
                            sFirst: "Premier",
                            sLast: "Dernier",
                            sNext: "Suivant",
                            sPrevious: "Précédent"
                        },
                        oAria: {
                            sSortAscending: ": activer pour trier la colonne par ordre croissant",
                            sSortDescending: ": activer pour trier la colonne par ordre décroissant"
                        },
                        searchPlaceholder: "Rechercher..."
                    }
                });
            }

            // Create Ticket
            $('#saveTicket').on('click', function () {
                var form = $('#createTicketForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.tickets.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#CreateTicket').modal('hide');
                            cleanModalBackdrop();
                            dt_tickets.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Créé !',
                                text: data.message || 'Le ticket a été créé avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            $('#CreateTicket').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la création du ticket.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    });
                } else {
                    form[0].reportValidity();
                }
            });

            // Edit Ticket
            $('#ticketsTable').on('click', '.edit-record', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('superadmin.tickets.edit', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('.edit_ticket_id').val(data.ticket.id);
                        $('#edit_boutiqueId').val(data.ticket.boutique_id);
                        $('#edit_ticketObjet').val(data.ticket.objet);
                        $('#edit_ticketMessage').val(data.ticket.message);
                        $('#edit_ticketStatus').val(data.ticket.status ? '1' : '0');
                        $('#EditTicket').modal('show');
                        console.log('ShowDetailsTiket called with id:', data.ticket.id);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la récupération des données.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });

            // Update Ticket
            $('#updateTicket').on('click', function () {
                var id = $('.edit_ticket_id').val();
                console.log('UpdateTicket called with id:', id);
                var form = $('#editTicketForm');

                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.tickets.update', ':id') }}".replace(':id', id),
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#EditTicket').modal('hide');
                            cleanModalBackdrop();
                            dt_tickets.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message || 'Le ticket a été mis à jour avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                            $('#edit_ticketImagePreview').hide();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            $('#EditTicket').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la mise à jour du ticket.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    });
                } else {
                    form[0].reportValidity();
                }
            });

            // Delete Ticket
            $('#ticketsTable').on('click', '.delete-record', function () {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression du ticket est irréversible. Voulez-vous continuer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimez-le !',
                    cancelButtonText: 'Non, annulez !',
                    customClass: {
                        confirmButton: 'btn btn-secondary text-white me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('superadmin.tickets.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                dt_tickets.row(row).remove().draw();
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimé !',
                                    text: data.message || 'Le ticket a été supprimé.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            },
                            error: function (xhr) {
                                console.error(xhr.responseText);
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la suppression.',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'info',
                            title: 'Annulé',
                            text: 'Le ticket n\'a pas été supprimé.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $('#CreateTicket, #EditTicket').on('hidden.bs.modal', function () {
                cleanModalBackdrop();
            });

            feather.replace();

            setTimeout(() => {
                $('.dataTables_filter .form-control').removeClass('form-control-sm');
                $('.dataTables_length .form-select').removeClass('form-select-sm');
            }, 300);
        });
    </script>
@endsection