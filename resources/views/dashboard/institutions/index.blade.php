@extends('layouts.admin2')
@section('content')
<div class="flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Institutions</h3>
  <a href="/dashboard/institutions/create" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Institution</a>
</div>

<table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Institution Name</th>
      <th>Official Email</th>
      <th>State</th>
      <th>City</th>
      <th>Join Date</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>
    @php $no=1 @endphp
    @foreach($institutions as $institution)
    <tr>
      <td>{{$no}}</td>
      <td>{{$institution->institutions}}</td>
      <td>{{$institution->email}}</td>
      <td>{{$institution->states}}</td>
      <td>{{$institution->countries}}</td>
      <td>{{$institution->created_at->format('d/m/ Y') }}</td>
      <td>
        <button class="view-details space-y-7"
        data-institution-id="{{$institution->id}}"
        data-institution-logo='<img src="{{asset('storage/'.$institution->logo)}}" alt="" class="w-[188px] h-[53px] object-scale-down mx-auto">'
        data-institution-join="{{$institution->created_at->format('d/m/ Y') }}"
        data-institution-supervisor="{{count($institution->mentors)}}"
        data-institution-student="{{count($institution->students)}}"
        data-institution-status="{{$institution->status == 1 ? 'Active' : 'Deactive'}}"
        data-institution-btn-text="{{$institution->status == 1 ? 'Deactive' : 'Activate'}}"
        >
          <i class="fa-solid fa-chevron-down"></i>
        </button>
      </td>
    </tr>
    @php $no++ @endphp
    @endforeach
  </tbody>
</table>
<div class="mt-12 flex justify-between mb-10">
  <h3 class="text-dark-blue font-medium text-xl">Partners</h3>
  <a href="/dashboard/partners/create" class="text-xl text-dark-blue"><i class="fa-solid fa-circle-plus"></i> Add Partner</a>
</div>
<table id="dataTable2" class="bg-white rounded-xl border border-light-blue mt-16">
  <thead class="text-dark-blue">
    <tr>
      <th>No</th>
      <th>Partner Name</th>
      <th>Official Email</th>
      <th>Address</th>
      <th>Join Date</th>
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
      <td>{{$company->created_at->format('d/m/ Y')}}</td>
      <td>
        <button class="view-details space-y-7"
                data-company-id="{{$company->id}}"
                data-company-logo='<img src="{{asset('storage/'.$company->logo)}}" alt="" class="w-[188px] h-[53px] object-scale-down mx-auto">'
                data-company-projects="{{count($company->projects)}}"
                data-company-members = "{{count($company->customers)}}"
                data-company-status="{{$company->status == 1 ? 'Active' : 'Deactive'}}"
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
      let table1 = $('#dataTable').DataTable();
      $('#dataTable tbody').on('click', 'button.view-details', function() {
        let tr = $(this).closest('tr');
        let row = table1.row(tr);
        let institutionId = $(this).data('institution-id');
        let institutionLogo = $(this).data('institution-logo');
        let institutionJoin = $(this).data('institution-join');
        let institutionSupervisor = $(this).data('institution-supervisor');
        let institutionStudent = $(this).data('institution-student');
        let institutionStatus = $(this).data('institution-status');
        let institutionBtn = $(this).data('institution-btn-text')
        if (row.child.isShown()) {
          $(this).html('<i class="fa-solid fa-chevron-down"></i>');
          row.child.hide();
        } else {
          $(this).html('<i class="fa-solid fa-chevron-up"></i>');
          row.child.show();
          row.child(`
          <div class = "flex-col space-y-4 justify-between items-center py-4 px-10 bg-[#EBEDFF] rounded-3xl">
            <div class="flex justify-between items-center">
              <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4">
                ${institutionLogo}
              </div>
              <div class="flex-col my-auto space-y-3">
                <p class="text-dark-blue font-mediun">Status: <span class="text-green-600 font-normal">${institutionStatus}</p>
                <p class="text-dark-blue font-mediun">Total Students: <span class="text-[#4B59F2] font-normal">${institutionStudent}</span></p>
                <p class="text-dark-blue font-mediun">Total Supervisor: <span class="text-[#4B59F2] font-normal"> ${institutionSupervisor}</p>
              </div>
              <div class="flex space-x-4">
                <a href="/dashboard/institutions/${institutionId}/edit" class="bg-dark-blue px-6 py-2 text-white rounded-lg"> Edit Details</a>
                <form method="POST" action="/dashboard/institutions/${institutionId}/suspend" >
                  @csrf
                  <button type="submit"  class="bg-dark-yellow px-6 py-2 text-white rounded-lg">${institutionBtn} Institution</button>
                </form>

                <form method="POST" action="/dashboard/institutions/${institutionId}" >
                  @csrf
                  @method('DELETE')
                  <button type="submit" onClick="return confirm('Delete this Institution?')" class="bg-dark-red px-6 py-2 text-white rounded-lg">Delete Institution</button>
                </form>

              </div>
            </div>
            <div class="space-x-8">
              <a href="/dashboard/institutions/${institutionId}/students" class="text-white font-normal bg-dark-blue hover:bg-darker-blue px-8 py-2 rounded-lg">List of Students</a>
              <a href="/dashboard/institutions/${institutionId}/supervisors" class="text-white font-normal bg-[#4753BA] hover:bg-light-blue px-8 py-2 rounded-lg">List of Supervisors</a>
            </div>
          </div>
            `).show();
        }
      });


      $('#dataTable2 tbody').on('click', 'button.view-details', function() {
      let tr = $(this).closest('tr');
      let row = table2.row(tr);
      let companyId = $(this).data('company-id');
      let companyLogo = $(this).data('company-logo');
      let companyProjects = $(this).data('company-projects');
      let companyStatus = $(this).data('company-status');
      let companyMembers = $(this).data('company-members');

      if (row.child.isShown()) {
        $(this).html('<i class="fa-solid fa-chevron-down"></i>');
        row.child.hide();

      } else {
        $(this).html('<i class="fa-solid fa-chevron-up"></i>');
        row.child.show();

        row.child(`
        <div class = "flex-col space-y-4 justify-between items-center py-4 px-10 bg-[#EBEDFF] rounded-3xl">
          <div class="flex justify-between items-center">
            <div class=" my-auto border-[1px] border-light-blue bg-white rounded-xl px-2 py-4">
              ${companyLogo}
            </div>
            <div class="flex-col my-auto space-y-3">
              <p class="text-dark-blue font-mediun">Active Project: <span class="text-green-600 font-normal">${companyProjects}</p>
              <p class="text-dark-blue font-mediun">Total Member: <span class="text-green-600 font-normal">${companyMembers}</p>
            </div>
            <div class="flex space-x-4">
              <a href="/dashboard/partners/${companyId}/edit" class="bg-dark-blue px-6 py-2 text-white rounded-lg"> Edit Details</a>
              <form method="POST" action="/dashboard/partners/${companyId}" >
                @csrf
                @method('DELETE')
                <button type="submit" onClick="return confirm('Delete this Partner?')" class="bg-dark-red px-6 py-2 text-white rounded-lg"> Delete Partner</button>
              </form>
            </div>
          </div>
          <div class="space-x-8">
            <a href="/dashboard/partners/${companyId}/projects" class="text-white font-normal bg-dark-blue hover:bg-darker-blue bg px-8 py-2 rounded-lg">List of Projects</a>
            <a href="/dashboard/partners/${companyId}/members" class="text-white font-normal bg-[#4753BA] hover:bg-light-blue px-8 py-2 rounded-lg">List of Members</a>
          </div>
        </div>
          `).show();
      }
    });
  });
</script>
@endsection
