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
    <button class="btn btn-info" id="downloadPDF2">Download PDF</button>
  </div>
  <div class="cert-container print-m-0">
    <div id="content2" class="cert">
      <img src="{{asset('assets/img/14834937_5520962.svg')}}" class="cert-bg" />
      <div class="w-2/3 mx-auto py-16">
        <br /><br /><br /><br />
        <p class="mb-2 text-[22px]">
          This is to certify that 
        </p>
        <div class="mb-2">
          <h1 class="text-3xl capitalize">
            {{$student->first_name}} {{$student->last_name}}
          </h1>
        </div>
        <p class="mb-2">
          This is to certify that <span class="capitalize">{{$student->first_name}} {{$student->last_name}}</span> participated in a 2-week-long Simulated Internship Experience with Sustainable Living Lab
        </p>
        <p>
          We wish him/her great success in {{$student->sex == 'male'? 'His':'Her'}}  future endeavours.
        </p>
      </div>
    </div>
  </div>
  
  <script src="{{asset('assets/js/certif.js')}}"></script>
</body>
</html>