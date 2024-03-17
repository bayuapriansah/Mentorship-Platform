<div>
    {{-- Table --}}
    <div class="mt-4 px-6 pt-2 pb-4 rounded-2xl border border-grey">
        <div class="relative overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr>
                        <th scope="col" class="px-5">
                            <div class="w-full flex justify-between items-center gap-5">
                                <span class="text-sm text-darker-blue font-medium">
                                    Notification Details
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
      @php
        $notify_mentors = notifyMentor();
      @endphp
    @if(!empty($notify_mentors) && isset($notify_mentors['notification']))
        @foreach($notify_mentors['notification'] as $notify_mentor)
        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-[#F8F8F8]' }}">
            <td class="px-5 py-3 rounded-s-lg rounded-e-lg">
                <div class="flex items-baseline">
                    @if($notify_mentor['isRead'] == 0)
                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                    @endif
                    <div class="max-w-[70%] ml-3">
                        <p class="text-{{ $notify_mentor['isRead'] != 1 ? 'dark-blue hover:text-darker-blue' : 'grey hover:text-gray-800' }} font-medium">
                            There is
                            {{ $notify_mentor['statusSubmission'] != "revision" ? 'New Submission' : 'Resubmission' }}, From :
                            {{ $notify_mentor['studentName'] }} at Section ({{ $notify_mentor['taskTitle'] }})
                        </p>

                        <p class="mt-2 text-xs">
                            @if (isset($notify_mentor['created_at']))
                                @php
                                    $date = new DateTime($notify_mentor['created_at']);
                                    echo $date->format('dS F, Y - H:i:s');
                                @endphp
                            @else
                                Date not available
                            @endif
                        </p>

                    </div>
                    {{-- <a href="{{ route('dashboard.submission.singleSubmission.readNotification', [$submission->project->id, $submission->id, $submission->student->id]) }}" class="self-center ml-auto px-3 py-1 bg-primary rounded-lg flex gap-6 text-sm text-white"> --}}
                    {{-- <a href="{{ "#" }}" class="self-center ml-auto px-3 py-1 bg-primary rounded-lg flex gap-6 text-sm text-white">
                        View Notification
                        <span>></span>
                    </a> --}}
                    {{-- bg-{{ $notify_student['isRead'] != 1 ? 'dark-blue hover:bg-darker-blue' : 'grey hover:bg-gray-800' }} --}}
                    <a href="{{ route('dashboard.notifications.mentor.markAsRead', ['idNotify' => $notify_mentor['idNotify']]) }}" class=" self-center ml-auto px-3 py-1 bg-primary rounded-lg flex gap-6 text-sm text-white" onclick="event.preventDefault(); document.getElementById('mark-as-read-form-{{ $notify_mentor['idNotify'] }}').submit();">
                        View Notification
                        <span>></span>
                    </a>

                    <form id="mark-as-read-form-{{ $notify_mentor['idNotify'] }}" action="{{ route('dashboard.notifications.mentor.markAsRead', ['idNotify' => $notify_mentor['idNotify']]) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    @else
        <tr class="bg-white">
            <td class="px-5 py-3 rounded-s-lg rounded-e-lg">
                <div class="flex items-baseline">
                    <p>No notifications found.</p>
                </div>
            </td>
        </tr>
    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- ./Table --}}

    {{-- Pagination --}}
    <div class="mt-5 px-2 flex items-center">
        <div class="ml-auto">
            {{ $submissions->links() }}
        </div>
    </div>
    {{-- ./Pagination --}}
</div>
