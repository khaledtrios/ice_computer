@extends('admin.layouts.app')

@section('title', 'Liste des Modèles | model-itech')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/type" href="{{ asset('assets/css/responsive.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <h3>Liste des Modèles</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#CreateModele">
                        <i class="fa-solid fa-plus me-2"></i>Créer un modèle
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="filterMateriel">Filtrer par Matériel</label>
                            <select id="filterMateriel" class="form-select">
                                <option value="">Tous les matériels</option>
                                @foreach ($matriels as $materiel)
                                    <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="filterMarque">Filtrer par Marque</label>
                            <select id="filterMarque" class="form-select">
                                <option value="">Toutes les marques</option>
                                @foreach ($marques as $marque)
                                    <option value="{{ $marque->id }}">
                                        {{ $marque->nom_marques }} ({{ $marque->materiel->nom_materiel ?? '' }})
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="modelesTable">
                            <thead>
                                <tr>
                                    <th>Nom Modèle</th>
                                    <th>Image</th>
                                    <th>Priorité</th>
                                    <th>Marque</th>
                                    <th>Boutique</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal pour créer un modèle -->
            <div class="modal fade" id="CreateModele" tabindex="-1" role="dialog" aria-labelledby="CreateModeleLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="CreateModeleLabel">Créer un modèle</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="createModeleForm" class="row g-3" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label class="form-label" for="modeleName">Nom Modèle</label>
                                    <input class="form-control" id="modeleName" name="nom_modele" type="text"
                                        placeholder="Entrez le nom du modèle" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modeleImage">Image</label>
                                    <input class="form-control" id="modeleImage" name="image" type="file" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modelePriorite">Priorité</label>
                                    <input class="form-control" id="modelePriorite" name="priorite" type="number" min="0"
                                        placeholder="Entrez la priorité" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="marqueId">Marque</label>
                                    <select class="form-control" id="marqueId" name="marque_id" required>
                                        <option value="">Sélectionnez une marque</option>
                                        @foreach ($marques as $marque)
                                            <option value="{{ $marque->id }}">
                                                {{ $marque->nom_marques }}
                                                ({{ $marque->materiel?->nom_materiel ?? 'Aucun matériel' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueId">Boutique</label>
                                    <select class="form-control" id="boutiqueId" name="boutique_id">
                                        <option value="">Sélectionnez une boutique (optionnel)</option>
                                        @foreach ($boutiques as $boutique)
                                            <option value="{{ $boutique->id }}">{{ $boutique->nom_boutique }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="saveModele">Créer le modèle</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal pour modifier un modèle -->
            <div class="modal fade" id="EditModele" tabindex="-1" role="dialog" aria-labelledby="EditModeleLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="EditModeleLabel">Modifier un modèle</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="editModeleForm" class="row g-3" enctype="multipart/form-data">
                                <input type="hidden" id="edit_modele_id" name="id">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_modeleName">Nom Modèle</label>
                                    <input class="form-control" id="edit_modeleName" name="nom_modele" type="text"
                                        placeholder="Entrez le nom du modèle" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_modeleImage">Image</label>
                                    <input class="form-control" id="edit_modeleImage" name="image" type="file"
                                        accept="image/*">
                                    <img id="edit_modeleImagePreview" src="" alt="Aperçu"
                                        style="max-width: 100px; max-height: 100px; display: none; margin-top: 10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_modelePriorite">Priorité</label>
                                    <input class="form-control" id="edit_modelePriorite" name="priorite" type="number"
                                        min="0" placeholder="Entrez la priorité" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_marqueId">Marque</label>
                                    <select class="form-control" id="edit_marqueId" name="marque_id" required>
                                        <option value="">Sélectionnez une marque</option>
                                        @foreach ($marques as $marque)
                                            <option value="{{ $marque->id }}">
                                                {{ $marque->nom_marques }}
                                                @if($marque->materiel)
                                                    ({{ $marque->materiel->nom_materiel }})
                                                @else
                                                    (Aucun matériel)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueId">Boutique</label>
                                    <select class="form-control" id="edit_boutiqueId" name="boutique_id">
                                        <option value="">Sélectionnez une boutique (optionnel)</option>
                                        @foreach ($boutiques as $boutique)
                                            <option value="{{ $boutique->id }}">{{ $boutique->nom_boutique }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="updateModele">Mettre à jour</button>
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
            // Initialize Select2 for filters
            $('#filterMateriel, #filterMarque').select2({
                placeholder: "Sélectionnez...",
                allowClear: true
            });

            var dt_modele_table = $('#modelesTable');
            if (dt_modele_table.length) {
                var dt_modeles = dt_modele_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('superadmin.api.getModeles') }}",
                        type: "GET",
                        data: function (d) {
                            d.materiel_id = $('#filterMateriel').val();
                            d.marque_id = $('#filterMarque').val();
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
                        { data: 'nom_modele' },
                        { data: 'image' },
                        { data: 'priorite' },
                        { data: 'marque' },
                        { data: 'boutique' },
                        { data: 'created_at' },
                        { data: null, orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            render: function (data, type, full) {
                                return full.image ? '<img src="' + full.image + '" alt="Modèle" loading="lazy" style="max-width: 50px; max-height: 50px;">' : 'N/A';
                            }
                        },
                        {
                            targets: 3,
                            render: function (data, type, full) {
                                if (full.marque || full.materiel) {
                                    let marqueBadge = full.marque
                                        ? '<span class="badge bg-primary me-1">' + full.marque + '</span>'
                                        : '';
                                    let materielBadge = full.materiel
                                        ? '<span class="badge bg-success">' + full.materiel + '</span>'
                                        : '';
                                    return marqueBadge + materielBadge;
                                } else {
                                    return '<span class="text-muted">N/A</span>';
                                }
                            }
                        },

                        {
                            targets: 4,
                            render: function (data, type, full) {
                                return full.boutique || 'N/A';
                            }
                        },
                        {
                            targets: 6,
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
                    order: [[5, 'desc']],
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
                $('#filterMateriel, #filterMarque').on('change', function () {
                    dt_modeles.ajax.reload();
                });
            }

            // Initialize Select2 in Create Modal
            $('#CreateModele').on('shown.bs.modal', function () {
                $('#marqueId, #boutiqueId').select2({
                    placeholder: "Sélectionnez...",
                    allowClear: true,
                    dropdownParent: $('#CreateModele')
                });
            });

            // Initialize Select2 in Edit Modal
            $('#EditModele').on('shown.bs.modal', function () {
                $('#edit_marqueId, #edit_boutiqueId').select2({
                    placeholder: "Sélectionnez...",
                    allowClear: true,
                    dropdownParent: $('#EditModele')
                });
            });

            // Destroy Select2 on modal hide
            $('#CreateModele, #EditModele').on('hidden.bs.modal', function () {
                $(this).find('select').select2('destroy');
                cleanModalBackdrop();
            });

            // Create Modele
            $('#saveModele').on('click', function () {
                var form = $('#createModeleForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.modeles.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#CreateModele').modal('hide');
                            dt_modeles.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Créé !',
                                text: data.message || 'Le modèle a été créé avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                            $('#marqueId, #boutiqueId').val(null).trigger('change');
                        },
                        error: function (xhr) {
                            console.error('Create error:', xhr.responseText);
                            $('#CreateModele').modal('hide');
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.error || 'Une erreur s\'est produite lors de la création du modèle.',
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

            // Edit Modele
            $('#modelesTable').on('click', '.edit-record', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('superadmin.modeles.edit', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#edit_modele_id').val(data.modele.id);
                        $('#edit_modeleName').val(data.modele.nom_modele);
                        $('#edit_modelePriorite').val(data.modele.priorite);
                        if (data.modele.image) {
                            $('#edit_modeleImagePreview').attr('src', data.modele.image).show();
                        } else {
                            $('#edit_modeleImagePreview').hide();
                        }
                        $('#EditModele').modal('show');
                        // Set values after modal shown and select2 initialized
                        setTimeout(function () {
                            $('#edit_marqueId').val(data.modele.marque_id).trigger('change');
                            $('#edit_boutiqueId').val(data.modele.boutique_id || '').trigger('change');
                        }, 100);
                    },
                    error: function (xhr) {
                        console.error('Edit error:', xhr.responseText);
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.error || 'Une erreur s\'est produite lors de la récupération des données.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });

            // Update Modele
            $('#updateModele').on('click', function () {
                var form = $('#editModeleForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.modeles.update', ':id') }}".replace(':id', $('#edit_modele_id').val()),
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#EditModele').modal('hide');
                            dt_modeles.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message || 'Le modèle a été mis à jour avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                            $('#edit_marqueId, #edit_boutiqueId').val(null).trigger('change');
                            $('#edit_modeleImagePreview').hide();
                        },
                        error: function (xhr) {
                            console.error('Update error:', xhr.responseText);
                            $('#EditModele').modal('hide');
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.error || 'Une erreur s\'est produite lors de la mise à jour du modèle.',
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
            $('#edit_modeleImage').on('change', function (event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#edit_modeleImagePreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $('#edit_modeleImagePreview').hide();
                }
            });

            // Delete Record
            $('#modelesTable').on('click', '.delete-record', function () {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression du modèle est irréversible. Voulez-vous continuer ?",
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
                            url: "{{ route('superadmin.modeles.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                dt_modeles.row(row).remove().draw();
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimé !',
                                    text: data.message || 'Le modèle a été supprimé.',
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
                                    text: xhr.responseJSON?.error || 'Une erreur s\'est produite lors de la suppression.',
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
                            text: 'Le modèle n\'a pas été supprimé.',
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