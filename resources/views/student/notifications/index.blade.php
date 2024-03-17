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
        $notify_students = notifyStudent();
      @endphp
    @if(!empty($notify_students) && isset($notify_students['notification']))
        @foreach($notify_students['notification'] as $notify_student)
                <tr>
                    <td>
                      <span class="{{$notify_student['isRead'] != 1 ? 'text-sm font-medium text-dark-blue':'text-sm font-normal text-black'}}">
                    @if(isset($notify_student['projectName']))
                        There is a New Project: {{ $notify_student['projectName'] }}
                    @else
                        New notification for grading.
                    @endif
                    @if(isset($notify_student['type']) && $notify_student['type'] == "newGrading")
                        Result Task : {{ $notify_student['titleSection'] ?? 'N/A' }}
                        <br>
                        Hi {{ Auth::guard('student')->user()->first_name }} {{ Auth::guard('student')->user()->last_name }},
                        @if (isset($notify_student['statusGrading']))
                            @if($notify_student['statusGrading'] == "revision")
                                {{ 'Sorry, but you need to revise the task.' }}
                            @elseif($notify_student['statusGrading'] == "pass")
                                {{ 'Great, you completed the task!' }}
                            @else
                                {{ 'Status is not available.' }}
                            @endif
                        @endif
                    @endif
                        <br>
                      </span>
                      <span class="text-[#6973C6] text-xs font-normal">
                        @if (isset($notify_student['created_at']))
                            @php
                                $date = new DateTime($notify_student['created_at']);
                                echo $date->format('dS F, Y - H:i:s');
                            @endphp
                        @else
                            Date not available
                        @endif
                      </span>
                    </td>
                    <td class="">
                      <a href="{{ route('notifications.students.markAsRead', ['idNotify' => $notify_student['idNotify']]) }}" class="bg-{{ $notify_student['isRead'] != 1 ? 'dark-blue hover:bg-darker-blue' : 'grey hover:bg-gray-800' }} rounded-lg py-1 px-4 pb-2 text-white" onclick="event.preventDefault(); document.getElementById('mark-as-read-form-{{ $notify_student['idNotify'] }}').submit();">View Notification</a>
                    </td>
                </tr>
                <form id="mark-as-read-form-{{ $notify_student['idNotify'] }}" action="{{ route('notifications.students.markAsRead', ['idNotify' => $notify_student['idNotify']]) }}" method="POST" style="display: none;">
                    @csrf
                </form>
        @endforeach
    @else
        <p>No notifications found.</p>
    @endif

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
