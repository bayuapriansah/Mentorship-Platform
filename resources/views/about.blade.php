@extends('layouts.index')
@section('content')
<section id="about" class="w-full min-h-screen">
  <div class="relative">
    <img src="{{asset('assets/img/about.png')}}" alt="" class="w-full">
    <div class="absolute bottom-14 left-32 text-white">
      <h1 class="font-bold text-3xl">About</h1>
      <h1 class="font-bold text-3xl"><span class="text-light-brown">Simulated Internship</span> Platform</h1>
    </div>
  </div>
  <div class="max-w-[1366px] mx-auto px-16 py-16 z-30 text-lg space-y-5 text-justify">
    <section id="main-text">
      <p>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maxime quasi dolores nulla fugiat? Quod quos, numquam assumenda deleniti provident facere sit cupiditate. Numquam quidem non iure quos, dolore placeat maxime voluptas incidunt officiis porro sed facere ullam dolorum vel eius, quam impedit corrupti, fugit totam! Consequuntur unde porro harum, pariatur inventore quos laboriosam laborum ipsa fugit delectus cum praesentium nulla dolor soluta culpa asperiores ducimus dolorem minus cupiditate incidunt veniam et voluptas? Eaque aut, temporibus vitae laudantium molestiae consequuntur exercitationem eveniet cumque maxime! Magni, ipsa, natus suscipit velit doloribus consectetur debitis, soluta quia est sapiente aliquam aliquid labore ut quae.
      </p>
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque aspernatur suscipit architecto voluptatibus consectetur explicabo non accusamus velit minima. Repudiandae molestias explicabo, ducimus fugiat neque nesciunt beatae tenetur laborum iste harum expedita est nostrum mollitia nobis? Ab minus officia, vitae ea saepe accusantium distinctio, placeat corporis natus sint architecto expedita impedit nesciunt quaerat quam eaque libero quibusdam? Et quis atque magni corporis sunt, suscipit, qui quidem nobis laboriosam, voluptatum similique error veritatis placeat totam optio tempore? Modi eum amet eius libero beatae adipisci, numquam, nam, tempore iure deleniti tenetur quos culpa! Aliquid, minus reprehenderit. Ratione vel quibusdam optio. Cupiditate vero praesentium, officiis numquam earum nam doloribus ullam fuga assumenda eos, veritatis maxime adipisci fugit quaerat tempora? Ut provident, quod illo deserunt assumenda dicta corporis porro magni incidunt odio dolorem corrupti hic earum. Sapiente quam eligendi error quos nemo doloremque quibusdam odio architecto aut fugiat corrupti quo dicta placeat laboriosam, ut nesciunt atque animi sequi exercitationem suscipit! Possimus neque ab labore non eligendi quaerat laborum in voluptatem! Doloremque delectus possimus molestiae voluptate, repudiandae asperiores optio expedita blanditiis reiciendis officiis ipsa temporibus reprehenderit vero sint quae sed aperiam tempora! Excepturi, fugit voluptas expedita nobis quas praesentium soluta quidem cum eum architecto unde.
      </p>
    </section>

    <div class="grid grid-cols-12 gap-11 grid-flow-col  relative">
      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 -top-32 right-0" aria-hidden="true" >
      <img src="{{asset('assets/img/dots-1.png')}}" alt="dots" class="absolute z-10 top-10 left-0 " aria-hidden="true" >
      <div class="col-span-4">
        <div class="flex flex-col">
          <img src="{{asset('assets/img/for_students.png')}}" class="relative z-20" alt="for students">
          <h1 class="text-dark-blue text-2xl font-bold py-3">For Students</h1>
          <p class="text-black font-normal text-sm">Acquire Employability Skills, Gain Industry Experience, Strengthen Project Portfolio</p>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex flex-col">
          <img src="{{asset('assets/img/for_institution.png')}}" class="relative z-20 mt-5" alt="for students">
          <h1 class="text-dark-blue text-2xl font-bold py-3 -mt-4">For Institutes</h1>
          <p class="text-black font-normal text-sm">Enhanced Student Employability, Collaborate with Industry leaders, Supervise Real-World AI Projects</p>
        </div>
      </div>
      <div class="col-span-4">
        <div class="flex flex-col">
          <img src="{{asset('assets/img/for_industries.png')}}" class="relative z-20" alt="for students">
          <h1 class="text-dark-blue text-2xl font-bold py-3">For Industries</h1>
          <p class="text-black font-normal text-sm">Identify Top Future Talents, Collaborate with Top Institutions, Explore Fresh Perspectives on Industry Use-Cases</p>
        </div>
      </div>
    </div>
  </div>
  
</section>
@endsection