<div>
    <h1 class="my-8 text-4xl font-bold text-center">
        Upload Excell
    </h1>
    <br>
    <div class="flex justify-between">
        <button wire:click='openmodal' class="p-2 bg-blue-500 text-white ">Export Data</button>
    </div>
    <div class="text-center text-red-500">

    </div>
    <table class="mt-5  border shadow-xl w-full">
        <tr>
            <td class="p-2">Name</td>
            <td class="p-2">Age</td>
            <td>Gender</td>
            <td>Email</td>
            <td>Created At</td>
        </tr>
        @if ($data)
            @foreach ($data as $key => $value)
                <tr>
                    <td class="p-2 ">{{ $value->name }}</td>
                    <td class="p-2 ">{{ $value->age }}</td>
                    <td class="p-2 ">{{ $value->gender }}</td>
                    <td class="p-2 ">{{ $value->email }}</td>
                    <td class="p-2 ">{{ $value->created_at }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="p-5 text-center" colspan="4">No Preview Data</td>
            </tr>
        @endif
    </table>

    @if ($modal)
        <div class="fixed z-50 inset-0 overflow-y-auto" id="my-modal">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 sm:px-0">
                <div class="fixed bg-opacity-75 bg-gray-700 top-0 left-0 right-0 bottom-0"></div>

                <div class="w-full max-w-sm mx-auto overflow-hidden rounded-lg shadow-xl bg-white z-50">
                    <div class="modal-header flex items-center justify-between p-4 border-b border-gray-200">
                        <h5 class="text-xl font-medium text-gray-800">Modal Title</h5>
                        <button class="text-gray-400 focus:outline-none hover:text-gray-500" wire:click='closemodal'>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.707 3.307a1 1 0 00-1.414 0L0 6.014l4.293 4.293a1 1 0 001.414-1.414L2.307 5.5a.5.5 0 010-.707zM7.07 8.707a1 1 0 01-1.414 1.414L2.307 12.307a1 1 0 001.414 1.414L8.486 11.0a.5.5 0 10-.707-.707z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-orange-400">If no filter you can let both date is empty</p>
                        <div>
                            <div>From</div>
                            <input type="date" wire:model="datefrom" class="w-full">
                            @error('datefrom')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <div>To</div>
                            <input type="date" wire:model="dateto" class="w-full">
                            @error('dateto')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer flex items-center justify-end p-4 border-t border-gray-200">
                        <button wire:click='export'
                            class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 focus:outline-none">submit</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
