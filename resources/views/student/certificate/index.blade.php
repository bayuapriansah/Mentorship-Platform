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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script> --}}

  <div class="toolbar no-print">
    <button class="btn btn-info" onclick="window.print()">
      Print Certificate
    </button>
    <button class="btn btn-info" id="downloadPDF">Download PDF</button>
  </div>
  <div class="cert-container print-m-0">
    <div id="content2" class="cert">
      <img src="{{asset('assets/img/Certificate_1x.svg')}}" class="cert-bg" />
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
            participated in a 2-week-long Simulated AI Internship with Sustainable Living Lab from
          </p>
          <p>
            {{$student->created_at->format('d-m-Y')}} to {{Carbon\Carbon::parse($student->end_date)->format('d-m-y')}}
          </p>
        </div>
        <div class="flex flex-col -space-y-2">
          <p>
            During the internship, they successfully completed a simulated industry project on
          </p>
          <p>Computer Vision.</p>
        </div>
      </div>
    </div>
  </div>
  
  <script src="{{asset('assets/js/certif.js')}}"></script>
</body>
</html>