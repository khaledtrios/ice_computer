@extends('boutique.layouts.app')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        #pannes-table input {
            width: 100%;
            box-sizing: border-box;
        }

        #pannes-table input.prix-input {
            width: 130px !important;
        }

        #pannes-table input.remise-input {
            width: 110px !important;
        }

        .total-cell {
            font-weight: bold;
            color: #46d8d5;
        }

        .table-final {
            background-color: #f8f9fa;
        }

        .final-ttc {
            background-color: #46d8d5 !important;
            color: white;
            font-weight: bold;
        }

        .swal2-container .swal2-actions .swal2-confirm {
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Liste des {{ $config_type ?? 'Demandes' }}</h5>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="demandesTable">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Numéro</th>
                                    <th>Client</th>
                                    <th>Téléphone</th>
                                    <th>E-mail</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Détail Devis -->
            <div class="modal fade" id="detailModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white">Détail du Devis</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Infos Client & Appareil -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Client</h6>
                                    <p><strong>Nom :</strong> <span id="client-nom"></span></p>
                                    <p><strong>Tél :</strong> <span id="client-phone"></span></p>
                                    <p><strong>Email :</strong> <span id="client-mail"></span></p>
                                    <br>
                                    <p><strong>Magazin :</strong> <span id="demande-magazin"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Appareil</h6>
                                    <p><strong>Matériel :</strong> <span id="materiel-name"></span></p>
                                    <p><strong>Marque :</strong> <span id="marque-name"></span></p>
                                    <p><strong>Modèle :</strong> <span id="modele-name"></span></p>
                                </div>
                            </div>

                            @if ($config_type == 'Rendez-vous')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Date & Heure de rendez-vous</label>
                                        <input type="datetime-local" id="rdv-date" class="form-control">
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Commentaire</label>
                                <textarea id="commentaire" class="form-control" rows="3" placeholder="Ajoutez un commentaire..."></textarea>
                            </div>

                            <!-- Tableau des pannes -->
                            <h6 class="text-muted mb-3">Réparations</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-bordered" id="pannes-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Panne</th>
                                            <th>Prix (€)</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <!-- Totaux -->
                            <div class="row">
                                <div class="col-md-6">
                                    <!--<label class="form-label">Remise Globale (€ TTC)</label>
                                    <input type="number" id="global-remise" class="form-control" value="0.00" min="0" step="0.01">
                                    -->
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-final">

                                        <tr>
                                            <th>Sous Total</th>
                                            <td id="total-sub" class="text-end text-danger">0.00 €</td>
                                        </tr>

                                        <tr>
                                            <th>Remise online</th>
                                            <td id="total-remise_online" class="text-end text-danger">0.00 €</td>
                                        </tr>
                                        <tr id="reparation_domicile">
                                            <th class="extern_name"></th>
                                            <td id="total-reparation" class="text-end text-danger">0.00 €</td>
                                        </tr>
                                        <tr>
                                            <th>Remise Qualirepar</th>
                                            <td id="total-qualirepar" class="text-end text-danger">0.00 €</td>
                                        </tr>
                                        <tr class="final-ttc">
                                            <th>Total TTC</th>
                                            <td id="total-ttc" class="text-end">0.00 €</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" id="sendEmail">
                                <i class="fa fa-envelope"></i> Envoyer le devis par e-mail
                            </button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}

    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.select.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/select.bootstrap5.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        'use strict';

        const TVA_RATE = 0.20;

        function formatMoney(value) {
            return parseFloat(value || 0).toFixed(2);
        }

        function parsePanneText(text) {
            text = text.trim();
            if (!text) return {
                name: '',
                type: ''
            };
            const open = text.lastIndexOf('(');
            const close = text.lastIndexOf(')');
            if (open !== -1 && close !== -1 && close === text.length - 1) {
                return {
                    name: text.substring(0, open).trim(),
                    type: text.substring(open + 1, close).trim()
                };
            }
            return {
                name: text,
                type: ''
            };
        }

        function updateTotals() {
            let totalRemise = 0;
            let totalQualirepar = 0;
            let totalTTC = 0;
            let reparation_extern = 0;
            let reparation_extern_text = 0;

            $('#pannes-table tbody tr').each(function() {
                const $row = $(this);

                const qualireparMontant = parseFloat($row.find('input[name="qualirepar_montant"]').val()) || 0;
                const prixTTC = parseFloat($row.find('input[name="total_ttc_change"]').val()) || parseFloat($row
                    .find('input[name="total_ttc"]').val());
                const remiseOnline = parseFloat($row.find('input[name="remise_online"]').val()) || 0;
                reparation_extern = parseFloat($row.find('input[name="reparation_extern"]').val()) || 0;
                reparation_extern_text = $row.find('input[name="reparation_extern_label"]').val() || "";

                totalQualirepar = qualireparMontant;
                totalRemise += (prixTTC * (remiseOnline / 100));
                totalTTC += prixTTC

                console.log(totalRemise)
                // $row.find('.total-cell').text(formatMoney(ttcLigne));
            });

            //totalTTC += reparation_extern;

            // $('#total-ht').text(formatMoney(finalHT) + ' €');
            // $('#total-tva').text(formatMoney(finalTVA) + ' €');
            $('#total-sub').text(formatMoney(totalTTC) + ' €');
            $('#total-ttc').text(formatMoney((totalTTC + reparation_extern) - (totalQualirepar + totalRemise)) + ' €');


            //reparation_domicile
            if (reparation_extern > 0) {
                $('#reparation_domicile').show().find('.extern_name').text(reparation_extern_text);
                $('#reparation_domicile').find('#total-reparation').text(reparation_extern + ' €');
            } else
                $('#reparation_domicile').hide();

            if (totalQualirepar > 0)
                $('#total-qualirepar').text(formatMoney(totalQualirepar) + ' €').parent().show();
            else
                $('#total-qualirepar').text('0 €').parent().hide();

            console.log(totalTTC, totalRemise, totalQualirepar)
            if (totalRemise > 0)
                $('#total-remise_online').text(formatMoney(totalRemise) + ' €').parent().show();
            else
                $('#total-remise_online').text('0 €').parent().hide();


        }

        $(document).ready(function() {
            const table = $('#demandesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('boutique.demandes.data') }}",
                columns: [{
                        data: 'id',
                        visible: false
                    },
                    {
                        data: 'numero_devis',
                        defaultContent: 'N/A'
                    },
                    {
                        data: 'nom',
                        render: (data, type, row) => `${row.nom} ${row.prenom}`
                    },
                    {
                        data: 'telephone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'statut'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: null,
                        orderable: false
                    }
                ],
                columnDefs: [{
                    targets: -1,
                    render: function(data, type, row) {
                        const demandData = JSON.stringify({
                            id: row.id,
                            client: {
                                nom: row.nom,
                                prenom: row.prenom,
                                telephone: row.telephone,
                                email: row.email
                            },
                            materiel: row.materiel,
                            marque: row.marque,
                            modele: row.modele,
                            type: row.type,
                            date_rendez_vous: row.date_rendez_vous,
                            commentaire: row.commentaire,
                            magazin: row.magazin,
                            repair_options: row.repair_options || [],
                            produit_additionnel: row.produit_additionnel || [],
                            global_remise: row.global_remise || 0,
                            pannes: row.pannes || []
                        });

                        return `
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-info view-btn" data-demand="${encodeURIComponent(demandData)}">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>`;
                    }
                }],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
                },
                order: [
                    [0, 'desc']
                ],
                pageLength: 15
            });

            // Ouvrir le modal
            $('#demandesTable').on('click', '.view-btn', function() {
                const data = JSON.parse(decodeURIComponent($(this).data('demand')));
                console.log(data)
                 
                $('#client-nom').text(`${data.client.nom} ${data.client.prenom}`);
                $('#client-phone').text(data.client.telephone || 'N/A');
                $('#client-mail').text(data.client.email || 'N/A');
                $('#demande-magazin').text(data.magazin || 'N/A');
                $('#materiel-name').text(data.materiel);
                $('#marque-name').text(data.marque);
                $('#modele-name').text(data.modele);
                $('#rdv-date').val(data.date_rendez_vous?.slice(0, 16) || '');
                $('#commentaire').val(data.commentaire || '');
                $('#global-remise').val(formatMoney(data.global_remise));
                const type = data.type;
                const $tbody = $('#pannes-table tbody').empty();
                if (data.pannes && data.pannes.length > 0) {
                    data.pannes.forEach(p => {
                        const prix = formatMoney(p.price);
                        const prixHT = formatMoney(prix / (1 + TVA_RATE));
                        const remise = formatMoney(p.type.remise || 0);
                        const label = `${p.name || ''} ${p.type ? `(${p.type.nom})` : ''}`.trim();

                        $tbody.append(`
                    <tr>
                        <td>${$('<div>').text(label).html()}</td>
                         
                        <td>
                            <input type="hidden" name="qualirepar_montant" value="${p.type.montant}">
                            <input type="hidden" name="remise_online" value="${p.remiseOnline}">
                            <input type="hidden" name="reparation_extern" value="${data.repair_options?.price ?? 0}">
                            <input type="hidden" name="reparation_extern_label" value="${data.repair_options?.label ?? ""}">
                            <input type="hidden" name="total_ttc" value="${prix}">
                            ${type==0?`<span class="total-cell">${prix}</span> €`:
                            `<input type="number" step="0.1" class="form-control ttc-input"  name="total_ttc_change" value="${prix}">`}
                            
                        </td>
                    </tr>
                `);
                    });
                } else {
                    $tbody.append(
                        '<tr><td colspan="4" class="text-center text-muted">Aucune réparation</td></tr>'
                        );
                }

                if (data.produit_additionnel.hasOwnProperty('name')) {
                    $tbody.append(`
                    <tr>
                        <td>${$('<div>').text(data.produit_additionnel['name']).html()}</td>
                         
                        <td>
                            <input type="hidden" name="qualirepar_montant" value="0">
                            <input type="hidden" name="remise_online" value="0">
                            <input type="hidden" name="reparation_extern" value="0">
                            <input type="hidden" name="reparation_extern_label" value="0">
                            <input type="hidden" name="total_ttc" value="${data.produit_additionnel['price']}">
                            <span class="total-cell">${data.produit_additionnel['price']}</span> €                            
                        </td>
                    </tr>
                `);
                } 

                $('.ttc-input').off('input').on('input', updateTotals);
                updateTotals();
                $('#sendEmail').data('id', data.id);
                $('#detailModal').modal('show');
            });

            $('#sendEmail').on('click', function() {
                const id = $(this).data('id');
                const pannes = [];

                $('#pannes-table tbody tr').each(function() {
                    const row = $(this);
                    const prixTTC = parseFloat(row.find('input[name="total_ttc_change"]').val()) ||
                        parseFloat(row.find('input[name="total_ttc"]').val());
                    pannes.push(prixTTC);
                });

                const payload = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    pannes,
                    global_remise: parseFloat($('#global-remise').val()) || 0,
                    commentaire: $('#commentaire').val(),
                    date_rendez_vous: $('#rdv-date').val() || null
                };

                $(this).prop('disabled', true).html('Envoi...');

                $.post(`{{ route('boutique.sendEmailClient', ':id') }}`.replace(':id', id), payload)
                    .done(res => {
                        Swal.fire('Succès', res.message || 'Devis envoyé !', 'success');
                        $('#detailModal').modal('hide');
                        table.ajax.reload();
                    })
                    .fail(xhr => Swal.fire('Erreur', xhr.responseJSON?.message || 'Échec', 'error'))
                    .always(() => $(this).prop('disabled', false).html(
                        '<i class="fa fa-envelope"></i> Envoyer'));
            });


            // Suppression
            $('#demandesTable').on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Supprimer ?',
                    text: 'Cette action est irréversible',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('boutique.demandes.destroy', ':id') }}`.replace(
                                ':id', id),
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(() => {
                            table.ajax.reload();
                            Swal.fire('Supprimé !', '', 'success');
                        });
                    }
                });
            });
        });
    </script>
@endsection
