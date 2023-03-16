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
      @php
        $mergedNotifs = $newActivityNotifs->merge($notifNewTasks)->sortByDesc('created_at')->all();
      @endphp
      @foreach ($mergedNotifs as $notifNewTask)
        @if($notifNewTask->type == 'grade')
          @if($notifNewTask->grade == !NULL)
          <tr>
            <td>
              <span class="{{$notifNewTask->grade->readornot != 1 ? 'text-sm font-medium text-dark-blue':'text-sm font-normal text-black'}}">
                Result Task : {{ $notifNewTask->grade->submission->projectSection->title }}
                <br>
                Hi {{$student->first_name}} {{$student->last_name}},
                @if($notifNewTask->grade->status == 0)
                    {{ 'Sorry but you need to revise the Task' }}
                @elseif($notifNewTask->grade->status == 1)
                    {{ 'Great you Pass the Task' }}
                @else
                    {{ 'Nothing' }}
                @endif
                <br>
              </span>
              <span class="text-[#6973C6] text-xs font-normal">{{$notifNewTask->created_at->format('dS F, Y')}}</span>
            </td>
            <td class="">
              <a href="{{ route('student.readActivity',[$notifNewTask->grade->submission->student_id,$notifNewTask->grade->submission->project_id,$notifNewTask->grade->submission->section_id,$notifNewTask->grade->submission->id]) }}" class="bg-{{ $notifNewTask->grade->readornot != 1 ? 'dark-blue hover:bg-darker-blue' : 'grey hover:bg-gray-800' }} rounded-lg py-1 px-4 pb-2 text-white">View Notification</a>
            </td>
          </tr>
          @endif
        @elseif($notifNewTask->type == 'notification')
          @if($notifNewTask->project)
            @if($notifNewTask->status != 'deldraft')
              @if($notifNewTask->project->institution_id == $student->institution_id || $notifNewTask->project->institution_id == NULL)
                <tr>
                  <td>
                    <span class="{{optional($notifNewTask->read_notification)->firstWhere(['student_id' => $student->id, 'notifications_id' => $notifNewTask->id]) != TRUE ? 'text-sm font-medium text-dark-blue':'text-sm font-normal text-black'}}">
                      Task : 
                      {{ substr($notifNewTask->project->name,0,99) }} 
                      <br>
                      {!! substr($notifNewTask->project->problem,0,80) !!}...
                      <br>
                    </span>
                    <span class="text-[#6973C6] text-xs font-normal">{{$notifNewTask->created_at->format('dS F, Y')}}</span>
                  </td>
                  <td class="">
                    <a href="{{ route('student.readActivityTask',[$student->id,$notifNewTask->project_id,$notifNewTask->id]) }}" class="bg-{{ optional($notifNewTask->read_notification)->firstWhere(['student_id' => $student->id, 'notifications_id' => $notifNewTask->id]) != TRUE ? 'dark-blue hover:bg-darker-blue' : 'grey hover:bg-gray-800' }} rounded-lg py-1 px-4 pb-2 text-white">View Notification</a>
                  </td>
                </tr>
              @endif
            @endif
          @endif
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