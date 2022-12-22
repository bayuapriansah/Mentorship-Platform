@extends('layouts.admin')
@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Batch</h1>
    <a href="{{route('dashboard.batches.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-regular fa-plus"></i> Add Batch</a>
  </div>

  <div class="row">
    <div class="col card p-5">
      <form action="/dashboard/batches" method="POST">
        @csrf
        <div class="mb-3">
          <label for="batch_number" class="form-label">Batch number</label>
          <input type="number" class="form-control" id="batch_number" name="batch_number">
        </div>

        <div class="mb-3">
          <label for="start_date" class="form-label">Start date</label>
          <input type="date" class="form-control" id="start_date" name="start_date">
        </div>

        <div class="mb-3">
          <label for="end_date" class="form-label">End date</label>
          <input type="date" class="form-control" id="end_date" name="end_date">
        </div>

        <div class="mb-3">
          <label for="end_date" class="form-label">Company</label>
          <select class="form-control form-select" name="company_id">
            <option selected>--Assign Company--</option>
            @foreach($companies as $company)
            <option value="{{$company->id}}">{{$company->name}}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

      </form>
    </div>
  </div>
</div>
@endsection
