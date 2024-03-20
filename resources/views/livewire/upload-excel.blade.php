<div>
    <h1 class="my-8 text-4xl font-bold text-center">
        Upload Excell
    </h1>
    <br>
    <div class="flex justify-between">
        <input type="file" wire:model="file">
        <button wire:click='save' class="p-2 bg-blue-500 text-white {{ $data ? '' : 'opacity-90 cursor-not-allowed' }}" {{ $data ? '' : 'disabled' }}>Save Data</button>
    </div>
    <div class="flex justify-center">
        <div wire:loading class="flex justify-center">
            Loading data....
        </div>
    </div>
    <div class="text-center text-red-500">
        @if ($typeerror)
            {{ $typeerror }}
        @endif
    </div>
    <table class="mt-5 bg-gray-500 border shadow-xl w-full">
        <tr>
            <td class="p-2">Name</td>
            <td class="p-2">Age</td>
            <td>Gender</td>
            <td>Email</td>
        </tr>
        @if ($data)
            @foreach ($data as $key => $value)
                @if ($key == 0)
                    @continue
                @endif
                <tr>
                    <td class="p-2 ">{{ $value[0] }}</td>
                    <td class="p-2 ">{{ $value[1] }}</td>
                    <td class="p-2 ">{{ $value[2] }}</td>
                    <td class="p-2 ">{{ $value[3] }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="p-5 text-center" colspan="4">No Preview Data</td>
            </tr>
        @endif
    </table>
</div>
