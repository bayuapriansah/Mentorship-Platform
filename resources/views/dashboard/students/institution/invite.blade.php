@extends('layouts.admin2')

@section('more-css')
    <style>
        #email-list::-webkit-scrollbar-thumb {
            background: #8C94D3;
        }
    </style>
@endsection

@section('content')
{{-- Header --}}
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-dark-blue font-medium text-[1.375rem]">
        Invite Participants
    </h1>

    <a href="{{ $prevPage }}" class="flex items-center gap-3 text-xl">
        <i class="fas fa-times-circle mt-1 text-primary"></i>
        Cancel
    </a>
</div>
{{-- ./Header --}}

{{-- Form --}}
<form id="main-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
    @csrf

    <p class="text-sm">
        Add one or more email addresses separated by comma.
    </p>

    <div class="w-3/4 mt-4 flex flex-col gap-8">
        <input
            type="text"
            value="{{ old('emails') }}"
            placeholder="Email Address *"
            name="emails"
            class="h-11 py-2 px-4 border border-grey rounded-lg focus:outline-none"
            autocomplete="email"
            required
        >

        <button type="submit" class="w-max py-2.5 px-11 bg-primary rounded-full text-white text-lg">
            Send Invite
        </button>
    </div>
</form>
{{-- ./Form --}}

{{-- Import Data --}}
<div class="w-3/4 mt-10">
    <h2 class="text-lg text-dark-blue">
        Bulk Upload
    </h2>

    <div class="mt-3">
        <label for="file-input" class="cursor-pointer">
            <input type="file" accept=".csv" id="file-input" name="file" class="hidden">

            <div class="px-6 py-8 border-2 bg-profile-grey rounded-xl border-dashed border-grey flex flex-col justify-center items-center">
                <i class="fas fa-file fa-3x text-darker-blue"></i>
                <p class="mt-4 text-sm text-center text-[#8A91CD]">
                    Drag or Upload File (.csv only)
                </p>
            </div>
        </label>
    </div>

    <button id="clear-file-input-btn" style="display: none;" class="w-[90%] mt-6 px-5 py-3 border border-grey rounded-xl items-center">
        <i class="fas fa-file fa-lg text-darker-blue"></i>

        <p id="file-input-name" class="ml-7 text-sm">
            No file selected
        </p>

        <i class="fas fa-trash-alt fa-lg ml-auto text-red-700"></i>
    </button>

    <a href="{{ $template['url'] }}" target="_blank" id="download-template" class="mt-6 px-5 py-3 border border-grey rounded-xl flex items-center">
        <i class="fas fa-file fa-lg text-darker-blue"></i>

        <p class="ml-7 text-sm">
            {{ $template['name'] }}
        </p>

        <i class="fas fa-download fa-lg ml-auto text-darker-blue"></i>
    </a>

    {{-- Import Result --}}
    <form id="secondary-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="import-result" style="{{ old('emails_check') ? '' : 'display: none;' }}" class="w-[90%] mt-12">
            <p class="flex items-center gap-3 text-xl text-dark-blue">
                <span id="import-count" class="text-2xl text-[#C58D2D] font-medium">
                    {{ old('emails_check') ? count(old('emails_check')) : 0 }}

                </span>
                Email Addresses found
            </p>

            <div class="relative mt-4 h-96 px-6 py-4 border border-grey rounded-xl flex flex-col">
                <div style="display: none;" class="absolute inset-0 bg-slate-400 opacity-60"></div>

                <div class="flex items-center gap-3">
                    <input @if (old('emails_check')) checked @endif type="checkbox" id="check-all-emails" class="rounded checked:bg-dark-blue checked:text-white focus:ring-0">
                    <label for="check-all-emails">
                        Select All
                    </label>
                </div>

                <div id="email-list" class="flex-1 mt-4 flex flex-col gap-2 overflow-x-hidden overflow-y-auto">
                    {{-- Email List --}}
                    @if (old('emails_check'))
                         @foreach (old('emails_check') as $email)
                            <div class="flex items-center gap-3">
                                <input checked type="checkbox" id="check-email-${i}" name="emails_check[]" value="{{ $email }}" class="rounded checked:bg-dark-blue checked:text-white focus:ring-0">
                                <label for="check-email-{{ $loop->iteration }}">
                                    {{ $email }}
                                </label>
                            </div>
                         @endforeach
                    @endif
                </div>
            </div>

            <button type="submit" class="w-max mt-6 py-2.5 px-11 bg-primary rounded-full text-white text-lg">
                Send Invite
            </button>
        </div>
    </form>
    {{-- ./Import Result --}}
