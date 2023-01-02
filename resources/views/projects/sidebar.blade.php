<div class="col">
  <div class="card bg-light p-4  text-dark">
    <a href="/projects" class="text-decoration-none">Available Project</a>
    <a href="/projects/{{ Auth::guard('student')->user()->id }}/applied" class="text-decoration-none">Applied Project</a>
  </div>
</div>