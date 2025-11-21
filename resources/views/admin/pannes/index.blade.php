@extends('admin.layouts.app')

@section('title', 'Liste des Pannes | Ice-Computer')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <h3>Liste des Pannes</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#CreatePanne">
                        <i class="fa-solid fa-plus me-2"></i>Créer une panne
                    </button>

                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="filterMateriel">Filtrer par Matériel</label>
                            <select id="filterMateriel" class="form-select">
                                <option value="">Tous les matériels</option>
                                @foreach ($materiels as $materiel)
                                    <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="pannesTable">
                            <thead>
                                <tr>
                                    <th>Nom Panne</th>
                                    <th>Description</th>
                                    <th>Priorité</th>
                                    <th>Matériel</th>
                                    <th>Qualirepar</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal pour créer une panne -->
            <div class="modal fade" id="CreatePanne" tabindex="-1" role="dialog" aria-labelledby="CreatePanneLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="CreatePanneLabel">Créer une panne</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="createPanneForm" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="panneName">Nom Panne</label>
                                    <input class="form-control" id="panneName" name="nom_panne" type="text"
                                        placeholder="Entrez le nom de la panne" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="panneDescription">Description</label>
                                    <textarea class="form-control" id="panneDescription" name="description" placeholder="Entrez la description"
                                        rows="4"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="pannePriorite">Priorité</label>
                                    <input class="form-control" id="pannePriorite" name="priorite" type="number"
                                        min="0" placeholder="Entrez la priorité" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="materielId">Matériel</label>
                                    <select class="form-control" id="materielId" name="materiel_id">
                                        <option value="">Sélectionnez un matériel</option>
                                        @foreach ($materiels as $materiel)
                                            <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_qualirepar"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Eligible Qualirepar
                                        </label>
                                    </div>
                                </div>
                         
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary" type="button" id="savePanne">Créer la panne</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour modifier une panne -->
        <div class="modal fade" id="EditPanne" tabindex="-1" role="dialog" aria-labelledby="EditPanneLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="mb-0" id="EditPanneLabel">Modifier une panne</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="editPanneForm" class="row g-3">
                            <input type="hidden" id="edit_panne_id" name="id">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="col-md-6">
                                <label class="form-label" for="edit_panneName">Nom Panne</label>
                                <input class="form-control" id="edit_panneName" name="nom_panne" type="text"
                                    placeholder="Entrez le nom de la panne" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="edit_panneDescription">Description</label>
                                <textarea class="form-control" id="edit_panneDescription" name="description" placeholder="Entrez la description"
                                    rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="edit_pannePriorite">Priorité</label>
                                <input class="form-control" id="edit_pannePriorite" name="priorite" type="number"
                                    min="0" placeholder="Entrez la priorité" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="edit_materielId">Matériel</label>
                                <select class="form-control" id="edit_materielId" name="materiel_id" required>
                                    <option value="">Sélectionnez un matériel</option>
                                    @foreach ($materiels as $materiel)
                                        <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_qualirepar"
                                        id="is_qualirepar_edit">
                                    <label class="form-check-label" for="is_qualirepar_edit">
                                        Eligible Qualirepar
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-primary" type="button" id="updatePanne">Mettre à jour</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $(document).ready(function() {
            // Initialize Select2 for filter
            $('#filterMateriel').select2({
                placeholder: "Sélectionnez...",
                allowClear: true
            });

            var dt_panne_table = $('#pannesTable');
            if (dt_panne_table.length) {
                var dt_pannes = dt_panne_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('superadmin.api.getPannes') }}",
                        type: "GET",
                        data: function(d) {
                            d.materiel_id = $('#filterMateriel').val();
                        },
                        error: function(xhr, error, thrown) {
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
                    columns: [{
                            data: 'nom_panne'
                        },
                        {
                            data: 'description'
                        },
                        {
                            data: 'priorite'
                        },
                        {
                            data: 'materiel'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            render: function(data, type, full) {
                                return full.nom_panne || 'N/A';
                            }
                        },
                        {
                            targets: 1,
                            render: function(data, type, full) {
                                return full.description || 'N/A';
                            }
                        },
                        {
                            targets: 2,
                            render: function(data, type, full) {
                                return full.priorite || 0;
                            }
                        },
                        {
                            targets: 3,
                            render: function(data, type, full) {
                                return full.materiel ?
                                    '<span class="badge bg-success">' + full.materiel + '</span>' :
                                    '<span class="text-muted">N/A</span>';
                            }
                        },
                        {
                            targets: 4,
                            render: function(data, type, full) {
                                return full.created_at || 'N/A';
                            }
                        },
                        {
                            targets: 5,
                            render: function(data, type, full) {
                                return (
                                    '<ul class="action d-flex align-items-center list-unstyled gap-2 m-0">' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(
                                        full.id || '') +
                                    '" class="btn btn-sm btn-icon btn-primary edit-record" title="Modifier"><i class="fa-regular fa-pen-to-square"></i></a></li>' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(
                                        full.id || '') +
                                    '" class="btn btn-sm btn-icon btn-danger delete-record" title="Supprimer"><i class="fa-solid fa-trash-can"></i></a></li>' +
                                    '</ul>'
                                );
                            }
                        }
                    ],
                    order: [
                        [4, 'desc']
                    ],
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

                // Reload table on filter change
                $('#filterMateriel').on('change', function() {
                    dt_pannes.ajax.reload();
                });
            }

            // Initialize Select2 in Create Modal
            $('#CreatePanne').on('shown.bs.modal', function() {
                $('#materielId').select2({
                    placeholder: "Sélectionnez un matériel",
                    allowClear: true,
                    dropdownParent: $('#CreatePanne')
                });
            });

            // Initialize Select2 in Edit Modal
            $('#EditPanne').on('shown.bs.modal', function() {
                $('#edit_materielId').select2({
                    placeholder: "Sélectionnez un matériel",
                    allowClear: true,
                    dropdownParent: $('#EditPanne')
                });
            });

            // Destroy Select2 on modal hide
            $('#CreatePanne, #EditPanne').on('hidden.bs.modal', function() {
                $(this).find('select').select2('destroy');
                cleanModalBackdrop();
            });

            // Create Panne
            $('#savePanne').on('click', function() {
                var form = $('#createPanneForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.pannes.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('#CreatePanne').modal('hide');
                            cleanModalBackdrop();
                            dt_pannes.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Créé !',
                                text: data.message ||
                                    'La panne a été créée avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function(xhr) {
                            console.error('Create error:', xhr.responseText);
                            $('#CreatePanne').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.error ||
                                    'Une erreur s\'est produite lors de la création de la panne.',
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

            // Edit Panne
            $('#pannesTable').on('click', '.edit-record', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('superadmin.pannes.edit', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#edit_panne_id').val(data.panne.id);
                        $('#edit_panneName').val(data.panne.nom_panne);
                        $('#edit_panneDescription').val(data.panne.description);
                        $('#edit_pannePriorite').val(data.panne.priorite);
                        console.log(data.panne.is_qualirepar)
                        $("#is_qualirepar_edit").prop('checked', data.panne.is_qualirepar)
                        console.log($("#is_qualirepar_edit"))
                        $('#EditPanne').modal('show');
                        // Set value after modal shown and Select2 initialized
                        setTimeout(function() {
                            $('#edit_materielId').val(data.panne.materiel_id).trigger(
                                'change');
                        }, 100);
                    },
                    error: function(xhr) {
                        console.error('Edit error:', xhr.responseText);
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.error ||
                                'Une erreur s\'est produite lors de la récupération des données.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });

            // Update Panne
            $('#updatePanne').on('click', function() {
                var form = $('#editPanneForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.pannes.update', ':id') }}".replace(':id', $(
                            '#edit_panne_id').val()),
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('#EditPanne').modal('hide');
                            cleanModalBackdrop();
                            dt_pannes.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message ||
                                    'La panne a été mise à jour avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function(xhr) {
                            console.error('Update error:', xhr.responseText);
                            $('#EditPanne').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.error ||
                                    'Une erreur s\'est produite lors de la mise à jour de la panne.',
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

            // Delete Record
            $('#pannesTable').on('click', '.delete-record', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression de la panne est irréversible. Voulez-vous continuer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimez-la !',
                    cancelButtonText: 'Non, annulez !',
                    customClass: {
                        confirmButton: 'btn btn-secondary text-white me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('superadmin.pannes.destroy', ':id') }}".replace(
                                ':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                dt_pannes.row(row).remove().draw();
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimé !',
                                    text: data.message ||
                                        'La panne a été supprimée.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            },
                            error: function(xhr) {
                                console.error('Delete error:', xhr.responseText);
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: xhr.responseJSON?.error ||
                                        'Une erreur s\'est produite lors de la suppression.',
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
                            text: 'La panne n\'a pas été supprimée.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            // Handle modal close events to ensure backdrop is removed
            $('#CreatePanne, #EditPanne').on('hidden.bs.modal', function() {
                cleanModalBackdrop();
            });

            // Initialize Feather Icons
            feather.replace();

            // Fix DataTables styling
            setTimeout(() => {
                $('.dataTables_filter .form-control').removeClass('form-control-sm');
                $('.dataTables_length .form-select').removeClass('form-select-sm');
            }, 300);
        });
    </script>
@endsection
