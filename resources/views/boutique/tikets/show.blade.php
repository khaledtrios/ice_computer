@extends('boutique.layouts.app')

@section('title', 'Détails du Ticket | Boutique')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add CSRF token meta tag -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        .message-thread .message { margin-bottom: 1.5rem; padding: 1rem; border-radius: 0.5rem; }
        .message.admin { background-color: #e6f3ff; align-self: flex-end; }
        .message.user { background-color: #f8f9fa; align-self: flex-start; }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <h3>Détails du Ticket #{{ $ticket->id }}</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5>Ticket: {{ $ticket->objet }}</h5>
                    <span>Statut: <span class="badge {{ $ticket->status ? 'badge-success' : 'badge-danger' }}">{{ $ticket->status ? 'Ouvert' : 'Fermé' }}</span></span>
                </div>
                <div class="card-body">
                    <div class="message-thread">
                        @foreach ($ticket->messages as $message)
                            <div class="message {{ $message->is_admin ? 'admin' : 'user' }}">
                                <p><strong>{{ $message->is_admin ? 'Admin' : 'Vous' }}</strong> ({{ $message->created_at->format('d/m/Y H:i') }})</p>
                                <p>{{ $message->message }}</p>
                                @if ($message->image)
                                    <img src="{{ asset('storage/' . $message->image) }}" alt="Message Image" style="max-width: 200px;">
                                @endif
                                <small>Lu: {{ $message->is_read ? 'Oui' : 'Non' }}</small>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add New Message -->
                    <form id="addMessageForm" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="newMessage" class="form-label">Nouveau Message</label>
                            <textarea class="form-control" id="newMessage" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
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
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#addMessageForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('boutique.tickets.update', $ticket->id) }}",
                    type: "POST", // Use POST instead of PUT for FormData with _method
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Message envoyé !',
                            text: 'Votre message a été ajouté.',
                            customClass: { confirmButton: 'btn btn-success' }
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: xhr.responseJSON?.message || 'Une erreur s\'est produite.',
                            customClass: { confirmButton: 'btn btn-danger' }
                        });
                    }
                });
            });

            feather.replace();
        });
    </script>
@endsection
