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
                    @foreach ($submissions as $submission)
                        <tr class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-[#F8F8F8]' }}">
                            <td class="px-5 py-3 rounded-s-lg rounded-e-lg">
                                <div class="flex items-baseline">
                                    <div class="w-3 h-3 bg-primary rounded-full"></div>

                                    <div class="max-w-[70%] ml-3">
                                        <p class="text-darker-blue font-medium">
                                            There is New Submission, From :
                                            {{ $submission->student->first_name }} {{ $submission->student->last_name }} at Section ({{ $submission->projectSection->title }})
                                        </p>

                                        <p class="mt-2 text-xs">
                                            {{ $submission->updated_at->isoFormat('Do MMMM, YYYY [at] h:mma') }}
                                        </p>

                                    </div>

                                    <a href="{{ route('dashboard.submission.singleSubmission.readNotification', [$submission->project_id, $submission->id, $submission->student->id]) }}" class="self-center ml-auto px-3 py-1 bg-primary rounded-lg flex gap-6 text-sm text-white">
                                        View Notification
                                        <span>></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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
