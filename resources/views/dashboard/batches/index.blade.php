@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Batch</h1>
      <a href="{{route('dashboard.batches.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Add Batch</a>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col">
      <table id="myTable" class="display responsive w-100" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Batch number</th>
            <th>Start Date</th>
            <th>End Data</th>
            <th>Company name</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1 @endphp
          @foreach($batches as $batch)
          <tr>
            <td>{{$no}}</td>
            <td>{{$batch->batch_number}}</td>
            <td>{{$batch->start_date}}</td>
            <td>{{$batch->end_date}}</td>
            <td>{{$batch->company->name}}</td>
          </tr>
          @php $no++ @endphp
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection