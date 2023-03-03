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
      {{-- @php
        $mergedNotifs = array_merge($newActivityNotifs->toArray(), $notifNewTasks->toArray());
        $sortedNotifs = collect($mergedNotifs)->sortByDesc('created_at')->all();
      @endphp
      @dd($sortedNotifs) --}}
      {{-- @foreach ($sortedNotifs as $sorted) --}}
        {{-- @dd(isset($sorted->section_id)) --}}
      {{-- @endforeach --}}
      @foreach ($notifNewTasks->sortByDesc('created_at') as $notifNewTask)
          {{-- @if ($newActivityNotif->grade->readornot != 1) --}}
          {{-- {{ dd(isset($notifNewTasks->user_id)) }} --}}
          <tr>
            <td>
              <span class="{{$notifNewTask->status != 'deldraft' ? 'text-sm font-medium text-dark-blue':'text-sm font-normal text-black'}}">
                Task : 
                {{ substr($notifNewTask->project->name,0,99) }} 
                <br>
                {!! substr($notifNewTask->project->problem,0,80) !!}...
                <br>
              </span>
              <span class="text-[#6973C6] text-xs font-normal">{{$notifNewTask->created_at->format('dS F, Y')}}</span>
            </td>
            <td class="">
              @if($notifNewTask->status != 'deldraft')
              <a href="#" class="bg-dark-blue hover:bg-darker-blue rounded-lg py-1 px-4 pb-2 text-white">View Notification</a>
              @else
              <a href="#" data-tooltip-target="tooltip-hovers" data-tooltip-trigger="hover" class="bg-grey hover:bg-gray-800 rounded-lg py-1 px-4 pb-2 text-white">View Notification</a>
              @endif
            </td>
          </tr>
          <div id="tooltip-hovers" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            Task Has been deleted or not available right now for you to access it
            <div class="tooltip-arrow" data-popper-arrow></div>
          </div> 
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