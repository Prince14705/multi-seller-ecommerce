{{-- resources/views/seller/messages/index.blade.php --}}
@extends('layouts.seller')

@section('title', 'Messages - Seller Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">
                <i class="fas fa-comments"></i> Messages
            </h1>
            <p class="text-muted mb-0">Communicate with customers and manage inquiries</p>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newMessageModal">
            <i class="fas fa-plus-circle"></i> New Message
        </button>
    </div>

    <div class="row">
        <!-- Conversation List -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Conversations ({{ $conversations->total() }})
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($conversations as $conversation)
                        <a href="javascript:void(0)" 
                           class="list-group-item list-group-item-action d-flex align-items-center 
                                  {{ $activeConversation && $activeConversation->id == $conversation->id ? 'active' : '' }}"
                           onclick="loadConversation({{ $conversation->id }})">
                            <div class="d-flex w-100">
                                <div class="me-3">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px;">
                                        @if($conversation->customer->profile_picture)
                                        <img src="{{ asset('storage/' . $conversation->customer->profile_picture) }}" 
                                             class="rounded-circle" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                        <i class="fas fa-user"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $conversation->customer->name }}</strong>
                                        <small class="text-muted">
                                            {{ $conversation->last_message_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="text-truncate text-muted" style="max-width: 200px;">
                                        {{ $conversation->last_message }}
                                    </div>
                                    @if($conversation->unread_count > 0)
                                    <span class="badge bg-danger mt-1">
                                        {{ $conversation->unread_count }} unread
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="list-group-item text-center py-4">
                            <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                            <h5>No conversations</h5>
                            <p class="text-muted">Start a new conversation</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($conversations->hasPages())
                    <div class="p-3">
                        {{ $conversations->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Message Area -->
        <div class="col-md-8">
            <div class="card shadow h-100">
                @if($activeConversation)
                <!-- Conversation Header -->
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        @if($activeConversation->customer->profile_picture)
                        <img src="{{ asset('storage/' . $activeConversation->customer->profile_picture) }}" 
                             class="rounded-circle me-3" 
                             style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $activeConversation->customer->name }}</h6>
                            <small class="text-muted">
                                Customer since {{ $activeConversation->customer->created_at->format('M Y') }}
                            </small>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#" 
                                   onclick="markAsRead({{ $activeConversation->id }})">
                                    <i class="fas fa-check-circle me-2"></i> Mark as Read
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" 
                                   onclick="exportConversation({{ $activeConversation->id }})">
                                    <i class="fas fa-download me-2"></i> Export Chat
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" 
                                   onclick="deleteConversation({{ $activeConversation->id }})">
                                    <i class="fas fa-trash me-2"></i> Delete Conversation
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Messages -->
                <div class="card-body" style="height: 400px; overflow-y: auto;" id="messagesContainer">
                    @foreach($activeConversation->messages as $message)
                    <div class="d-flex mb-3 {{ $message->sender_id == auth()->id() ? 'justify-content-end' : '' }}">
                        <div class="max-width-70">
                            <div class="card {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong>
                                                {{ $message->sender_id == auth()->id() ? 'You' : $message->sender->name }}
                                            </strong>
                                        </div>
                                        <small class="{{ $message->sender_id == auth()->id() ? 'text-white-50' : 'text-muted' }}">
                                            {{ $message->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                    <p class="mb-0">{{ $message->message }}</p>
                                    
                                    @if($message->attachments->count() > 0)
                                    <div class="mt-2">
                                        @foreach($message->attachments as $attachment)
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" 
                                           target="_blank" 
                                           class="btn btn-sm {{ $message->sender_id == auth()->id() ? 'btn-light' : 'btn-outline-primary' }}">
                                            <i class="fas fa-paperclip"></i> 
                                            {{ $attachment->file_name }}
                                        </a>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Message Input -->
                <div class="card-footer">
                    <form id="sendMessageForm" data-conversation-id="{{ $activeConversation->id }}">
                        @csrf
                        <div class="row g-2">
                            <div class="col">
                                <textarea class="form-control" 
                                          id="messageInput" 
                                          rows="2" 
                                          placeholder="Type your message..."
                                          required></textarea>
                            </div>
                            <div class="col-auto d-flex flex-column">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Send
                                    </button>
                                </div>
                                <input type="file" 
                                       id="fileInput" 
                                       class="d-none" 
                                       onchange="uploadAttachment()"
                                       multiple>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <!-- Empty State -->
                <div class="card-body d-flex flex-column align-items-center justify-content-center" 
                     style="height: 500px;">
                    <i class="fas fa-comments fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">Select a conversation</h4>
                    <p class="text-muted text-center mb-4">
                        Choose a conversation from the list to start messaging
                    </p>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                        <i class="fas fa-plus-circle"></i> Start New Conversation
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('seller.messages.start') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle"></i> New Message
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Select Customer *</label>
                        <select class="form-control" id="customer_id" name="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                    </div>
                    <div class="mb-3">
                        <label for="initial_message" class="form-label">Message *</label>
                        <textarea class="form-control" id="initial_message" name="message" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attachments" class="form-label">Attachments</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                        <small class="text-muted">You can attach multiple files</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentConversationId = {{ $activeConversation ? $activeConversation->id : 'null' }};
let messagePolling;

function loadConversation(conversationId) {
    currentConversationId = conversationId;
    window.location.href = `{{ route('seller.messages') }}?conversation=${conversationId}`;
}

function markAsRead(conversationId) {
    fetch(`/seller/messages/${conversationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function exportConversation(conversationId) {
    window.open(`/seller/messages/${conversationId}/export`, '_blank');
}

function deleteConversation(conversationId) {
    if (confirm('Delete this conversation?')) {
        fetch(`/seller/messages/${conversationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route('seller.messages') }}';
            }
        });
    }
}

document.getElementById('sendMessageForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('message', document.getElementById('messageInput').value);
    formData.append('_token', '{{ csrf_token() }}');
    
    // Add files if any
    const fileInput = document.getElementById('fileInput');
    for (let file of fileInput.files) {
        formData.append('attachments[]', file);
    }
    
    fetch(`/seller/messages/${currentConversationId}/send`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('messageInput').value = '';
            fileInput.value = '';
            loadNewMessages();
        }
    });
});

function uploadAttachment() {
    // Preview attachments
    const fileInput = document.getElementById('fileInput');
    const files = fileInput.files;
    // Could show preview here
}

function loadNewMessages() {
    if (!currentConversationId) return;
    
    fetch(`/seller/messages/${currentConversationId}/latest`)
        .then(response => response.json())
        .then(data => {
            if (data.messages.length > 0) {
                // Append new messages
                // This would require more complex implementation
                // For simplicity, we reload the conversation
                loadConversation(currentConversationId);
            }
        });
}

// Auto-refresh messages every 10 seconds
if (currentConversationId) {
    messagePolling = setInterval(loadNewMessages, 10000);
}

// Scroll to bottom of messages
window.addEventListener('load', function() {
    const container = document.getElementById('messagesContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
});
</script>
@endsection