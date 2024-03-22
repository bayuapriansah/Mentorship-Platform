<div class="flex items-end justify-end">
    @if (getRole() == 'admin')
        @php
            $user = $chat->admin;
        @endphp
    @elseif (getRole() == 'mentor' || getRole() == 'staff')
        @php
            $user = $chat->mentor;
        @endphp
    @elseif (getRole() == 'student')
        @php
            $user = $chat->student;
        @endphp
    @endif
    <div class="bg-blue-500 p-3 rounded-lg">
        <div class="text-xs text-white">
            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
        </div>
        <p class="text-sm text-white">{{ $chat->message }}</p>
    </div>
    <div>
        <img src="{{ $user->profile_picture ? '/storage/' . $user->profile_picture : '/assets/img/profile-placeholder.png' }}" alt="Other User Avatar"
            class="w-8 h-8 rounded-full ml-3" />

    </div>
</div>
