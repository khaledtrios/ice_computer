@extends('boutique.layouts.app')

@section('title', 'Liste des Clients | model-itech')

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
        <div class="container-fluid configuration-container py-4">
            <div class="card">
                <div class="card-header">
                    <h5>Liste des Clients</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="clientsTable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Téléphone</th>
                                    <th>E-mail</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
        // Define isDarkStyle to fix undefined error
        window.isDarkStyle = false; // Set to true for dark mode
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

        $(document).ready(function () {
            var dt_client_table = $('#clientsTable');
            if (dt_client_table.length) {
                var dt_clients = dt_client_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('boutique.getApiClient') }}",
                        type: "GET",
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'nom' },
                        { data: 'prenom' },
                        { data: 'telephone' },
                        { data: 'email' },
                        { data: null, orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            render: function(data, type, full) {
                                return '<span>#' + full.id + '</span>';
                            }
                        },
                        {
                            targets: 1,
                            render: function(data, type, full) {
                                return full.nom;
                            }
                        },
                        {
                            targets: 2,
                            render: function(data, type, full) {
                                return full.prenom;
                            }
                        },
                        {
                            targets: 3,
                            render: function(data, type, full) {
                                return full.telephone;
                            }
                        },
                        {
                            targets: 4,
                            render: function(data, type, full) {
                                return full.email;
                            }
                        },
                        {
                            targets: 5,
                            render: function(data, type, full) {
                                var linkshow = "";
                                return (
                                    '<ul class="action">' +
                                    '<li class="delete"><a href="javascript:;" data-id="' + encodeURIComponent(full.id) + '" class="delete-record"><i class="fa-solid fa-trash-can"></i></a></li>' +
                                    '</ul>'
                                );
                            }
                        }
                    ],
                    order: [[1, 'asc']],
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

            // Delete Record
            $('#clientsTable').on('click', '.delete-record', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression du client est irréversible. Voulez-vous continuer ?",
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
                            url: "{{ route('boutique.clients.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                dt_clients.row(row).remove().draw();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimé !',
                                    text: 'Le client a été supprimé.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: 'Une erreur s\'est produite lors de la suppression.',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Annulé',
                            text: 'Le client n\'a pas été supprimé.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            // Fix DataTables styling
            setTimeout(() => {
                $('.dataTables_filter .form-control').removeClass('form-control-sm');
                $('.dataTables_length .form-select').removeClass('form-select-sm');
            }, 300);
        });
    </script>
@endsection