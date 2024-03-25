<ul class="font-light space-y-5">
    <li class="hover:font-medium">
        @if (Auth::guard('web')->check())
            @if (Route::is('dashboard.admin'))
                <a href="/dashboard/admin" class="font-medium">Dashboard</a>
            @else
                <a href="/dashboard/admin">Dashboard</a>
            @endif
        @elseif(Auth::guard('mentor')->check())
            @if (Route::is('dashboard.mentor'))
                <a href="/dashboard/mentor" class="font-medium">Dashboard</a>
            @else
                <a href="/dashboard/mentor">Dashboard</a>
            @endif
        @elseif(Auth::guard('customer')->check())
            @if (Route::is('dashboard.customer'))
                <a href="/dashboard/customer" class="font-medium">Dashboard</a>
            @else
                <a href="/dashboard/customer">Dashboard</a>
            @endif
        @endif
    </li>
    <li class="hover:font-medium">
        <a href="{{ route('dashboard.students.index') }}"
            class="{{ Route::is('dashboard.students.*') ? 'font-medium' : '' }}">
            Participants
        </a>
    </li>
    @if (Auth::guard('web')->check())
        <li class="hover:font-medium">
            <a href="{{ route('dashboard.staffs.index') }}"
                class="{{ Route::is('dashboard.staffs.*') ? 'font-medium' : '' }}">
                Mentor & Staff
            </a>
        </li>
        {{-- <li class="hover:font-medium">
        @if (Route::is('dashboard.institutions_partners'))
          <a href="/dashboard/institutions_partners" class="font-medium">Institutions & Partner</a>
        @else
          <a href="/dashboard/institutions_partners">Institutions & Partner</a>
        @endif
    </li> --}}
    @endif

    <li class="hover:font-medium">
        @if (Route::is('dashboard.projects.index'))
            <a href="/dashboard/projects" class="font-medium">Projects</a>
        @else
            <a href="/dashboard/projects">Projects</a>
        @endif
    </li>
    @if (Auth::guard('customer')->check())
        <li class="hover:font-medium">
            @if (Route::is('dashboard.customers.index'))
                <a href="/dashboard/customers" class="font-medium">Customers</a>
            @else
                <a href="/dashboard/customers">Customers</a>
            @endif
        </li>
    @endif

    @if (Auth::guard('web')->check())
        <li x-data="{ isExpanded: false }" class="flex flex-col gap-4">
            <button x-on:click="isExpanded = !isExpanded"
                class="{{ Route::is('dashboard.internal-document.*') ? 'font-medium' : '' }} w-max flex items-center gap-3 hover:font-medium">
                <i x-bind:class="isExpanded ? 'fas fa-chevron-up fa-xs' : 'fas fa-chevron-down fa-xs'"></i>
                Internal Document
            </button>

            <div x-show="isExpanded" class="pr-4 flex flex-col gap-4 border-e border-white">
                <a href="{{ route('dashboard.internal-document.all-pages.index') }}"
                    class="{{ Route::is('dashboard.internal-document.all-pages.*') ? 'font-medium' : '' }} hover:font-medium">
                    All Pages
                </a>

                <a href="{{ route('dashboard.internal-document.group-section.index') }}"
                    class="{{ Route::is('dashboard.internal-document.group-section.*') ? 'font-medium' : '' }} hover:font-medium">
                    Group Section
                </a>
            </div>
        </li>
    @endif

    @if (Auth::guard('web')->check() ||
            (Auth::guard('mentor')->check() && Auth::guard('mentor')->user()->institution_id === 0))
        <li class="hover:font-medium">
            @if (Route::is('dashboard.testimonial'))
                <a href="{{ route('dashboard.testimonial') }}" class="font-medium">Testimonials</a>
            @else
                <a href="{{ route('dashboard.testimonial') }}">Testimonials</a>
            @endif
        </li>
    @endif

    <li class="hover:font-medium">
        @if (Route::is('dashboard.chat'))
            <a href="{{ route('dashboard.chat') }}" class="font-medium">Chat</a>
        @else
            <a href="{{ route('dashboard.chat') }}">Chat</a>
        @endif
    </li>
</ul>
