@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Institutions</h3>
  <a href="#" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Institution</a>
</div>
<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Institution Name</th>
      <th>Official Email</th>
      <th>City</th>
      <th>State</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($institutions as $institution)
    <tr>
      <td>{{$no}}</td>
      <td>{{$institution->institutions}}</td>
      <td>contact@ {{$institution->institutions}}</td>
      <td>{{$institution->countries}}</td>
      <td>{{ $institution->created_at}}</td>
      <td>
        <button class="view-details space-y-7" 
          {{-- data-institution-logo=' <img src=`{{asset(`storage/`.$institution->logo)}}`  style=`width: 88px; height: 230px;`>' --}}
          {{-- data-institution-join="{{ $institution->created_at->format('d/m/ Y') }}" --}}
        >
          <i class="fa-solid fa-chevron-down"></i>
        </button>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>

{{-- <td>
  <div class = "flex justify-between items-center py-4 px-10 bg-[#EBEDFF] rounded-3xl">
    <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4">
      <img src="{{asset('assets/img/image 3.png')}}" class="w-16 h-9 object-scale-down mx-auto" alt="">
    </div>
    <div class="flex-col my-auto space-y-3">
      <p class="text-dark-blue font-mediun">Join Since: <span class="text-black font-normal">${companyJoin}</p>
      <p class="text-dark-blue font-mediun">Active Project: <span class="text-black font-normal">${companyProjects}</p>
    </div>
    <div class="">
      <a href="dashboard/students/{student}/edit" class="bg-dark-blue px-6 py-2 text-white rounded-lg"> Edit Details</a>
      <a href="dashboard/students/{student}/edit" class="bg-dark-yellow px-6 py-2 text-white rounded-lg"> Suspend Account</a>
      <a href="dashboard/students/{student}/edit" class="bg-dark-red px-6 py-2 text-white rounded-lg"> Delete Account</a>
    </div>
  </div>
</td> --}}
<div class="mt-12 flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Partners</h3>
  <a href="#" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Partner</a>
</div>
<table id="dataTable2" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Partner Name</th>
      <th>Official Email</th>
      <th>Address</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($companies as $company)
    <tr>
      <td>{{$no}}</td>
      <td>{{$company->name}}</td>
      <td>{{$company->email}}</td>
      <td>{{$company->address}}</td>
      <td>
        <button class="view-details space-y-7" 
                data-company-id="{{$company->id}}"
                data-company-logo='<img src="{{asset('storage/'.$company->logo)}}" alt="" class="w-[188px] h-[53px] object-scale-down mx-auto">'
                data-company-join="{{$company->created_at->format('d/m/ Y') }}"
                data-company-projects="{{count($company->projects)}}"
        ><i class="fa-solid fa-chevron-down"></i>
        </button>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>


@endsection
@section('more-js')
<script>
  $(document).ready( function () {
      let table2 = $('#dataTable2').DataTable();

      $('#dataTable2 tbody').on('click', 'button.view-details', function() {
      let tr = $(this).closest('tr');
      let row = table2.row(tr);
      let companyId = $(this).data('company-id');
      let companyLogo = $(this).data('company-logo');
      let companyJoin = $(this).data('company-join');
      let companyProjects = $(this).data('company-projects');

      if (row.child.isShown()) {
        $(this).html('<i class="fa-solid fa-chevron-down"></i>');
        row.child.hide();

      } else {
        $(this).html('<i class="fa-solid fa-chevron-up"></i>');
        row.child.show();

        row.child(`
        <div class = "flex justify-between items-center py-4 px-10 bg-[#EBEDFF] rounded-3xl">
          <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4">
            <img src="{{asset('assets/img/image 3.png')}}" class="w-16 h-9 object-scale-down mx-auto" alt="">
          </div>
          <div class="flex-col my-auto space-y-3">
            <p class="text-dark-blue font-mediun">Join Since: <span class="text-black font-normal">${companyJoin}</p>
            <p class="text-dark-blue font-mediun">Active Project: <span class="text-green-600 font-normal">${companyProjects}</p>
          </div>
          <div class="flex space-x-4">
            <a href="/dashboard/companies/${companyId}/edit" class="bg-dark-blue px-6 py-2 text-white rounded-lg"> Edit Details</a>
            <a href="/dashboard/companies/{student}/edit" class="bg-dark-yellow px-6 py-2 text-white rounded-lg"> Suspend Account</a>
            {!! Form::open(['route' => ['dashboard.companies.destroy', [$company->id]], 'method'=>'DELETE']) !!}
              <button type="submit" class="bg-dark-red px-6 py-2 text-white rounded-lg"> Delete Account</a>
            {!! Form::close() !!}
          </div>
        </div>
          `).show();
      }
    });

  });
</script>
@endsection