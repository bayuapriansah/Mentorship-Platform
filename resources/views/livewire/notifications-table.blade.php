<div>
    {{-- Table --}}
    <div class="mt-4 px-6 pt-2 pb-4 rounded-2xl border border-grey">
        <button wire:click='addnotif'>Add notif</button>
        <div class="relative overflow-x-auto">
            @if (auth()->user()->unReadNotifications->count() > 0)
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
                        @foreach ($notifications as $notif)
                            <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-[#F8F8F8]' }}">
                                <td class="px-5 py-3 rounded-s-lg rounded-e-lg">
                                    <div class="flex items-baseline">
                                        <div class="w-3 h-3 bg-primary rounded-full"></div>

                                        <div class="max-w-[70%] ml-3">
                                            <a href="{{isset($notif->data['url']) ? $notif->data['url'] : '#'}}" class="text-darker-blue font-medium">
                                                There is New Submission, From :
                                                {{-- {{json_decode($notif->data)['title']}} --}}
                                                {{$notif->data['title']}}
                                                <br>
                                                {{ $notif->data['message'] }}
                                                {{-- <a href="{{ $notif->data['url'] }}">go</a> --}}
                                                {{-- @dd($notif->data) --}}
                                            </a>

                                            <p class="mt-2 text-xs">
                                                {{ $notif->created_at->isoFormat('Do MMMM, YYYY [at] h:mma') }}
                                            </p>

                                        </div>

                                        {{-- @if ($submission->project && $submission && $submission->student)
                                            <a href="{{ route('dashboard.submission.singleSubmission.readNotification', [$submission->project->id, $submission->id, $submission->student->id]) }}"
                                                class="self-center ml-auto px-3 py-1 bg-primary rounded-lg flex gap-6 text-sm text-white">
                                                View Notification
                                                <span>></span>
                                            </a>
                                        @endif --}}

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $notifications->links() }}
                </div>
            @else
            @endif
        </div>
        {{-- <div class="relative overflow-x-auto">
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
                    @foreach ($submissions as $submission)
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-[#F8F8F8]' }}">
                            <td class="px-5 py-3 rounded-s-lg rounded-e-lg">
                                <div class="flex items-baseline">
                                    <div class="w-3 h-3 bg-primary rounded-full"></div>

                                    <div class="max-w-[70%] ml-3">
                                        <p class="text-darker-blue font-medium">
                                            There is New Submission, From :
                                            {{ optional($submission->student)->first_name }} {{ optional($submission->student)->last_name }} at Section ({{ optional($submission->projectSection)->title }})
                                        </p>

                                        <p class="mt-2 text-xs">
                                            {{ $submission->updated_at->isoFormat('Do MMMM, YYYY [at] h:mma') }}
                                        </p>

                                    </div>

                                    @if ($submission->project && $submission && $submission->student)
                                        <a href="{{ route('dashboard.submission.singleSubmission.readNotification', [$submission->project->id, $submission->id, $submission->student->id]) }}" class="self-center ml-auto px-3 py-1 bg-primary rounded-lg flex gap-6 text-sm text-white">
                                            View Notification
                                            <span>></span>
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
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
