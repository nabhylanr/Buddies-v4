<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Task</title>
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
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Task</h2>

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

      <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Task</h3>
            <p class="mt-1 text-sm text-gray-600">Perbarui detail task.</p>

            <div class="mt-10 grid grid-cols-1 gap-y-8">

              <!-- Company/Recap Selection -->
              <div class="col-span-full">
                <label for="recap_id" class="block text-sm font-medium text-gray-900">Perusahaan</label>
                <div class="mt-2 relative">
                  <select name="recap_id" id="recap_id" required
                    class="appearance-none w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none pr-10">
                    <option value="">Pilih Perusahaan</option>
                    @foreach($recaps as $recap)
                      <option value="{{ $recap->id }}" {{ old('recap_id', $task->recap_id) == $recap->id ? 'selected' : '' }}>
                        {{ $recap->nama_perusahaan }} - {{ $recap->cabang }}
                      </option>
                    @endforeach
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7l3-3 3 3m0 6l-3 3-3-3"/>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Implementor Dropdown -->
              <div class="col-span-full">
                <label for="implementor" class="block text-sm font-medium text-gray-900">Implementor</label>
                <div class="mt-2 relative">
                  <select name="implementor" id="implementor" required
                    class="appearance-none w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none pr-10">
                    <option value="">Pilih Implementor</option>
                    <option value="Pipin" {{ old('implementor', $task->implementor) == 'Pipin' ? 'selected' : '' }}>Pipin</option>
                    <option value="Adit" {{ old('implementor', $task->implementor) == 'Adit' ? 'selected' : '' }}>Adit</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7l3-3 3 3m0 6l-3 3-3-3"/>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Date -->
              <div class="col-span-full">
                <label for="date" class="block text-sm font-medium text-gray-900">Tanggal</label>
                <div class="mt-2">
                  <input type="date" name="date" id="date"
                    value="{{ old('date', \Carbon\Carbon::parse($task->datetime)->format('Y-m-d')) }}"
                    required
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none" />
                </div>
              </div>

              <!-- Time -->
              <div class="col-span-full">
                <label for="time" class="block text-sm font-medium text-gray-900">Jam</label>
                <div class="mt-2 relative">
                  <select name="time" id="time" required
                    class="appearance-none w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none pr-10">
                    <option value="">Pilih Jam</option>
                    <option value="10:00" {{ old('time', \Carbon\Carbon::parse($task->datetime)->format('H:i')) == '10:00' ? 'selected' : '' }}>10.00</option>
                    <option value="13:00" {{ old('time', \Carbon\Carbon::parse($task->datetime)->format('H:i')) == '13:00' ? 'selected' : '' }}>13.00</option>
                    <option value="15:00" {{ old('time', \Carbon\Carbon::parse($task->datetime)->format('H:i')) == '15:00' ? 'selected' : '' }}>15.00</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7l3-3 3 3m0 6l-3 3-3-3"/>
                    </svg>
                  </div>
                </div>
                <div id="time-conflict-message" class="mt-2 text-sm text-red-600 hidden"></div>
              </div>

              <!-- Place Dropdown -->
              <div class="col-span-full">
                <label for="place" class="block text-sm font-medium text-gray-900">Tempat</label>
                <div class="mt-2 relative">
                  <select name="place" id="place" required
                    class="appearance-none w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none pr-10">
                    <option value="">Pilih Tempat</option>
                    <option value="Online" {{ old('place', $task->place) == 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Offline" {{ old('place', $task->place) == 'Offline' ? 'selected' : '' }}>Offline</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7l3-3 3 3m0 6l-3 3-3-3"/>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Description -->
              <div class="col-span-full">
                <label for="description" class="block text-sm font-medium text-gray-900">Deskripsi</label>
                <div class="mt-2">
                  <textarea name="description" id="description" rows="4" required
                    class="w-full rounded-md bg-white px-3 py-2 text-sm text-gray-900 border border-gray-300 focus:ring-2 focus:ring-gray-600 focus:outline-none">{{ old('description', $task->description) }}</textarea>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-gray-700 hover:underline">Kembali</a>
          <button type="submit" id="submit-btn"
            class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-700 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-gray-700">
            Update Task
          </button>
        </div>
      </form>
    </div>
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const implementorSelect = document.getElementById('implementor');
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    const timeConflictMessage = document.getElementById('time-conflict-message');
    const submitBtn = document.getElementById('submit-btn');
    
    const currentTaskId = {{ $task->id }};

    function checkAvailableTimeSlots() {
        const implementor = implementorSelect.value;
        const date = dateInput.value;

        if (!implementor || !date) {
            resetTimeOptions();
            return;
        }

        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="">Mengecek ketersediaan...</option>';

        fetch(`/api/tasks/available-time-slots?implementor=${implementor}&date=${date}&exclude_task_id=${currentTaskId}`)
            .then(response => response.json())
            .then(data => {
                updateTimeOptions(data.available_slots, data.used_slots);
            })
            .catch(error => {
                console.error('Error:', error);
                resetTimeOptions();
            })
            .finally(() => {
                timeSelect.disabled = false;
            });
    }

    function updateTimeOptions(availableSlots, usedSlots) {
        const allSlots = [
            { value: '10:00', text: '10.00' },
            { value: '13:00', text: '13.00' },
            { value: '15:00', text: '15.00' }
        ];

        const currentSelectedTime = '{{ old("time", \Carbon\Carbon::parse($task->datetime)->format("H:i")) }}';
        
        timeSelect.innerHTML = '<option value="">Pilih Jam</option>';
        
        allSlots.forEach(slot => {
            const option = document.createElement('option');
            option.value = slot.value;
            option.textContent = slot.text;
            
            if (slot.value === currentSelectedTime) {
                option.selected = true;
            }
            
            if (usedSlots.includes(slot.value)) {
                option.disabled = true;
                option.textContent += ' (Tidak tersedia)';
                option.style.color = '#9CA3AF';
            }
            
            timeSelect.appendChild(option);
        });

        if (availableSlots.length === 0) {
            timeConflictMessage.textContent = `Semua slot waktu untuk ${implementorSelect.value} pada tanggal ${dateInput.value} sudah terisi.`;
            timeConflictMessage.classList.remove('hidden');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            timeConflictMessage.classList.add('hidden');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function resetTimeOptions() {
        const currentSelectedTime = '{{ old("time", \Carbon\Carbon::parse($task->datetime)->format("H:i")) }}';
        
        timeSelect.innerHTML = `
            <option value="">Pilih Jam</option>
            <option value="10:00" ${currentSelectedTime === '10:00' ? 'selected' : ''}>10.00</option>
            <option value="13:00" ${currentSelectedTime === '13:00' ? 'selected' : ''}>13.00</option>
            <option value="15:00" ${currentSelectedTime === '15:00' ? 'selected' : ''}>15.00</option>
        `;
        timeConflictMessage.classList.add('hidden');
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    implementorSelect.addEventListener('change', checkAvailableTimeSlots);
    dateInput.addEventListener('change', checkAvailableTimeSlots);

    document.querySelector('form').addEventListener('submit', function(e) {
        const selectedTime = timeSelect.value;
        const selectedOption = timeSelect.querySelector(`option[value="${selectedTime}"]`);
        
        if (selectedOption && selectedOption.disabled) {
            e.preventDefault();
            alert('Waktu yang dipilih tidak tersedia. Silakan pilih waktu lain.');
        }
    });

    checkAvailableTimeSlots();
});
</script>

</body>
</html>