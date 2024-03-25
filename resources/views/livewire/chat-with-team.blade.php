<div class="border rounded-xl p-4">
    <!-- Chat Container -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <!-- Chat Header -->
        <div class="flex items-center mb-4">
            <div class="ml-3">
                <p class="text-xl font-medium">{{$team_name}}</p>
                {{-- <p class="text-gray-500">Online</p> --}}
            </div>
        </div>

        <!-- Chat Messages -->


        <div class="space-y-4 h-[600px] overflow-y-auto">
            @foreach ($chats as $chat)
                <x-chat.message :chat="$chat" />
            @endforeach
            <!-- Received Message -->

            {{-- <x-chat.received />
            <x-chat.sent /> --}}

        </div>

        <!-- Chat Input -->
        <form wire:submit.prevent='sendMessage' class="mt-4 flex items-center">
            <input type="text" wire:model.defer="message" placeholder="Type your message..."
                class="flex-1 py-2 px-3 rounded-xl bg-gray-100 focus:outline-none" />
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-xl ml-3 hover:bg-blue-600">Send</button>
        </form>
    </div>
</div>
