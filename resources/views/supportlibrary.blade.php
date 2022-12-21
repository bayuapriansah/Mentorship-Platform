@extends('layouts.index')
@section('content')
<div class="container">
  @include('flash-message')

  <div class="text-center mb-5">
    <img src="https://www.shutterstock.com/shutterstock/photos/1865153395/display_1500/stock-photo-portrait-of-young-smiling-woman-looking-at-camera-with-crossed-arms-happy-girl-standing-in-1865153395.jpg" class="text-center" width="100%" height="800px">
    <P>
    <h1>Support Document Library</h1>
    <h4 class="mt-5">This page will organize all supporting documents to asist the students in developing their and link them do the companies</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-dark">
            <td colspan="2">File or Document to Read</td>
        </thead>
        <tbody>
            <tr>
                <td><a href="#example">{98f5d9ef-d551-4013-a867-cd11f5369b2a}</a></td>
                <td style="text-align: right">100 <i class="bi bi-cloud-arrow-down"></i></td>
            </tr>
            <tr>
                <td><a href="#example">{45c900b4-9337-4b23-9ba8-51459f10fda8}</a></td>
                <td style="text-align: right">100 <i class="bi bi-cloud-arrow-down"></i></td>
            </tr>
            <tr>
                <td><a href="#example">{71451045-65d4-424c-8f20-ccc5c33d40d7}</a></td>
                <td style="text-align: right">100 <i class="bi bi-cloud-arrow-down"></i></td>
            </tr>
            <tr>
                <td><a href="#example">{f3b020ae-f084-497a-ba07-f8c23803b6bc}</a></td>
                <td style="text-align: right">100 <i class="bi bi-cloud-arrow-down"></i></td>
            </tr>
        </tbody>                                                                                                
    </table>    

  </div>
</div>
@endsection