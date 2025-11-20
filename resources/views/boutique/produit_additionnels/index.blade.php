@extends('boutique.layouts.app')

@section('title', 'Liste des Tickets | Boutique')

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
                <h3>Liste des produits additionnels</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Liste des produits additionnel</h5>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#CreateProduct">
                        <i class="fa-solid fa-plus"></i> Créer un Produit
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-scrollbar">
                        <table class="display table-striped" id="produitsTable">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Matériel</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Create Ticket Modal -->
            <div class="modal fade" id="CreateProduct" tabindex="-1" role="dialog" aria-labelledby="CreateProductLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="CreateProductLabel">Créer un produit</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="CreateProductForm" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label" for="materielId">Matériel</label>
                                    <select class="form-control" id="materielId" name="materiel_id" required>
                                        <option value="">Sélectionnez un matériel</option>
                                        @foreach ($matriels as $materiel)
                                            <option value="{{ $materiel->id }}">{{ $materiel->nom_materiel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="ticketObjet">nom du produit</label>
                                    <input class="form-control" id="ticketObjet" name="name" type="text"
                                        placeholder="Entrez l'e nom du produit" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="ticketMessage">description</label>
                                    <textarea class="form-control" id="ticketMessage" name="description" rows="3" placeholder="Entrez la description"
                                        required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="materielImage">Prix</label>
                                    <input class="form-control" id="materielImage" name="price" type="number" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="materielImage">Image</label>
                                    <input class="form-control" id="materielImage" name="image" type="file"
                                        accept="image/*" required>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-primary" type="button" id="saveTicket">Créer le ticket</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Ticket Modal -->
            <div class="modal fade" id="EditProduct" tabindex="-1" role="dialog" aria-labelledby="EditTicketLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="mb-0" id="EditTicketLabel">Modifier un Ticket</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-input">
                            <form id="editProduitForm" class="row g-3" enctype="multipart/form-data">
                                
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

        function cleanModalBackdrop() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }

        $(document).ready(function() {
            var dt_ticket_table = $('#produitsTable');
            if (dt_ticket_table.length) {
                var dt_tickets = dt_ticket_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('boutique.apigetproduitadditionnels') }}",
                        type: "GET",
                        error: function(xhr) {
                            console.error('DataTables AJAX error:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur de chargement',
                                text: 'Impossible de charger les données.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'materiel_id'
                        },
                        {
                            data: 'image'
                        },
                        {
                            data: 'price'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                    ],
                    columnDefs: [{
                            targets: 3,
                            render: function(data, type, full) {
                                return ('<img src="' + data + '" class="img-thumbnail">');
                            }
                        },
                        {
                            targets: -1,
                            render: function(data, type, full) {
                                var linkShow = '{{ route('boutique.tikets.show', ':id') }}'
                                    .replace(':id', encodeURIComponent(full.id));
                                return (
                                    '<ul class="action d-flex align-items-center list-unstyled gap-2 m-0">' +
                                    '<li><a href="javascript:;" class="btn btn-sm btn-icon btn-info edit-product" title="Modifier le produit" data-id="' + encodeURIComponent(full.id) +'"><i class="fa-solid fa-edit"></i></a></li>' +
                                    '<li><a href="javascript:;" data-id="' + encodeURIComponent(
                                        full.id) +
                                    '" class="btn btn-sm btn-icon btn-danger delete-record" title="Supprimer"><i class="fa-solid fa-trash-can"></i></a></li>' +
                                    '</ul>'
                                );
                            }
                        }
                    ],
                    order: [
                        [5, 'desc']
                    ],
                    dom: '<"card-header d-flex flex-column flex-md-row align-items-start align-items-md-center"<f><"d-flex align-items-md-center justify-content-md-end mt-2 mt-md-0 gap-2"l<"dt-action-buttons">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    lengthMenu: [10, 20, 30, 40],
                    language: {
                        sEmptyTable: "Aucune donnée disponible",
                        sInfo: "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
                        sInfoEmpty: "Affichage de 0 à 0 sur 0 élément",
                        sInfoFiltered: "(filtré à partir de _MAX_ éléments)",
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
                        searchPlaceholder: "Rechercher..."
                    }
                });
            }

            // Create Ticket
            $('#saveTicket').on('click', function() {
                var form = $('#CreateProductForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    $.ajax({
                        url: "{{ route('boutique.produit-additionnels.store') }}",
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('#CreateProduct').modal('hide');
                            cleanModalBackdrop();
                            dt_tickets.ajax.reload();
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
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $('#CreateProduct').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message ||
                                    'Une erreur s\'est produite.',
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
            $('#CreateProduct').on('click', '.edit-record', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('boutique.tikets.show', ':id') }}".replace(':id', id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('.edit_ticket_id').val(data.ticket.id);
                        $('#edit_ticketObjet').val(data.ticket.objet);
                        $('#edit_ticketMessage').val(data.ticket.message);
                        $('#edit_ticketStatus').val(data.ticket.status ? 'Ouvert' : 'Fermé');
                        $('#EditTicket').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.message ||
                                'Une erreur s\'est produite.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }
                });
            });

            // Update Ticket
            $('#updateTicket').on('click', function() {
               var id = $('.edit_produit_id').val();
                var form = $('#editProduitForm');
                if (form[0].checkValidity()) {
                    var formData = new FormData(form[0]);
                    formData.append('_method', 'PUT');
                    $.ajax({
                        url: "{{ route('boutique.produit-additionnels.update', ':id') }}".replace(':id', id),
                        type: "POST",
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('#EditProduct').modal('hide');
                            
                            dt_tickets.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Mise à jour !',
                                text: data.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            form[0].reset();
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $('#EditProduct').modal('hide');
                            cleanModalBackdrop();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message ||
                                    'Une erreur s\'est produite.',
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
            $('body').on('click', '.delete-record', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression est irréversible.",
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
                            url: "{{ route('boutique.produit-additionnels.destroy', ':id') }}"
                                .replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                dt_tickets.row(row).remove().draw();
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
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: xhr.responseJSON?.message ||
                                        'Une erreur s\'est produite.',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        });
                    } else {
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'info',
                            title: 'Annulé',
                            text: 'Le produit n\'a pas été supprimé.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            // edit Produit
            $('body').on('click', '.edit-product', function() {
                var id = $(this).data('id');
                $("#editProduitForm").load("{{ route('boutique.produit-additionnels.edit', ':id') }}".replace(
                        ':id', id), function(response){ 
                            $("#EditProduct").modal('show')
                        })
                 
            });

            // Delete Produit
            $('body').on('click', '.delete-record', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "La suppression est irréversible.",
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
                            url: "{{ route('boutique.produit-additionnels.destroy', ':id') }}"
                                .replace(':id', id),
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                dt_tickets.row(row).remove().draw();
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
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                cleanModalBackdrop();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: xhr.responseJSON?.message ||
                                        'Une erreur s\'est produite.',
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
                        });
                    } else {
                        cleanModalBackdrop();
                        Swal.fire({
                            icon: 'info',
                            title: 'Annulé',
                            text: 'Le produit n\'a pas été supprimé.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $('#CreateProduct, #EditTicket').on('hidden.bs.modal', function() {
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
