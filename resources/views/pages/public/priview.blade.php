<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>{{ $form->title }}</title>
  </head>
  <body class="bg-gray-100">
    <div class="flex flex-col items-center justify-center pb-10 px-4 sm:px-6 md:px-8 lg:px-10">
      
      <!-- Gambar di atas card -->
      <div class="relative w-full max-w-xl flex justify-center pb-5">
        @if ($form->header != null)
          <img src="{{ asset($form->header) }}" alt="Thumbnail Image" class="w-32 sm:w-40 md:w-50 border-4 border-white shadow-md mt-16">
        @else
          <div class="mt-10"></div>
        @endif
      </div>
      

      @if (session()->has('success'))
          <div class="w-full max-w-xl bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
              {{ session()->get('success') }}
          </div>
      @endif

      @if (session()->has('error'))
          <div class="w-full max-w-xl bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
              {{ session()->get('error') }}
          </div>
      @endif

      <!-- Card -->
      <div class="bg-white shadow-lg rounded-lg p-6 sm:p-8 w-full max-w-xl relative">
        <h2 class="text-2xl font-bold">{{ $form->title }}</h2>
        <hr class="border-gray-300 my-4">

        @if ($form->thumbnail != null)
          <!-- Gambar dalam card -->
          <div class="my-4 pb-3">
            <img src="{{ asset($form->thumbnail) }}" alt="Naruto Image" class="w-full rounded-lg">
          </div>
        @endif

        <p class="text-gray-600 text-sm text-center pt-3">
          {!! $form->desc !!}
        </p>
        <hr class="border-gray-300 pb-3">
        @if ($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative pb-5" role="alert">
              <ul class="list-disc pl-5">
                  @foreach ($errors->all() as $err)
                      <li>{{ $err }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        <!-- Form -->
        <form method="POST" action="{{ route('form.public.submit') }}" class="mt-5">
          @csrf
          <input type="hidden" name="forms_id" id="forms_id" value="{{ $form->id }}">
          <input type="hidden" name="users_id" id="users_id" value="{{ $form->users_id }}">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4">
            <div>
              <label for="username" class="text-gray-900 block pb-2">First Name</label>
              <input type="text" name="username" id="username" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Full Name" />
            </div>
            <div>
              <label for="email" class="text-gray-900 block pb-2">Email</label>
              <input type="email" name="email" id="email" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Email Address" />
            </div>
          </div>

          <div class="pb-4">
            <label for="phone" class="text-gray-900 block pb-2">Phone</label>
            <input type="tel" name="phone" id="phone" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Telephone Number" />
            <span class="text-sm text-gray-400 m-1">
              Please enter the telephone number in the format +60
            </span>
          </div>

          @foreach ($form->section as $item)
            <div class="pb-4">
              <label for="{{ $item->name }}" class="text-gray-900 block pb-2">{{ $item->name }}</label>
              <input type="{{ $item->type }}" id="{{ $item->name }}" name="section_form[]" {{ $item->is_required === 'yes' ? 'required' : '' }} class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="{{ $item->name }}" />
              <input type="hidden" name="sections_id[]" id="sections_id" value="{{ $item->id }}">
              <input type="hidden" name="type[]" id="type" value="{{ $item->type }}">
            </div>
          @endforeach
        </form>
      </div>
    </div>
  </body>
</html>