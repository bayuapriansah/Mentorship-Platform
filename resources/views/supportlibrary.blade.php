@extends('layouts.supportlib')
@section('content')
<div class="container">
  @include('flash-message')

  <div class="text-center mb-5">
    <img src="https://www.shutterstock.com/shutterstock/photos/1865153395/display_1500/stock-photo-portrait-of-young-smiling-woman-looking-at-camera-with-crossed-arms-happy-girl-standing-in-1865153395.jpg" class="text-center" width="100%" height="800px">
    <P>
    <h1>Support Document Library</h1>
    <h5 class="mt-5">This page will organize all supporting documents to asist the students in developing their and link them do the companies</h5>
  </div>
  <div class="table-responsive">
    <table class="table">
        <thead class="table-dark">
            <td colspan="2">File or Document to Read</td>
        </thead>
        <tbody>
            <td><a href="https://www.shutterstock.com/image-photo/portrait-young-smiling-woman-looking-camera-1865153395">{Name of File}</a></td>
            <td style>Downmload Count</td>
        </tbody>                                                                                                
    </table>    

  </div>
</div>
@endsection