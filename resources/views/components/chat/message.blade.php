@if (getRole() == $chat->sender_type)
    @if ($chat->sender_id == auth()->user()->id)
        <x-chat.sent :chat="$chat" />
    @else
        <x-chat.received :chat="$chat" />
    @endif
@else
    <x-chat.received :chat="$chat" />
@endif