</div>
{{-- ./Import Data --}}
@endsection

@section('more-js')
    <script>
        // Alert
        function showAlert(type, message) {
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': true,
                'progressBar': true,
                'positionClass': 'toast-top-right',
                'preventDuplicates': true,
                'onclick': null,
                'showDuration': '300',
                'hideDuration': '1000',
                'timeOut': '10000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut'
            }

            toastr[type](message)
        }

        // Process CSV file
        function processCSV(file) {
            function processData(csvData) {
                const rows = csvData.split('\n')
                let count = 0

                for (let i = 0; i < rows.length; i++) {
                    const columns = rows[i].split(',')

                    if (columns.length > 0 && columns[0].trim() !== '') {
                        count++

                        // append email to list
                        $('#email-list').append(`
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="check-email-${i}" name="emails_check[]" value="${columns[0].trim()}" class="rounded checked:bg-dark-blue checked:text-white focus:ring-0">
                                <label for="check-email-${i}">
                                    ${columns[0].trim()}
                                </label>
                            </div>
                        `)
                    }
                }

                $('#import-count').text(count)
                $('#check-all-emails').prop('checked', false)
            }

            const reader = new FileReader()

            reader.onload = function (event) {
                const csvData = event.target.result

                if (csvData.trim().length === 0) {
                    $('#file-input').val('')
                    showAlert('error', 'File is empty')

                    return
                }

                processData(csvData)

                $('#file-input-name').text(file.name)
                $('#clear-file-input-btn').css('display', 'flex')
                $('#download-template').css('display', 'none')
                $('#import-result').css('display', 'block')
            };

            reader.readAsText(file)
        }

        // File input change
        $('#file-input').on('change', function() {
            const file = $(this).get(0).files[0]

            if (file) {
                if (file.name.split('.').pop().toLowerCase() != 'csv') {
                    $(this).val('')
                    showAlert('error', 'Only CSV file is allowed')

                    return
                }

                processCSV(file)
            }
        })

        // Clear file input
        $('#clear-file-input-btn').on('click', function() {
            $('#file-input').val('')
            $('#email-list').html('')
            $('#file-input-name').text('No file selected')
            $('#clear-file-input-btn').css('display', 'none')
            $('#download-template').css('display', 'flex')
            $('#import-result').css('display', 'none')
        })

        // Select all emails
        $('#check-all-emails').on('click', function() {
            if ($(this).is(':checked')) {
                $('#email-list input[type=checkbox]').prop('checked', true)
            } else {
                $('#email-list input[type=checkbox]').prop('checked', false)
            }
        })

        // Form submit
        $('#main-form').on('submit', function() {
            $(this).find('input').prop('readonly', true)
            $(this).find('button[type="submit"]').prop('disabled', true).text('Processing...')
        })

        $('#secondary-form').on('submit', function(e) {
            e.preventDefault()
            const checkedEmails = $('#email-list input[type=checkbox]:checked')

            if (checkedEmails.length === 0) {
                showAlert('info', 'Please select at least one email address')
            } else {
                $(this).find('.absolute').show()
                $(this).find('button[type="submit"]').prop('disabled', true).text('Processing...')
                $('#secondary-form').off('submit').submit()
            }
        })
    </script>
@endsection

