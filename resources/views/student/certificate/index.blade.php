<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  {{-- <link rel="stylesheet" href="{{asset('assets/css/certif.css')}}"> --}}
  @vite('resources/css/app.css')

</head>
<body>
  <div class="toolbar no-print">
    {{-- <button class="btn btn-info" id="downloadPDF">Download PDF</button> --}}
    {{-- <a class="btn btn-info" href="/profile/{{$student->id}}/generate">Download PDF</a> --}}
    <br>
    <a href="javascript:void(0)" class="px-4 py-3 bg-dark-blue hover:bg-darker-blue text-base mx-1 text-white rounded-xl mt-2 btn-download">Generate PDF</a>
  </div>
  <div class="cert-container" id="print-m-0">
    <div id="content2" class="cert">
      {{-- <img src="{{asset('assets/img/Certificate_2x.png')}}" class="cert-bg" /> --}}
      <img src="{{asset('assets/img/Certificate_V2.svg')}}" class="cert-bg" />
      <div class="w-full mx-auto py-16">
        <br /><br /><br /><br />
        <p class=" text-[22px] mt-1">
          This is to certify that
        </p>
        <div class="mb-2">
          <h1 class="text-3xl capitalize font-medium">
            {{$student->first_name}} {{$student->last_name}}
          </h1>
        </div>
        <div class="flex flex-col -space-y-2">
          <p>
            participated in a 10-weeks-long Mentorship Program with Sustainable Living Lab from
          </p>
          <p>
            {{$student->created_at->format('d-m-Y')}} to {{Carbon\Carbon::parse($student->end_date)->format('d-m-Y')}}
          </p>
        </div>
        <div class="flex flex-col -space-y-2">
          <p>
            During the internship, they successfully completed a Mentorship Program industry project on
          </p>
          <p>Computer Vision.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="flex">
  </div>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>

  <script type="text/javascript" src="{{asset('assets/js/certificate.js')}}"></script>
</body>
</html>


