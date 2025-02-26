<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>{{ $form->title }}</title>
  </head>
  <body>
    <div class="flex flex-col items-center justify-center bg-gray-100 pb-20">
      
      <!-- Gambar di atas card -->
      <div class="relative w-[700px] flex justify-center pb-5">
        <img src="{{ asset($form->thumbnail) }}" alt="Thumbnail Image" class="w-50 border-4 border-white shadow-md mt-16">
      </div>

      <!-- Card -->
      <div class="bg-white shadow-lg rounded-lg p-8 w-[700px] relative">
        <h2 class="text-2xl font-bold">Testing</h2>
        <hr class="border-gray-300 my-4">

        <!-- Gambar dalam card -->
        <div class="my-4 pb-3">
          <img src="{{ asset($form->thumbnail) }}" alt="Naruto Image" class="w-full rounded-lg">
        </div>

        <p class="text-gray-600 text-sm text-center pt-3">
          {!! $form->desc !!}
        </p>
        <hr class="border-gray-300 pb-3">
        
        <!-- Form -->
        <form>
          <div class="grid grid-cols-2 gap-4 pb-4">
            <div>
              <label for="first_name" class="text-gray-900 block pb-2">First Name</label>
              <input type="text" id="first_name" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Full Name" />
            </div>
            <div>
              <label for="email" class="text-gray-900 block pb-2">Email</label>
              <input type="email" id="email" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Email Address" />
            </div>
          </div>

          <div class="pb-4">
            <label for="phone" class="text-gray-900 block pb-2">Phone</label>
            <input type="tel" id="phone" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="Telephone Number" />
          </div>

          @foreach ($form->section as $item)
            <div class="pb-4">
              <label for="{{ $item->name }}" class="text-gray-900 block pb-2">{{ $item->name }}</label>
              <input type="{{ $item->type }}" id="{{ $item->name }}" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow" placeholder="{{ $item->name }}" />
            </div>
          @endforeach

          <div class="pt-3">
            <button class="bg-blue-500 w-full text-white font-medium px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-300">
                Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
