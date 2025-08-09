<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Recap</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 h-screen">

<div class="flex h-full">
  <!-- Sidebar -->
  <aside class="w-64 bg-white border-r border-gray-200">
    @include('sidebar')
  </aside>

  <!-- Main Content -->
  <main class="flex-1 overflow-y-auto p-10">
    <div class="bg-white p-8 rounded-xl shadow-xl border border-gray-100">
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Recap Baru</h2>

      @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('recaps.store') }}" method="POST">
        @csrf

        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Recap</h3>
            <p class="mt-1 text-sm text-gray-600">Masukkan detail recap yang akan dibuat.</p>

            <div class="mt-10 grid grid-cols-1 gap-y-8">

              <!-- Company ID - Now Optional -->
              <div class="col-span-full">
                <label for="company_id" class="block text-sm font-medium text-gray-900">
                  Company ID 
                  <span class="text-red-500">*</span>
                </label>
                <div class="mt-2">
                  <input type="text" name="company_id" id="company_id" value="{{ old('company_id') }}"
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none" 
                    placeholder="Masukkan Company ID" />
                </div>
              </div>

              <!-- Nama Perusahaan -->
              <div class="col-span-full">
                <label for="nama_perusahaan" class="block text-sm font-medium text-gray-900">
                  Nama Perusahaan 
                  <span class="text-red-500">*</span>
                </label>
                <div class="mt-2">
                  <input type="text" name="nama_perusahaan" id="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none" 
                    placeholder="Masukkan nama perusahaan" />
                </div>
              </div>

              <!-- Cabang - Now Optional -->
              <div class="col-span-full">
                <label for="cabang" class="block text-sm font-medium text-gray-900">
                  Cabang 
                  <span class="text-red-500">*</span>
                </label>
                <div class="mt-2">
                  <input type="text" name="cabang" id="cabang" value="{{ old('cabang') }}"
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none" 
                    placeholder="Masukkan nama cabang" />
                </div>
              </div>

              <!-- Sales -->
              <div class="col-span-full">
                <label for="sales" class="block text-sm font-medium text-gray-900">
                  Sales 
                  <span class="text-red-500">*</span>
                </label>
                <div class="mt-2">
                  <input type="text" name="sales" id="sales" value="{{ old('sales') }}" required
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none" 
                    placeholder="Masukkan nama sales" />
                </div>
              </div>

              <!-- Keterangan -->
              <div class="col-span-full">
                <label for="keterangan" class="block text-sm font-medium text-gray-900">Keterangan</label>
                <div class="mt-2">
                  <textarea name="keterangan" id="keterangan" rows="4"
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                    placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') }}</textarea>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="{{ route('recaps.index') }}" class="text-sm font-semibold text-gray-700 hover:underline">Kembali</a>
          <button type="submit"
            class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-700 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-gray-700">
            Simpan Recap
          </button>
        </div>
      </form>
    </div>
  </main>
</div>

</body>
</html>