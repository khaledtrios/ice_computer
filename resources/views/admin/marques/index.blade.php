@extends('admin.layouts.app')

@section('title', 'Liste des Marques | model-itech')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <h3>Liste des Marques</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#CreateMarque">
                        <i class="fa-solid fa-plus me-2"></i>Créer une marque
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="filterMateriel">Filtrer par Matériel</label>
                            <select id="filterMateriel" class="form-select">
                                <option value="">Tous les matériels</option>
                                @foreach ($matriels as $materiel)
                                    <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="marquesTable">
                            <thead>
                                <tr>
                                    <th>Nom Marque</th>
                                    <th>Image</th>
                                    <th>Priorité</th>
                                    <th>Matériel</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal pour créer une marque -->
            <div class="modal fade" id="CreateMarque" tabindex="-1" role="dialog" aria-labelledby="CreateMarqueLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="CreateMarqueLabel">Créer une marque</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="createMarqueForm" class="row g-3" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label class="form-label" for="marqueName">Nom Marque</label>
                                    <input class="form-control" id="marqueName" name="nom_marques" type="text"
                                        placeholder="Entrez le nom de la marque" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="marqueImage">Image</label>
                                    <input class="form-control" id="marqueImage" name="image" type="file" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="marquePriorite">Priorité</label>
                                    <input class="form-control" id="marquePriorite" name="priorite" type="number" min="0"
                                        placeholder="Entrez la priorité" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="materielId">Matériel</label>
                                    <select class="form-control" id="materielId" name="materiel_id" required>
                                        <option value="">Sélectionnez un matériel</option>
                                        @foreach ($matriels as $materiel)
                                            <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="saveMarque">Créer la marque</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal pour modifier une marque -->
            <div class="modal fade" id="EditMarque" tabindex="-1" role="dialog" aria-labelledby="EditMarqueLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="EditMarqueLabel">Modifier une marque</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="editMarqueForm" class="row g-3" enctype="multipart/form-data">
                                <input type="hidden" id="edit_marque_id" name="id">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_marqueName">Nom Marque</label>
                                    <input class="form-control" id="edit_marqueName" name="nom_marques" type="text"
                                        placeholder="Entrez le nom de la marque" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_marqueImage">Image</label>
                                    <input class="form-control" id="edit_marqueImage" name="image" type="file"
                                        accept="image/*">
                                    <img id="edit_marqueImagePreview" src="" alt="Aperçu"
                                        style="max-width: 100px; max-height: 100px; display: none; margin-top: 10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_marquePriorite">Priorité</label>
                                    <input class="form-control" id="edit_marquePriorite" name="priorite" type="number"
                                        min="0" placeholder="Entrez la priorité" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_materielId">Matériel</label>
                                    <select class="form-control" id="edit_materielId" name="materiel_id" required>
                                        <option value="">Sélectionnez un matériel</option>
                                        @foreach ($matriels as $materiel)
                                            <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="updateMarque">Mettre à jour</button>
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

        $(document).ready(function () {
            // Initialize Select2 for filter
            $('#filterMateriel').select2({
                placeholder: "Sélectionnez...",
                allowClear: true
            });

            var dt_marque_table = $('#marquesTable');
            if (dt_marque_table.length) {
                var dt_marques = dt_marque_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('superadmin.api.getMarques') }}",
                        type: "GET",
                        data: function (d) {
                            d.materiel_id = $('#filterMateriel').val();
                        },
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
                        { data: 'nom_marques' },
                        { data: 'image' },
                        { data: 'priorite' },
                        { data: 'materiel' },
                        { data: 'created_at' },
                        { data: null, orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            render: function (data, type, full) {
                                return full.image ? '<img src="' + full.image + '" alt="Marque" loading="lazy" style="max-width: 50px; max-height: 50px;">' : 'N/A';
                            }
                        },
                        {
                            targets: 3,
                            render: function (data, type, full) {
                                return full.materiel
                                    ? '<span class="badge bg-success">' + full.materiel + '</span>'
                                    : '<span class="text-muted">N/A</span>';
                            }
                        },
                        {
                            targets: 4,
                            render: function (data, type, full) {
                                return full.created_at || 'N/A';
                            }
                        },
                        {
                            targets: 5,
                            render: function (data, type, full) {
                                return (
                                    '<ul class="action d-flex align-items-center list-unstyled gap-2 m-0">' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(full.id || '') + '" class="btn btn-sm btn-icon btn-primary edit-record" title="Modifier"><i class="fa-regular fa-pen-to-square"></i></a></li>' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(full.id || '') + '" class="btn btn-sm btn-icon btn-danger delete-record" title="Supprimer"><i class="fa-solid fa-trash-can"></i></a></li>' +
                                    '</ul>'
                                );
                            }
                        }
                    ],
                    order: [[2, 'asc']],
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
                $('#filterMateriel').on('change', function () {
                    dt_marques.ajax.reload();
                });
            }

            // Initialize Select2 in Create Modal
            $('#CreateMarque').on('shown.bs.modal', function () {
                $('#materielId').select2({
                    placeholder: "Sélectionnez un matériel",
                    allowClear: true,
                    dropdownParent: $('#CreateMarque')
                });
            });

            // Initialize Select2 in Edit Modal
            $('#EditMarque').on('shown.bs.modal', function () {
                $('#edit_materielId').select2({
                    placeholder: "Sélectionnez un matériel",
                    allowClear: true,
                    dropdownParent: $('#EditMarque')
                });
            });

            // Destroy Select2 on modal hide
            $('#CreateMarque, #EditMarque').on('hidden.bs.modal', function () {
                $(this).find('select').select2('destroy');
                cleanModalBackdrop();
            });

            // Create Marque
            $('#saveMarque').on('click', function () {
                var form = $('#createMarqueForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.marques.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#CreateMarque').modal('hide');
                            cleanModalBackdrop();
                            dt_marques.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Créé !',
                                text: data.message || 'La marque a été créée avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function (xhr) {
                            console.error('Create error:', xhr.responseText);
                            $('#CreateMarque').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la création de la marque.',
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

            // Edit Marque
            $('#marquesTable').on('click', '.edit-record', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('superadmin.marques.edit', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#edit_marque_id').val(data.marque.id);
                        $('#edit_marqueName').val(data.marque.nom_marques);
                        $('#edit_marquePriorite').val(data.marque.priorite);
                        if (data.marque.image) {
                            $('#edit_marqueImagePreview').attr('src', data.marque.image).show();
                        } else {
                            $('#edit_marqueImagePreview').hide();
                        }
                        $('#EditMarque').modal('show');
                        // Set value after modal shown
                        setTimeout(function() {
                            $('#edit_materielId').val(data.marque.materiel_id).trigger('change');
                        }, 100);
                    },
                    error: function (xhr) {
                        console.error('Edit error:', xhr.responseText);
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

            // Update Marque
            $('#updateMarque').on('click', function () {
                var form = $('#editMarqueForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.marques.update', ':id') }}".replace(':id', $('#edit_marque_id').val()),
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#EditMarque').modal('hide');
                            cleanModalBackdrop();
                            dt_marques.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message || 'La marque a été mise à jour avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                            $('#edit_marqueImagePreview').hide();
                        },
                        error: function (xhr) {
                            console.error('Update error:', xhr.responseText);
                            $('#EditMarque').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la mise à jour de la marque.',
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

            // Image preview for edit modal
            $('#edit_marqueImage').on('change', function (event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#edit_marqueImagePreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $('#edit_marqueImagePreview').attr('src', '').hide();
                }
            });

            // Delete Record
            $('#marquesTable').on('click', '.delete-record', function () {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression de la marque est irréversible. Voulez-vous continuer ?",
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
                            url: "{{ route('superadmin.marques.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                dt_marques.row(row).remove().draw();
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimée !',
                                    text: data.message || 'La marque a été supprimée.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            },
                            error: function (xhr) {
                                console.error('Delete error:', xhr.responseText);
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
                            text: 'La marque n\'a pas été supprimée.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            feather.replace();

            setTimeout(() => {
                $('.dataTables_filter .form-control').removeClass('form-control-sm');
                $('.dataTables_length .form-select').removeClass('form-select-sm');
            }, 300);
        });
    </script>
@endsection