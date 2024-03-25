<div class="flex items-start">
    @if ($chat->sender_type == 'admin')
        @php
            $user = $chat->admin;
        @endphp
    @elseif ($chat->sender_type == 'mentor' || $chat->sender_type == 'staff')
        @php
            $user = $chat->mentor;
        @endphp
    @elseif ($chat->sender_type == 'student')
        @php
            $user = $chat->student;
        @endphp
    @endif

    @if ($user)
        <img src="{{ $user->profile_picture ? '/storage/' . $user->profile_picture : '/assets/img/profile-placeholder.png' }}"
            alt="Other User Avatar" class="w-8 h-8 rounded-full ml-3" />
        <div class="ml-3 bg-gray-100 p-3 rounded-lg shadow-md">
            <div class="text-xs ">
                {{ $user->first_name }} {{ $user->last_name }} <span class="capitalize">({{ $chat->sender_type }})</span>
            </div>
            <p class="text-sm text-gray-800">{{ $chat->message }}</p>
        </div>
    @else
        <img src="/assets/img/profile-placeholder.png" alt="Other User Avatar" class="w-8 h-8 rounded-full ml-3" />
        <div class="ml-3 bg-gray-100 p-3 rounded-lg shadow-md">
            <div class="text-xs ">
                Deleted User <span class="capitalize">({{ $chat->sender_type }})</span>
            </div>
            <p class="text-sm text-gray-800">{{ $chat->message }}</p>
        </div>
    @endif
</div>
