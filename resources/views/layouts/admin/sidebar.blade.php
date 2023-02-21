<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard.admin')}}">
      <div class="sidebar-brand-text mx-3">Simulated Intern</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
      <a class="nav-link" href="{{route('dashboard.admin')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  {{-- <div class="sidebar-heading">
      Interface
  </div> --}}

  <!-- Nav Item - Pages Collapse Menu -->
  @if(Auth::guard('web')->check())
  <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('dashboard.students.index')}} ">
          <i class="fa fa-users" aria-hidden="true"></i>
          <span>Students</span>
      </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMentor"
        aria-expanded="true" aria-controls="collapseMentor">
        <i class="fa-solid fa-chalkboard-user"></i>
        <span>Mentors and Partners</span>
    </a>
    <div id="collapseMentor" class="collapse" aria-labelledby="mentorPage" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('dashboard.mentors.index')}}">All mentors</a>
            <a class="collapse-item" href="{{route('dashboard.companies.index')}}">All partner</a>
            <a class="collapse-item" href="{{route('dashboard.mentors.registered')}}">Pending mentor invitation</a>
        </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('dashboard.institutions.index')}} ">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Institutions</span>
    </a>
</li>

  {{-- <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('dashboard.companies.index')}}">
          <i class="fa-solid fa-handshake"></i>
          <span>Partner Companies</span>
      </a> --}}
      {{-- <div id="collapsePartner" class="collapse" aria-labelledby="partnerPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="{{route('dashboard.companies.index')}}">All companies</a>
          </div>
      </div> --}}
  {{-- </li> --}}
  @endif

  @if(Auth::guard('company')->check() ||Auth::guard('web')->check() )
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProject"
    aria-expanded="true" aria-controls="collapseProject">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Projects</span>
    </a>
    <div id="collapseProject" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white collapse-inner rounded">
            <a class="collapse-item m-0" href="{{route('dashboard.projects.index')}}">Published Project</a>
            <a class="collapse-item m-0" href="{{route('dashboard.projects.draft')}}">Drafted Project</a>
        </div>
    </div>
  </li>
  @endif

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
  

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>