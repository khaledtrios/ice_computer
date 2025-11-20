@extends('admin.layouts.app')

@section('title', 'Liste des Boutiques | model-itech')
 
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
                <h3>Liste des Boutiques</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary cursor-[pointer]" type="button" data-bs-toggle="modal"
                        data-bs-target="#CreateBoutique">
                        <i class="fa-solid fa-plus me-2"></i>Créer une boutique
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="boutiquesTable">
                            <thead>
                                <tr>
                                    <th>Nom Boutique</th>
                                    <th>Ville</th>
                                    <th>Code Postal</th>
                                    <th>SIRET</th>
                                    <th>Type Config</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal pour créer une boutique -->
            <div class="modal fade" id="CreateBoutique" tabindex="-1" role="dialog" aria-labelledby="CreateBoutiqueLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="CreateBoutiqueLabel">Créer une boutique</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="createBoutiqueForm" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="first_name">Nom Utilisateur</label>
                                    <input class="form-control" id="first_name" name="first_name" type="text"
                                        placeholder="Entrez le nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="last_name">Prénom Utilisateur</label>
                                    <input class="form-control" id="last_name" name="last_name" type="text"
                                        placeholder="Entrez le prénom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email Utilisateur</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="Entrez l'email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Mot de passe</label>
                                    <input class="form-control" id="password" name="password" type="password"
                                        placeholder="Entrez le mot de passe" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="confirm_password">Confirmation Mot de passe</label>
                                    <input class="form-control" id="confirm_password" name="confirm_password"
                                        type="password" placeholder="Confirmez le mot de passe" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueName">Nom Boutique</label>
                                    <input class="form-control" id="boutiqueName" name="nom_boutique" type="text"
                                        placeholder="Entrez le nom de la boutique" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueTelephone">Téléphone</label>
                                    <input class="form-control" id="boutiqueTelephone" name="telephone" type="text"
                                        placeholder="Entrez le téléphone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueCity">Ville</label>
                                    <input class="form-control" id="boutiqueCity" name="city" type="text"
                                        placeholder="Entrez la ville">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueCodePostal">Code Postal</label>
                                    <input class="form-control" id="boutiqueCodePostal" name="code_postal" type="text"
                                        placeholder="Entrez le code postal">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueSiret">SIRET</label>
                                    <input class="form-control" id="boutiqueSiret" name="siret" type="text"
                                        placeholder="Entrez le SIRET">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="boutiqueCompany">Entreprise</label>
                                    <input class="form-control" id="boutiqueCompany" name="company" type="text"
                                        placeholder="Entrez le nom de l'entreprise">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="saveBoutique">Créer la boutique</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal pour modifier une boutique -->
            <div class="modal fade" id="EditBoutique" tabindex="-1" role="dialog" aria-labelledby="EditBoutiqueLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="EditBoutiqueLabel">Modifier une boutique</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="editBoutiqueForm" class="row g-3">
                                <input type="hidden" id="edit_boutique_id" name="id">
                                <input type="hidden" name="_method" value="PUT">
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_first_name">Nom Utilisateur</label>
                                    <input class="form-control" id="edit_first_name" name="first_name" type="text"
                                        placeholder="Entrez le nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_last_name">Prénom Utilisateur</label>
                                    <input class="form-control" id="edit_last_name" name="last_name" type="text"
                                        placeholder="Entrez le prénom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_email">Email Utilisateur</label>
                                    <input class="form-control" id="edit_email" name="email" type="email"
                                        placeholder="Entrez l'email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_password">Mot de passe (laisser vide pour ne pas
                                        changer)</label>
                                    <input class="form-control" id="edit_password" name="password" type="password"
                                        placeholder="Entrez le nouveau mot de passe">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueName">Nom Boutique</label>
                                    <input class="form-control" id="edit_boutiqueName" name="nom_boutique" type="text"
                                        placeholder="Entrez le nom de la boutique" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueTelephone">Téléphone</label>
                                    <input class="form-control" id="edit_boutiqueTelephone" name="telephone" type="text"
                                        placeholder="Entrez le téléphone">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueCity">Ville</label>
                                    <input class="form-control" id="edit_boutiqueCity" name="city" type="text"
                                        placeholder="Entrez la ville">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueCodePostal">Code Postal</label>
                                    <input class="form-control" id="edit_boutiqueCodePostal" name="code_postal" type="text"
                                        placeholder="Entrez le code postal">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueSiret">SIRET</label>
                                    <input class="form-control" id="edit_boutiqueSiret" name="siret" type="text"
                                        placeholder="Entrez le SIRET">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="edit_boutiqueCompany">Entreprise</label>
                                    <input class="form-control" id="edit_boutiqueCompany" name="company" type="text"
                                        placeholder="Entrez le nom de l'entreprise">
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="updateBoutique">Mettre à jour</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal pour se connecter en tant que boutique -->
            <div class="modal fade" id="ConnectBoutique" tabindex="-1" role="dialog" aria-labelledby="ConnectBoutiqueLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="ConnectBoutiqueLabel">Se connecter en tant que boutique</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Vous êtes sur le point de vous connecter en tant que la boutique <strong
                                    id="connect_boutique_name"></strong>. Voulez-vous continuer ?</p>
                            <input type="hidden" id="connect_boutique_id">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-success" type="button" id="confirmConnectBoutique">Se connecter</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal pour réinitialiser la configuration -->
            <div class="modal fade" id="ResetConfigBoutique" tabindex="-1" role="dialog"
                aria-labelledby="ResetConfigBoutiqueLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="ResetConfigBoutiqueLabel">Réinitialiser la configuration</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Vous êtes sur le point de réinitialiser la configuration de la boutique <strong
                                    id="reset_boutique_name"></strong>. Cette action est irréversible. Voulez-vous continuer
                                ?</p>
                            <input type="hidden" id="reset_boutique_id">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-warning" type="button" id="confirmResetConfig">Réinitialiser</button>
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
            var dt_boutique_table = $('#boutiquesTable');
            if (dt_boutique_table.length) {
                var dt_boutiques = dt_boutique_table.DataTable({
                    processing: true,
                    serverSide: true,
                    
                    ajax: {
                        url: "{{ route('superadmin.api.boutiques') }}",
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
                        { data: 'nom_boutique' },
                        { data: 'city' },
                        { data: 'code_postal' },
                        { data: 'siret' },
                        { data: 'config_type' },
                        { data: 'statut' },
                        { data: null, orderable: false, searchable: false },
                    ],
                    columnDefs: [
                        {
                            targets: 5,
                            render: function (data, type, full) {
                                var isActive = full.statut === 'Actif';
                                return `
                                               <div class="form-check form-switch d-flex justify-content-center">
            <input class="form-check-input toggle-status" type="checkbox" 
                   data-id="${encodeURIComponent(full.id)}" 
                   ${isActive ? 'checked' : ''} 
                   role="switch" style="width: 40px; height: 20px;">
        </div>
                                            `;
                            }
                        },
                        {
                            targets: 6,
                            render: function (data, type, full) {
                                return `
                                                        <ul class="action d-flex align-items-center list-unstyled gap-2 m-0">
                                                            <li>
                                                                <a href="javascript:;" data-id="${encodeURIComponent(full.id)}" 
                                                                   class="btn btn-sm btn-icon btn-primary edit-record" 
                                                                   title="Modifier">
                                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;" data-id="${encodeURIComponent(full.id)}" 
                                                                   class="btn btn-sm btn-icon btn-danger delete-record" 
                                                                   title="Supprimer">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;" data-id="${encodeURIComponent(full.id)}" 
                                                                   data-name="${encodeURIComponent(full.nom_boutique)}"
                                                                   class="btn btn-sm btn-icon btn-success connect-as-shop" 
                                                                   title="Se connecter en tant que boutique">
                                                                    <i class="fa-solid fa-shop"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;" data-id="${encodeURIComponent(full.id)}" 
                                                                   data-name="${encodeURIComponent(full.nom_boutique)}"
                                                                   class="btn btn-sm btn-icon btn-warning reset-shop-config" 
                                                                   title="Réinitialiser la configuration">
                                                                    <i class="fa-solid fa-rotate"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    `;
                            }
                        }
                    ],
                    order: [[0, 'asc']],
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

            // Create Boutique
            $('#saveBoutique').on('click', function () {
                var form = $('#createBoutiqueForm');
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();

                if (password !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Les mots de passe ne correspondent pas.',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                    return;
                }

                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.boutiques.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#CreateBoutique').modal('hide');
                            cleanModalBackdrop();
                            dt_boutiques.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Création réussie !',
                                text: data.message || 'La boutique a été créée avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            $('#CreateBoutique').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la création de la boutique.',
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

            // Edit Boutique
            $('#boutiquesTable').on('click', '.edit-record', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('superadmin.boutiques.edit', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#edit_boutique_id').val(data.boutique.id);
                        $('#edit_first_name').val(data.user.first_name);
                        $('#edit_last_name').val(data.user.last_name);
                        $('#edit_email').val(data.user.email);
                        $('#edit_password').val('');
                        $('#edit_boutiqueName').val(data.boutique.nom_boutique);
                        $('#edit_boutiqueTelephone').val(data.boutique.telephone);
                        $('#edit_boutiqueCity').val(data.boutique.city);
                        $('#edit_boutiqueCodePostal').val(data.boutique.code_postal);
                        $('#edit_boutiqueSiret').val(data.boutique.siret);
                        $('#EditBoutique').modal('show');
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

            // Update Boutique
            $('#updateBoutique').on('click', function () {
                var form = $('#editBoutiqueForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('superadmin.boutiques.update', ':id') }}".replace(':id', $('#edit_boutique_id').val()),
                        type: "POST", // Use POST with _method=PUT for Laravel compatibility
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#EditBoutique').modal('hide');
                            cleanModalBackdrop();
                            dt_boutiques.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message || 'La boutique a été mise à jour avec succès.',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            $('#EditBoutique').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la mise à jour de la boutique.',
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

            // Connect as Boutique
            $('#boutiquesTable').on('click', '.connect-as-shop', function () {
                var id = $(this).data('id');
                var name = decodeURIComponent($(this).data('name'));
                $('#connect_boutique_id').val(id);
                $('#connect_boutique_name').text(name);
                $('#ConnectBoutique').modal('show');
            });

            $('#confirmConnectBoutique').on('click', function () {
                var id = $('#connect_boutique_id').val();
                $.ajax({
                    url: "{{ route('superadmin.boutiques.login', ':id') }}".replace(':id', id),
                    type: "POST",
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#ConnectBoutique').modal('hide');
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'success',
                            title: 'Connecté !',
                            text: data.message,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(() => {
                            window.location.href = "{{ route('home') }}";
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        $('#ConnectBoutique').modal('hide');
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la connexion.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });

            // Reset Config
            $('#boutiquesTable').on('click', '.reset-shop-config', function () {
                var id = $(this).data('id');
                var name = decodeURIComponent($(this).data('name'));
                $('#reset_boutique_id').val(id);
                $('#reset_boutique_name').text(name);
                $('#ResetConfigBoutique').modal('show');
            });

            $('#confirmResetConfig').on('click', function () {
                var id = $('#reset_boutique_id').val();
                $.ajax({
                    url: "{{ route('superadmin.boutiques.reset-config', ':id') }}".replace(':id', id),
                    type: "POST",
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#ResetConfigBoutique').modal('hide');
                        cleanModalBackdrop();
                        dt_boutiques.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Réinitialisée !',
                            text: data.message || 'La configuration de la boutique a été réinitialisée.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        $('#ResetConfigBoutique').modal('hide');
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la réinitialisation.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });

            // Delete Record
            $('#boutiquesTable').on('click', '.delete-record', function () {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression de la boutique est irréversible. Voulez-vous continuer ?",
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
                            url: "{{ route('superadmin.boutiques.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                dt_boutiques.row(row).remove().draw();
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Supprimée !',
                                    text: data.message || 'La boutique a été supprimée.',
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
                            text: 'La boutique n\'a pas été supprimée.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            // Toggle Status Handler
            $('#boutiquesTable').on('change', '.toggle-status', function () {
                var id = $(this).data('id');
                var isChecked = $(this).is(':checked');
                var newStatus = isChecked ? 'Actif' : 'Inactif';
                var row = $(this).closest('tr');

                $.ajax({
                    url: "{{ route('superadmin.boutiques.toggle-status', ':id') }}".replace(':id', id),
                    type: "POST",
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "statut": newStatus
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Statut mis à jour !',
                            text: data.message || `La boutique a été ${newStatus.toLowerCase()} avec succès. Un email a été envoyé.`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        dt_boutiques.ajax.reload(); // Reload pour refléter les changements
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        // Revert checkbox state on error
                        $(this).prop('checked', !isChecked);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.message || 'Une erreur s\'est produite lors de la mise à jour du statut.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });
            // Handle modal close events to ensure backdrop is removed
            $('#CreateBoutique, #EditBoutique, #ConnectBoutique, #ResetConfigBoutique').on('hidden.bs.modal', function () {
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