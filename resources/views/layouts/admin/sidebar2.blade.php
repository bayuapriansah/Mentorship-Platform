<ul class="font-light space-y-5">
  <li class="hover:font-medium">
    @if(Route::is('dashboard.admin'))
      <a href="/dashboard/admin" class="font-medium">Dashboard</a>
    @else
      <a href="/dashboard/admin">Dashboard</a>
    @endif
  </li>
  <li class="hover:font-medium">
    @if(Route::is('dashboard.students.index'))
      <a href="/dashboard/students" class="font-medium">Students</a>
    @else
      <a href="/dashboard/students">Students</a>
    @endif
  </li>
  <li class="hover:font-medium">
    @if(Route::is('dashboard.institutions_partners'))
      <a href="/dashboard/institutions_partners" class="font-medium">Institutions & Partner</a>
    @else
      <a href="/dashboard/institutions_partners">Institutions & Partner</a>
    @endif
  </li>

  @if(Auth::guard('mentor')->check())
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('dashboard.assigned.index')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Assigned Projects</span>
    </a>
  </li>
  @elseif(Auth::guard('web')->check())
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('dashboard.chat.allAssignedProjects')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Assigned Projects</span>
    </a>
  </li>
  @endif
  {{-- <li class="hover:font-medium">
    <a href="/dashboard"></a>
  </li> --}}
</ul>