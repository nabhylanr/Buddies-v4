<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Recap</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    /* Card transition */
    .recap-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.6s ease;
    }

    .recap-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Filter panel styling */
    .filter-panel {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.4s ease;
      backdrop-filter: blur(10px);
    }

    /* Buttons */
    .btn-primary {
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.6s ease;
    }

    .btn-primary:hover::before {
      left: 100%;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    /* Table row hover */
    .table-row {
      transition: all 0.3s ease;
    }

    .table-row:hover {
      background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
      transform: translateX(4px);
    }

    /* Inputs focus */
    .form-input {
      transition: all 0.3s ease;
    }

    .form-input:focus {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Badge hover */
    .badge {
      transition: transform 0.3s ease;
    }

    .badge:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body class="bg-gray-50 h-screen">
<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-white border-r border-gray-200 shadow-lg">
    @include('sidebar')
  </aside>

  <!-- Main Content -->
  <main class="flex-1 overflow-y-auto p-6">
    <div class="recap-card p-8 rounded-xl shadow-xl border border-gray-100">
      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Daftar Recap</h2>
          <p class="mt-1 text-sm text-gray-600">Kelola semua recap perusahaan Anda.</p>
        </div>
      </div>

      <!-- Success Message -->
      @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded transition-all duration-500 ease-in-out">
          {{ session('success') }}
        </div>
      @endif

      <!-- Filter Dropdown -->
      <div x-data="{ open: false }" class="relative mb-6">
        <div class="flex justify-end">
          <button @click="open = !open"
                  class="btn-primary inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none">
            <svg class="w-4 h-4 mr-2 text-gray-600 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2H3V4zM3 8h18v12a1 1 0 01-1 1H4a1 1 0 01-1-1V8z" />
            </svg>
            Filter
          </button>
        </div>

        <!-- Floating Panel -->
        <div x-show="open" 
             @click.outside="open = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
            class="filter-panel absolute right-0 mt-2 w-full max-w-md bg-white border border-gray-200 rounded-lg shadow-lg p-6 z-50">
          <form method="GET" action="{{ route('user.recaps.user') }}" class="space-y-4">
            
            <!-- Company ID -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Company ID</label>
              <input type="text" name="company_id" value="{{ request('company_id') }}" placeholder="Cari berdasarkan Company ID"
                    class="form-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-900 focus:ring-2 focus:ring-gray-600 focus:outline-none" />
            </div>

            <!-- Nama Perusahaan -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
              <input type="text" name="nama_perusahaan" value="{{ request('nama_perusahaan') }}" placeholder="Cari berdasarkan Nama Perusahaan"
                    class="form-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-900 focus:ring-2 focus:ring-gray-600 focus:outline-none" />
            </div>

            <!-- Cabang -->
            <div>
              <label for="cabang" class="block text-sm font-medium text-gray-700 mb-1">Cabang</label>
              <select name="cabang" id="cabang"
                      class="form-input appearance-none w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none">
                <option value="">Semua Cabang</option>
                @foreach($cabangList as $cabang)
                  <option value="{{ $cabang }}" {{ request('cabang') == $cabang ? 'selected' : '' }}>
                    {{ $cabang }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Status -->
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
              <select name="status" id="status"
                      class="form-input appearance-none w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none">
                <option value="">Semua Status</option>
                @foreach($statusList as $status)
                  <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ $status }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="flex justify-between mt-4">
              <a href="{{ route('user.recaps.user') }}" class="text-sm text-gray-600 hover:underline transition-all duration-300 hover:text-gray-800">Reset</a>
              <button type="submit"
                      class="btn-primary px-4 py-2 bg-gray-900 text-white text-sm rounded-md shadow hover:bg-gray-700">Terapkan</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Table -->
      @if($recaps->isEmpty())
        <div class="text-center py-12">
          <p class="text-gray-500 text-lg">Belum ada recap yang tersedia</p>
          <p class="text-gray-400 text-sm mt-2">Mulai dengan menambahkan recap baru</p>
        </div>
      @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th class="px-6 py-3">Company ID</th>
                <th class="px-6 py-3">Nama Perusahaan</th>
                <th class="px-6 py-3">Cabang</th>
                <th class="px-6 py-3">Sales</th>
                <th class="px-6 py-3">Keterangan</th>
                <th class="px-6 py-3">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recaps as $recap)
                <tr class="table-row bg-white border-b hover:bg-gray-50">
                  <td class="px-6 py-4 font-medium text-gray-900">{{ $recap->company_id }}</td>
                  <td class="px-6 py-4">{{ $recap->nama_perusahaan }}</td>
                  <td class="px-6 py-4">{{ $recap->cabang }}</td>
                  <td class="px-6 py-4">{{ $recap->sales }}</td>
                  <td class="px-6 py-4">
                    <div class="max-w-xs truncate" title="{{ $recap->keterangan }}">
                      {{ $recap->keterangan ?? '-' }}
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="badge px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                      {{ $recap->status === 'pending' ? 'bg-red-100 text-red-800' : 
                        ($recap->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                        'bg-green-100 text-green-800') }}">
                      {{ ucfirst($recap->status) }}
                    </span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
          {{ $recaps->appends(request()->input())->links() }}
        </div>
      @endif
    </div>
  </main>
</div>
</body>
</html>