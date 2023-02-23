@extends('layouts.profile.index')
@section('content')
<div class="container py-6  mx-auto px-16 min-h-screen  ">
  <p class="text-2xl text-dark-blue font-medium">All Notifications</p>
  <table id="dataTable" class="bg-white rounded-xl border border-light-blue mt-16">
    <thead class="text-dark-blue">
      <tr>
        <th>Notification Details</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($newActivityNotifs as $newActivityNotif)
        @if ($newActivityNotif->grade == !NULL)
          {{-- @if ($newActivityNotif->grade->readornot != 1) --}}
          <tr>
            <td>
              <span class="{{$newActivityNotif->grade->readornot != 1 ? 'text-sm font-medium text-dark-blue':'text-sm font-normal text-black'}}">
                Task : 
                {{ substr($newActivityNotif->grade->submission->projectSection->title,0,99) }} 
                {{ substr($newActivityNotif->grade->submission->projectSection->title,0,99) >=99 ? '...':'' }}<br>
              </span>
              <span class="text-[#6973C6] text-xs font-normal">{{$newActivityNotif->grade->updated_at->format('dS F, Y')}}</span>
            </td>
            <td class="">
              <a href="#" class="bg-dark-blue hover:bg-darker-blue rounded-lg py-1 px-4 text-white">View Notification</a>
            </td>
          </tr>
          {{-- @endif --}}
        @endif          
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@section('more-js')
<script>
  $(document).ready( function () {
    $('#dataTable').DataTable({
      "targets": 'no-sort',
      "bSort": false,
      "order": [],
      "lengthChange": false
    });
  });
</script>

@endsection