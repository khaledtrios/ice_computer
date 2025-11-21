@extends('admin.layouts.app')

@section('title', 'Gestion des Tickets | Ice-Computer')

@section('css')
<style>
    .ticket-status {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    .ticket-status-new {
        background-color: #e3f5ff;
        color: #0d6efd;
    }
    .ticket-status-open {
        background-color: #e6f7ee;
        color: #198754;
    }
    .ticket-status-pending {
        background-color: #fff8e6;
        color: #fd7e14;
    }
    .ticket-status-closed {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    .message-admin {
        background-color: #f8f9fa;
        border-left: 3px solid #0d6efd;
        margin-right: 20%;
    }
    .message-client {
        background-color: #e9ecef;
        border-left: 3px solid #6c757d;
        margin-left: 20%;
    }
    .initials-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
    }
    .chat-container {
        height: 500px;
        overflow-y: auto;
        padding: 15px;
    }
    .message-time {
        font-size: 0.75rem;
        color: #6c757d;
    }
    #message-input {
        resize: none;
    }
</style>
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Gestion des Tickets</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.tickets.index') }}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Supports</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Détails du ticket -->
            <div class="col-xxl-3 col-xl-4 col-md-5 box-col-5 xl-40">
                <div class="card left-sidebar-wrapper">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h6 class="mb-0">Détails du Ticket</h6>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="initials-avatar bg-primary me-2">{{ substr($ticket->boutique->nom_boutique, 0, 2) }}</div>
                                    <div>
                                        <h6 class="mb-0">{{ $ticket->objet }}</h6>
                                        <small class="text-muted">Ticket #{{ $ticket->id }}</small>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <small class="text-muted">Boutique</small>
                                            <p class="mb-0">{{ $ticket->boutique->nom_boutique }}</p>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Statut</small>
                                            @php
                                                if ($ticket->status) {
                                                    $statusClass = 'ticket-status-open';
                                                    $statusText = 'Ouvert';
                                                } else {
                                                    $statusClass = 'ticket-status-closed';
                                                    $statusText = 'Fermé';
                                                }
                                            @endphp
                                            <p><span class="badge {{ $statusClass }}">{{ $statusText }}</span></p>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Date</small>
                                            <p class="mb-0">{{ $ticket->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">Message initial</small>
                                        <p class="mb-0">{{ $ticket->message }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    @if($ticket->status)
                                        <button class="btn btn-sm btn-outline-secondary close-ticket" data-id="{{ $ticket->id }}">
                                            <i class="fas fa-check me-1"></i> Fermer le ticket
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            <i class="fas fa-check me-1"></i> Ticket fermé
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Messages du ticket -->
            <div class="col-xxl-9 col-xl-8 col-md-7 box-col-7 xl-60">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="initials-avatar bg-primary me-3">{{ substr($ticket->boutique->nom_boutique, 0, 2) }}</div>
                                <div>
                                    <h5 class="mb-0">{{ $ticket->objet }}</h5>
                                    <small class="text-muted">Boutique: {{ $ticket->boutique->nom_boutique }} | Créé le: {{ $ticket->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                            <div>
                                @if($ticket->created_at > now()->subDays(7))
                                    <span class="badge ticket-status-new">Récent</span>
                                @endif
                                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body chat-container" id="chat-messages">
                        @forelse($ticket->messages as $message)
                            @if($message->is_admin)
                                <div class="mb-3 p-3 message-admin rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>Support Technique</strong>
                                        <small class="message-time">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p>{{ $message->message }}</p>
                                </div>
                            @else
                                <div class="mb-3 p-3 message-client rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>{{ $ticket->boutique->nom_boutique }}</strong>
                                        <small class="message-time">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p>{{ $message->message }}</p>
                                </div>
                            @endif
                        @empty
                            <div class="text-center text-muted py-4">
                                Aucun message pour ce ticket
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="card-footer">
                        <form id="message-form">
                            @csrf
                            <input type="hidden" name="support_id" value="{{ $ticket->id }}">
                            <div class="input-group">
                                <textarea id="message-input" name="message" class="form-control" placeholder="Écrire un message..." rows="1" required></textarea>
                              
                                <button class="btn btn-primary" type="submit" id="send-message">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Auto-scroll to bottom of chat
    $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);

    $('#message-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var messageInput = $('#message-input');
        var chatMessages = $('#chat-messages');
        
        if (messageInput.val().trim() === '') {
            return;
        }
        
        $.ajax({
            url: "{{ route('superadmin.support.message.store') }}",
            method: "POST",
            data: form.serialize(),
            beforeSend: function() {
                $('#send-message').prop('disabled', true);
            },
            success: function(response) {
                // Ajouter le nouveau message à la conversation
                var newMessage = `
                    <div class="mb-3 p-3 message-admin rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Support Technique</strong>
                            <small class="message-time">${new Date().toLocaleString()}</small>
                        </div>
                        <p>${messageInput.val()}</p>
                    </div>
                `;
                chatMessages.append(newMessage);
                
                // Vider le champ de message
                messageInput.val('');
                
                // Scroll vers le bas
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            },
            error: function(xhr) {
                alert('Une erreur est survenue lors de l\'envoi du message');
                console.error(xhr.responseText);
            },
            complete: function() {
                $('#send-message').prop('disabled', false);
            }
        });
    });

    $('.close-ticket').on('click', function() {
        var ticketId = $(this).data('id');
        var button = $(this);
        
        if (confirm('Voulez-vous vraiment fermer ce ticket ?')) {
            $.ajax({
                url: "{{ route('superadmin.support.close', 'ticket') }}" .replace('ticket', ticketId),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Une erreur est survenue lors de la fermeture du ticket');
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Auto-resize textarea
    $('#message-input').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endsection