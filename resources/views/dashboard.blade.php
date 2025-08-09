<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kopra Buddies</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Recap Card Transition */
    .recap-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.6s ease;
    }
    .recap-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Filter Panel Transition */
    .filter-panel {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.4s ease;
      backdrop-filter: blur(10px);
    }

    /* Button Transitions */
    .btn-primary {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
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
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Table Row Transitions */
    .table-row {
      transition: all 0.3s ease;
    }
    .table-row:hover {
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      transform: translateX(4px);
    }

    /* Form Input Transitions */
    .form-input {
      transition: all 0.3s ease;
    }
    .form-input:focus {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Status Button Transition */
    .status-btn {
      transition: all 0.3s ease;
    }
    .status-btn:hover {
      transform: scale(1.1);
    }

    /* Badge Transitions */
    .badge {
      transition: all 0.3s ease;
    }
    .badge:hover {
      transform: scale(1.05);
    }

    /* Loading Animation */
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    .loading {
      animation: pulse 2s infinite;
    }

    /* Task Item Hover Effects */
    .task-item {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .task-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.05), transparent);
      transition: left 0.6s ease;
    }
    .task-item:hover::before {
      left: 100%;
    }
    .task-item:hover {
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      transform: translateX(4px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Reminder Container */
    .reminder-container {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.4s ease;
    }
    .reminder-container:hover {
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Statistics Cards */
    .stats-card {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.6s ease;
    }
    .stats-card:hover::before {
      left: 100%;
    }
    .stats-card:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* Action Buttons */
    .action-btn {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .action-btn:hover {
      transform: scale(1.1);
    }

    /* Checkbox Animation */
    .checkbox-btn {
      transition: all 0.3s ease;
    }
    .checkbox-btn:hover {
      transform: scale(1.1);
      border-color: #1f2937;
    }

    /* Filter Button Enhanced */
    .filter-btn {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .filter-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.6s ease;
    }
    .filter-btn:hover::before {
      left: 100%;
    }
    .filter-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Alert Animation */
    .alert-slide {
      animation: slideIn 0.5s ease-out;
    }
    @keyframes slideIn {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    /* Main Container */
    .main-container {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.4s ease;
    }

    /* Chart Container */
    .chart-container {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
    }
    .chart-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.8s ease;
    }
    .chart-container:hover::before {
      left: 100%;
    }
    .chart-container:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Chart Animation */
    @keyframes chartFadeIn {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }
    .chart-animate {
      animation: chartFadeIn 1s ease-out;
    }

    /* Statistics Container */
    .stats-container {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      transition: all 0.4s ease;
    }
    .stats-container:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

     .floating-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        .bear-container {
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.1));
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
        <div class="main-container bg-white p-8 rounded-xl shadow-xl border border-gray-100 flex items-center justify-between relative overflow-hidden">
            <div class="flex-1 max-w-2xl pr-6">
                <h2 class="text-2xl font-bold text-gray-800">Hello, {{Auth::user()->name}}!</h2>
                <p class="text-sm text-gray-600 mt-2">
                    Kopra Buddies helps you stay organized and in control by assisting with scheduling client implementations, managing timelines, and coordinating every step of your tasks. Whether it's planning, tracking, or collaborating, we make everything seamless and stress-free. So let's start!
                </p>
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('tasks.index') }}"
                        class="btn-primary inline-flex items-center justify-center px-4 py-2 rounded-md bg-white text-black text-sm font-semibold shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        View All Tasks
                    </a>
                    <a href="{{ route('tasks.create') }}"
                        class="btn-primary inline-flex items-center justify-center px-4 py-2 rounded-md bg-black text-white text-sm font-semibold shadow hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2 text-white transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Task
                    </a>
                </div>
            </div>            
            <div class="bear-container floating-animation flex-shrink-0 relative">
                <img src="{{ asset('images/hello.png') }}" 
                     class="w-48 h-48 object-contain transform scale-150 -translate-x-9">
                <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-24 h-4 bg-gray-200 rounded-full opacity-30 blur-sm floating-shadow"></div>
            </div>
        </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="lg:col-span-1">
            <div class="stats-container bg-white p-6 rounded-xl shadow-xl border border-gray-100 h-full">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Task Statistics</h3>
                <div class="space-y-4">
                    <!-- Total Task -->
                    <div class="stats-card bg-gradient-to-r from-black to-gray-800 rounded-xl p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-200 text-sm">Total Task</p>
                                <p class="text-2xl font-bold">{{ $totalTasks }}</p>
                            </div>
                            <div class="text-gray-300">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>   
                    <!-- Hari Ini -->
                    <div class="stats-card bg-gradient-to-r from-gray-900 to-gray-700 rounded-xl p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-200 text-sm">Hari Ini</p>
                                <p class="text-2xl font-bold">{{ $todayTasks }}</p>
                            </div>
                            <div class="text-gray-300">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"/>
                                </svg>
                            </div>
                        </div>
                    </div>                   
                    <!-- Minggu Ini -->
                    <div class="stats-card bg-gradient-to-r from-gray-800 to-gray-600 rounded-xl p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-200 text-sm">Minggu Ini</p>
                                <p class="text-2xl font-bold">{{ $weekTasks }}</p>
                            </div>
                            <div class="text-gray-300">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>                    
                    <!-- Overdue -->
                    <div class="stats-card bg-gradient-to-r from-red-600 to-red-700 rounded-xl p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Overdue</p>
                                <p class="text-2xl font-bold">{{ $overdueTasks }}</p>
                            </div>
                            <div class="text-red-200">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chart Section -->
        <div class="lg:col-span-1">
            <div class="chart-container bg-white p-6 rounded-xl shadow-xl border border-gray-100 h-full">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Task Distribution</h3>
                <div class="mt-6 chart-animate relative h-64 flex items-center justify-center">
                    <canvas id="taskChart" width="250" height="250"></canvas>
                </div>
                <!-- Legend -->
                <div class="mt-10 space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-black rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Hari Ini</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $todayTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-700 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Minggu Ini</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $weekTasks - $todayTasks }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Overdue</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $overdueTasks }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container bg-white p-8 rounded-xl shadow-xl border border-gray-100 mt-6">
      @if(session('success'))
        <div class="alert-slide mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
          </svg>
          {{ session('success') }}
        </div>
      @endif
      <!-- Overdue Tasks Alert -->
        @if($overdueTasks > 0)
        <div class="alert-slide mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="text-red-800 font-semibold text-base">
                Peringatan: Ada {{ $overdueTasks }} task yang overdue!
                </h3>
                <p class="text-red-600 text-xs">
                Segera selesaikan atau jadwalkan task yang sudah melewati deadline.
                </p>
            </div>
            </div>
        </div>
        @endif
      <!-- Filter Options -->
    <div class="mb-6" x-data="{ currentFilter: 'all' }">
        <div class="filter-panel p-4 rounded-lg">
            <div class="flex flex-wrap gap-2">
            <!-- Semua Task -->
            <button @click="currentFilter = 'all'; filterTasks('all')" 
                    :class="currentFilter === 'all' 
                            ? 'bg-black text-white' 
                            : 'bg-white text-black text-sm font-semibold shadow-sm ring-1 ring-inset ring-black hover:bg-gray-50'"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition">
                Semua Task
            </button>
            <!-- Hari Ini -->
            <button @click="currentFilter = 'today'; filterTasks('today')" 
                    :class="currentFilter === 'today' 
                            ? 'bg-black text-white' 
                            : 'bg-white text-black text-sm font-semibold shadow-sm ring-1 ring-inset ring-black hover:bg-gray-50'"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition">
                Hari Ini
            </button>
            <!-- Minggu Ini -->
            <button @click="currentFilter = 'week'; filterTasks('week')" 
                    :class="currentFilter === 'week' 
                            ? 'bg-black text-white' 
                            : 'bg-white text-black text-sm font-semibold shadow-sm ring-1 ring-inset ring-black hover:bg-gray-50'"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition">
                Minggu Ini
            </button>

            <!-- Overdue -->
            <button @click="currentFilter = 'overdue'; filterTasks('overdue')" 
                    :class="currentFilter === 'overdue' 
                            ? 'bg-red-800 text-white' 
                            : 'bg-white text-red-600 text-sm font-semibold shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-50'"
                    class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition">
                Overdue
            </button>
            </div>
        </div>
    </div>
    
      <!-- Task List - Reminders Style -->
      <div id="taskContainer">
        @if($tasks->isEmpty())
          <div class="text-center py-12">
            <div class="bg-gray-50 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
              <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
            </div>
            <p class="text-gray-500 text-lg">Belum ada task yang tersedia</p>
            <p class="text-gray-400 text-sm mt-2">Mulai dengan menambahkan task baru</p>
          </div>
        @else
          <div class="reminder-container bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
              <h3 class="text-2xl font-semibold text-grey-900">Reminders</h3>
              <div class="bg-gray-900 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                <span id="taskCount">{{ count($tasks) }}</span>
              </div>
            </div>

            <!-- Task List -->
            <div id="taskList" class="divide-y divide-gray-100">
              @foreach($tasks as $task)
                <div class="task-item table-row p-6"
                     data-date="{{ $task->datetime->format('Y-m-d') }}"
                     data-datetime="{{ $task->datetime->format('Y-m-d H:i:s') }}"
                     data-is-overdue="{{ $task->isOverdue() ? 'true' : 'false' }}">
                  <div class="flex items-start space-x-4">
                    <!-- Checkbox -->
                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="inline">
                      @csrf
                      @method('PATCH')
                      <button type="submit" 
                              class="checkbox-btn status-btn mt-1 w-5 h-5 border-2 border-gray-300 rounded-full hover:border-gray-900 flex items-center justify-center group"
                              onclick="return confirm('Tandai task ini sebagai selesai?')">
                        <div class="w-0 h-0 bg-gray-900 rounded-full group-hover:w-2 group-hover:h-2 transition-all duration-200"></div>
                      </button>
                    </form>

                    <!-- Task Content -->
                    <div class="flex-1 min-w-0"> 
                      <div class="flex items-center justify-between"> 
                        <div class="flex-1">
                          <h4 class="text-s font-semibold text-gray-800 mb-0.5">{{ $task->title ?? $task->description }}</h4> 
                          <div class="flex items-center space-x-3 text-xs text-gray-500">
                            <span class="{{ $task->isOverdue() ? 'text-red-600 font-semibold' : '' }}">
                              {{ $task->datetime->format('d/m/Y H:i') }}
                              @if($task->isOverdue())
                                <span class="text-red-500 ml-1">({{ $task->overdue_duration }})</span>
                              @endif
                            </span>
                            <span>{{ $task->place }}</span>
                            <span>{{ $task->implementor }}</span>
                          </div>
                          @if($task->isOverdue())
                            <div class="mt-1">
                              <span class="badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Overdue
                              </span>
                            </div>
                          @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2 ml-2">
                          <a href="{{ route('tasks.edit', $task->id) }}"
                              class="action-btn text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100">
                              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                          </a>
                          <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit"
                                      class="action-btn text-gray-400 hover:text-red-600 p-1 rounded-full hover:bg-red-50"
                                      onclick="return confirm('Yakin ingin menghapus task ini?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                              </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('taskChart').getContext('2d');
    
    const todayTasks = {{ $todayTasks }};
    const weekTasks = {{ $weekTasks }};
    const overdueTasks = {{ $overdueTasks }};
    const totalTasks = {{ $totalTasks }};
    
    const weekOnlyTasks = weekTasks - todayTasks; 
    
    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Hari Ini', 'Minggu Ini', 'Overdue'],
            datasets: [{
                data: [todayTasks, weekOnlyTasks, overdueTasks],
                backgroundColor: [
                    '#000000',  
                    '#374151',  
                    '#ef4444',  
                ],
                borderWidth: 0,
                cutout: '65%' 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: false,
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });    
    ctx.canvas.style.cursor = 'pointer';
});
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function filterTasks(filter) {
  const taskItems = document.querySelectorAll('.task-item');
  const today = new Date();
  
  const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  const todayEnd = new Date(todayStart.getTime() + 24 * 60 * 60 * 1000 - 1); 
  
  let visibleCount = 0;
  
  taskItems.forEach(item => {
    const taskDatetime = new Date(item.dataset.datetime);
    const taskDate = new Date(taskDatetime.getFullYear(), taskDatetime.getMonth(), taskDatetime.getDate());
    const isOverdue = item.dataset.isOverdue === 'true';
    let shouldShow = false;
    
    switch(filter) {
      case 'today':
        shouldShow = taskDate.getTime() === todayStart.getTime();
        break;
        
      case 'week':
        const startOfWeek = new Date(todayStart);
        startOfWeek.setDate(todayStart.getDate() - todayStart.getDay());
        
        const endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(startOfWeek.getDate() + 6);
        
        shouldShow = taskDate >= startOfWeek && taskDate <= endOfWeek;
        break;
        
      case 'overdue':
        shouldShow = isOverdue;
        break;
        
      case 'upcoming':
        shouldShow = taskDate > todayStart;
        break;
        
      default: 
        shouldShow = true;
    }
    
    if (shouldShow) {
      item.style.display = 'block';
      visibleCount++;
    } else {
      item.style.display = 'none';
    }
  });
  
  document.getElementById('taskCount').textContent = visibleCount;
}

window.filterTasks = filterTasks;

document.addEventListener('DOMContentLoaded', function() {
  filterTasks('all');
});
</script>
</body>
</html>