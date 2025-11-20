@extends('admin.layouts.app')

@section('title', 'Liste des Matériels | model-itech')

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
                <h3>Liste des Matériels</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary cursor-pointer" type="button" data-bs-toggle="modal" data-bs-target="#CreateMateriel">
                        <i class="fa-solid fa-plus me-2"></i>Créer un matériel
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="materielsTable">
                            <thead>
                                <tr>
                                    <th>Nom Matériel</th>
                                    <th>Image</th>
                                    <th>Priorité</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal pour créer un matériel -->
            <div class="modal fade" id="CreateMateriel" tabindex="-1" role="dialog" aria-labelledby="CreateMaterielLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="CreateMaterielLabel">Créer un matériel</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="createMaterielForm" class="row g-3" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label class="form-label" for="materielName">Nom Matériel</label>
                                    <input class="form-control" id="materielName" name="nom_materiel" type="text"
                                        placeholder="Entrez le nom du matériel" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="materielImage">Image</label>
                                    <input class="form-control" id="materielImage" name="image" type="file"
                                        accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="materielPriorite">Priorité</label>
                                    <input class="form-control" id="materielPriorite" name="priorite" type="number" min="0"
                                        placeholder="Entrez la priorité" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="saveMateriel">Créer le matériel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal pour modifier un matériel -->
            <div class="modal fade" id="EditMateriel" tabindex="-1" role="dialog" aria-labelledby="EditMaterielLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="EditMaterielLabel">Modifier un matériel</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="editMaterielForm" class="row g-3" enctype="multipart/form-data">
                                <input type="hidden" id="edit_materiel_id" name="id">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_materielName">Nom Matériel</label>
                                    <input class="form-control" id="edit_materielName" name="nom_materiel" type="text"
                                        placeholder="Entrez le nom du matériel" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_materielImage">Image</label>
                                    <input class="form-control" id="edit_materielImage" name="image" type="file"
                                        accept="image/*">
                                    <img id="edit_materielImagePreview" src="" alt="Aperçu"
                                        style="max-width: 100px; max-height: 100px; display: none; margin-top: 10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_materielPriorite">Priorité</label>
                                    <input class="form-control" id="edit_materielPriorite" name="priorite" type="number"
                                        min="0" placeholder="Entrez la priorité" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="updateMateriel">Mettre à jour</button>
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

        function cleanModalBackdrop() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }

        $(document).ready(function () {
            var dt_materiel_table = $('#materielsTable');
            if (dt_materiel_table.length) {
                var dt_materiels = dt_materiel_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('superadmin.api.getMateriels') }}",
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
                        { data: 'nom_materiel' },
                        { data: 'image' },
                        { data: 'priorite' },
                        { data: 'created_at' },
                        { data: null, orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            render: function (data, type, full) {
                                return full.image ? '<img src="' + full.image + '" alt="Matériel" style="max-width: 50px; max-height: 50px;">' : 'N/A';
                            }
                        },
                        {
                            targets: 3,
                            render: function (data, type, full) {
                                return new Date(full.created_at).toLocaleDateString('fr-FR', { 
                                    year: 'numeric', 
                                    month: 'short', 
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            }
                        },
                        {
                            targets: 4,
                            render: function (data, type, full) {
                                return (
                                    '<ul class="action d-flex align-items-center list-unstyled gap-2 m-0">' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(full.id) + '" class="btn btn-sm btn-icon btn-primary edit-record" title="Modifier"><i class="fa-regular fa-pen-to-square"></i></a></li>' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(full.id) + '" class="btn btn-sm btn-icon btn-danger delete-record" title="Supprimer"><i class="fa-solid fa-trash-can"></i></a></li>' +
                                    '</ul>'
                                );
                            }
                        }
                    ],
                    order: [[3, 'desc']],
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

            // Create Materiel
            $('#saveMateriel').on('click', function () {
                var form = $('#createMaterielForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.materiels.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#CreateMateriel').modal('hide');
                            cleanModalBackdrop();
                            dt_materiels.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Créé !',
                                text: data.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            $('#CreateMateriel').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la création du matériel.',
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

            $('#materielsTable').on('click', '.edit-record', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('superadmin.materiels.edit', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log("edit_materiel_id",data);
                        $('#edit_materiel_id').val(data.materiel.id);
                        $('#edit_materielName').val(data.materiel.nom_materiel);
                        $('#edit_materielPriorite').val(data.materiel.priorite);
                        if (data.materiel.image) {
                            $('#edit_materielImagePreview').attr('src', data.materiel.image).show();
                        } else {
                            $('#edit_materielImagePreview').hide();
                        }
                        $('#EditMateriel').modal('show');
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

            $('#updateMateriel').on('click', function () {
                var form = $('#editMaterielForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.materiels.update', ':id') }}".replace(':id', $('#edit_materiel_id').val()),
                        type: "POST", 
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#EditMateriel').modal('hide');
                            cleanModalBackdrop();
                            dt_materiels.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                            $('#edit_materielImagePreview').hide();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            $('#EditMateriel').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la mise à jour du matériel.',
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
            $('#materielsTable').on('click', '.delete-record', function () {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression du matériel est irréversible. Voulez-vous continuer ?",
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
                            url: "{{ route('superadmin.materiels.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                dt_materiels.row(row).remove().draw();
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimé !',
                                    text: data.message,
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
                            text: 'Le matériel n\'a pas été supprimé.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $('#CreateMateriel, #EditMateriel').on('hidden.bs.modal', function () {
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