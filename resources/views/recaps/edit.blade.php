<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Recap</title>
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
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Recap</h2>

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          <ul class="list-disc pl-5 text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('recaps.update', $recap->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-8">
          <!-- Company ID -->
          <div>
            <label for="company_id" class="block text-sm font-medium text-gray-900">Company ID</label>
            <input type="text" id="company_id" name="company_id"
                   value="{{ old('company_id', $recap->company_id) }}"
                   class="mt-2 w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                   required />
          </div>

          <!-- Nama Perusahaan -->
          <div>
            <label for="nama_perusahaan" class="block text-sm font-medium text-gray-900">Nama Perusahaan</label>
            <input type="text" id="nama_perusahaan" name="nama_perusahaan"
                   value="{{ old('nama_perusahaan', $recap->nama_perusahaan) }}"
                   class="mt-2 w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                   required />
          </div>

          <!-- Cabang -->
          <div>
            <label for="cabang" class="block text-sm font-medium text-gray-900">Cabang</label>
            <input type="text" id="cabang" name="cabang"
                  value="{{ old('cabang', $recap->cabang) }}"
                  class="mt-2 w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                  placeholder="Masukkan nama cabang" required />
          </div>


          <!-- Sales -->
          <div>
            <label for="sales" class="block text-sm font-medium text-gray-900">Sales</label>
            <input type="text" id="sales" name="sales"
                  value="{{ old('sales', $recap->sales) }}"
                  class="mt-2 w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                  placeholder="Masukkan nama sales" required />
          </div>

          <!-- Keterangan -->
          <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-900">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4"
                      class="mt-2 w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none"
                      placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $recap->keterangan) }}</textarea>
          </div>

          <!-- Info Recap -->
          <div class="bg-gray-50 p-4 rounded-md border text-sm text-gray-600">
            <p class="font-medium text-gray-800 mb-1">Informasi Recap</p>
            <p>Dibuat: {{ $recap->created_at->format('d M Y H:i') }}</p>
            @if($recap->updated_at != $recap->created_at)
              <p>Terakhir diupdate: {{ $recap->updated_at->format('d M Y H:i') }}</p>
            @endif
          </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-x-4">
          <a href="{{ route('recaps.index') }}" class="text-sm font-semibold text-gray-700 hover:underline">Kembali</a>
          <button type="submit"
                  class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-700 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-gray-700">
            Update Recap
          </button>
        </div>
      </form>
    </div>
  </main>
</div>

</body>
</html>
