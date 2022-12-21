@extends('layouts.index')
@section('content')
<div class="container">
  <div class="p-5 mb-4 text-center">
    <img src="{{asset('assets/img/heroBackground.jpg')}}" alt="" width="100%">
  </div>

  <h2>Project Page</h2>
  
  <h5 class="mt-5">Problem statement:</h5>
  <ul>
    <li>Backround information</li>
    <li>Problem to solve</li>
    <li>Expectations for the project</li>
    <li>Limitations on the project</li>
  </ul>
  <div class="row justify-content-center">
    <div class=" card col-6 p-4 bg-light">
      <p>Customer Messaging Board:</p>
      <p>To be used for communications between the customer and the students</p>
      <p>Updates to the project will be posted here</p>
      <p>Call information will be posted here</p>
    </div>
  </div>
  {{-- <div class="card mt-5 text-center bg-light">
    
  </div> --}}

  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Twitter-logo.svg" alt="" width="30px" height="30px">
    <p>Checkout Sponsoring Company</p>
  </div>
  <div class="mt-5 text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="" width="30px" height="30px">
    <p>Download the dataset here</p>
  </div>

  <div class="mt-5">
    <img src="{{asset('assets/img/image.png')}}" alt="" width="100%" height="250px">
  </div>

  <h2 class="mt-5">Get help for your project</h2>
  <a href="#" class="link-primary">Link to discussion forum</a><br>
  <a href="#" class="link-primary">Link to support document library</a>
</div>
@endsection