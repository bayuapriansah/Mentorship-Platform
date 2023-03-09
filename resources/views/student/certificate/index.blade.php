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
      <img src="{{asset('assets/img/certif-big.png')}}" class="cert-bg" />
      <div class="cert-content">
        <br /><br /><br /><br /><br /><br />
        <p class="mb-2">
          This is to certify that {{$student->sex == 'male'? 'Mr':'Ms'}}. {{$student->first_name}} {{$student->last_name}} has successfully completed 5 weeks of an internship program from {{$student->created_at->format('d-m-Y')}} to {{Carbon\Carbon::parse($student->end_date)->format('d-m-y')}} in the ………………… department of our organization.
        </p>
        <p class="mb-2">
          {{$student->sex == 'male'? 'He':'She'}} was highly motivated and hardworking. {{$student->sex == 'male'? 'He':'She'}}  worked sincerely at {{$student->sex == 'male'? 'His':'Her'}}  tasks and did a very good job.
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