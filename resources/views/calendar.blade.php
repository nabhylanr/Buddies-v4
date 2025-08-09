<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendar Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .dropdown-menu {
      transition: opacity 0.15s ease-out, transform 0.15s ease-out;
      opacity: 0;
      transform: translateY(-8px) scale(0.95);
      pointer-events: none; 
    }
    .dropdown-menu.show {
      opacity: 1;
      transform: translateY(0) scale(1);
      pointer-events: auto; 
    }

    .dropdown-arrow-rotate {
      transform: rotate(180deg);
    }
  </style>
</head>
<body class="bg-gray-50 h-screen">

  <div class="flex h-full">
    <div class="w-64 bg-white border-r border-gray-200">
      {{-- Assuming sidebar content is handled by @include('sidebar') --}}
      @include('sidebar')
    </div>

    <div class="flex-1 overflow-y-auto">
      <div class="lg:flex lg:h-full lg:flex-col">
        <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none">
          <h1 class="text-base font-semibold leading-6 text-gray-900" id="currentMonthYear">
            <time id="headerDate">Loading...</time>
          </h1>
          <div class="flex items-center">
            <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
              <button type="button" id="prevMonth" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50 transition-colors">
                <span class="sr-only">Previous month</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
              </button>
              <button type="button" id="todayBtn" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block transition-colors">Month</button>
              <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
              <button type="button" id="nextMonth" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50 transition-colors">
                <span class="sr-only">Next month</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <div class="hidden md:ml-4 md:flex md:items-center">
              <div class="relative">
                <button type="button" class="flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors" id="menu-button" aria-expanded="false" aria-haspopup="true">
                  <span id="current-view">Month view</span>
                  <svg class="-mr-1 h-5 w-5 text-gray-400 transition-transform duration-200" id="dropdown-arrow" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                  </svg>
                </button>

                <div id="dropdown-menu" class="dropdown-menu absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                  <div class="py-1" role="none">
                    <div class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100">
                      Quick Navigation
                    </div>
                    <div class="grid grid-cols-3 gap-1 p-2" id="month-grid">
                      </div>
                    
                    <div class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider border-t border-b border-gray-100">
                      Year
                    </div>
                    <div class="flex items-center justify-between px-4 py-2">
                      <button type="button" id="prevYear" class="p-1 text-gray-400 hover:text-gray-600 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                      </button>
                      <span class="text-sm font-medium text-gray-900" id="current-year">2024</span>
                      <button type="button" id="nextYear" class="p-1 text-gray-400 hover:text-gray-600 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                      </button>
                    </div>

                    <div class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wider border-t border-b border-gray-100">
                      Quick Actions
                    </div>
                    <button type="button" id="goToToday" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">
                      <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 0 002 2z"></path>
                      </svg>
                      Go to Today
                    </button>
                  </div>
                </div>
              </div>
              <div class="ml-6 h-6 w-px bg-gray-300"></div>
              <a href="{{ route('tasks.create') }}"
                class="ml-6 rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 transition-colors">
                Add Task
              </a>
            </div>
          </div>
        </header>

        <div class="bg-white px-6 py-2 border-b border-gray-200">
          <div class="flex items-center gap-4 text-sm">
            <span class="text-gray-700 font-medium">Implementor:</span>
            <div class="flex items-center gap-2">
              <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-sm">Adit</span>
              <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-sm">Pipin</span>
            </div>
          </div>
        </div>

        <div class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col">
          <div class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs font-semibold leading-6 text-gray-700">
            <div class="bg-white py-2">Sun</div>
            <div class="bg-white py-2">Mon</div>
            <div class="bg-white py-2">Tue</div>
            <div class="bg-white py-2">Wed</div>
            <div class="bg-white py-2">Thu</div>
            <div class="bg-white py-2">Fri</div>
            <div class="bg-white py-2">Sat</div>
          </div>

          <div class="flex bg-gray-200 text-xs leading-6 text-gray-700 lg:flex-auto">
            <div class="w-full lg:grid lg:grid-cols-7 lg:gap-px" id="calendar-grid">
              <div id="loading" class="col-span-7 flex items-center justify-center h-64">
                <div class="text-gray-500">Loading calendar...</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="taskModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Task Details</h3>
              <div class="mt-4" id="modal-content">
                </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="closeModal"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-900 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

<script>
class RealTimeCalendar {
  constructor() {
    this.viewDate = new Date(); 
    this.events = {}; 
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    this.monthNames = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    this.init();
  }

  init() {
    this.setupEventListeners();
    this.updateDropdownContent(); 
    this.loadEventsAndRender(); 
  }

  async loadEventsAndRender() {
    this.render(); 
    await this.loadEvents(); 
    this.render(); 
  }

  async loadEvents() {
    try {
      const start = new Date(this.viewDate.getFullYear(), this.viewDate.getMonth(), 1);
      const end = new Date(this.viewDate.getFullYear(), this.viewDate.getMonth() + 1, 0);
      
      const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
      };
      
      const response = await fetch(`/calendar/events?start=${formatDate(start)}&end=${formatDate(end)}`, {
        headers: {
          'X-CSRF-TOKEN': this.csrfToken,
          'Content-Type': 'application/json',
        }
      });
      
      if (response.ok) {
        this.events = await response.json();
      } else {
        console.error('Failed to load events:', response.statusText);
        this.events = {}; 
      }
    } catch (error) {
      console.error('Error loading events:', error);
      this.events = {}; 
    }
  }

  setupEventListeners() {
    document.getElementById('prevMonth').addEventListener('click', () => {
      this.viewDate.setMonth(this.viewDate.getMonth() - 1);
      this.loadEventsAndRender();
      this.updateDropdownContent(); 
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
      this.viewDate.setMonth(this.viewDate.getMonth() + 1);
      this.loadEventsAndRender();
      this.updateDropdownContent(); 
    });

    document.getElementById('todayBtn').addEventListener('click', () => {
      this.viewDate = new Date();
      this.loadEventsAndRender();
      this.updateDropdownContent(); 
    });

    const menuButton = document.getElementById('menu-button');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const dropdownArrow = document.getElementById('dropdown-arrow');

    menuButton.addEventListener('click', (e) => {
      e.stopPropagation(); 
      if (dropdownMenu.classList.contains('show')) {
        this.closeDropdown();
      } else {
        this.openDropdown();
      }
    });

    document.addEventListener('click', (e) => {
      if (!menuButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
        this.closeDropdown();
      }
    });

    document.getElementById('prevYear').addEventListener('click', (e) => {
      e.stopPropagation(); 
      this.viewDate.setFullYear(this.viewDate.getFullYear() - 1);
      this.loadEventsAndRender(); 
      this.updateDropdownContent();
    });

    document.getElementById('nextYear').addEventListener('click', (e) => {
      e.stopPropagation(); 
      this.viewDate.setFullYear(this.viewDate.getFullYear() + 1);
      this.loadEventsAndRender(); 
      this.updateDropdownContent();
    });

    document.getElementById('goToToday').addEventListener('click', (e) => {
      e.preventDefault(); 
      this.viewDate = new Date();
      this.loadEventsAndRender();
      this.updateDropdownContent();
      this.closeDropdown();
    });

    document.getElementById('closeModal').addEventListener('click', () => {
      document.getElementById('taskModal').classList.add('hidden');
    });

    document.getElementById('taskModal').addEventListener('click', (e) => {
      if (e.target.id === 'taskModal') {
        document.getElementById('taskModal').classList.add('hidden');
      }
    });
  }

  openDropdown() {
    const dropdown = document.getElementById('dropdown-menu');
    const arrow = document.getElementById('dropdown-arrow');
    
    dropdown.classList.remove('hidden');
    dropdown.classList.add('dropdown-menu', 'show'); 
    arrow.classList.add('dropdown-arrow-rotate');
    document.getElementById('menu-button').setAttribute('aria-expanded', 'true');
  }

  closeDropdown() {
    const dropdown = document.getElementById('dropdown-menu');
    const arrow = document.getElementById('dropdown-arrow');
    
    dropdown.classList.remove('show'); 
    arrow.classList.remove('dropdown-arrow-rotate');
    document.getElementById('menu-button').setAttribute('aria-expanded', 'false');

    setTimeout(() => {
      dropdown.classList.add('hidden');
    }, 150); 
  }

  updateDropdownContent() {
    document.getElementById('current-year').textContent = this.viewDate.getFullYear();
    
    const monthGrid = document.getElementById('month-grid');
    const currentMonthInView = this.viewDate.getMonth();
    const currentYearInView = this.viewDate.getFullYear();
    const today = new Date();
    
    monthGrid.innerHTML = this.monthNames.map((month, index) => {
      const isActiveMonth = index === currentMonthInView;
      const isTodayMonth = index === today.getMonth() && currentYearInView === today.getFullYear();
      
      let buttonClass = 'px-2 py-1 text-xs rounded-md transition-colors ';
      if (isActiveMonth) {
        buttonClass += 'bg-gray-900 text-white';
      } else if (isTodayMonth) {
        buttonClass += 'bg-blue-50 text-blue-600 hover:bg-blue-100';
      } else {
        buttonClass += 'text-gray-700 hover:bg-gray-100';
      }
      
      return `
        <button type="button" 
                class="${buttonClass}" 
                data-month="${index}"
                title="${month} ${currentYearInView}">
          ${month.substring(0, 3)}
        </button>
      `;
    }).join('');
    
    monthGrid.querySelectorAll('button').forEach(button => {
      button.addEventListener('click', (e) => {
        const monthIndex = parseInt(e.target.dataset.month);
        this.viewDate.setMonth(monthIndex); 
        this.loadEventsAndRender(); 
        this.updateDropdownContent(); 
        this.closeDropdown(); 
      });
    });
  }

showTaskDetails(task) {
  const modal = document.getElementById('taskModal');
  const modalContent = document.getElementById('modal-content');
  
  modalContent.innerHTML = `
    <div class="space-y-4">
      <div>
        <h4 class="font-medium text-gray-900">${task.title}</h4>
        <p class="text-sm text-gray-600">${task.branch}</p>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <span class="text-sm font-medium text-gray-700">Time:</span>
          <p class="text-sm text-gray-900">${task.time}</p>
        </div>
        <div>
          <span class="text-sm font-medium text-gray-700">Status:</span>
          <p class="text-sm ${this.getStatusColor(task.status)} capitalize font-medium">
            <span class="inline-block px-2 py-1 text-xs rounded-full ${this.getStatusBadgeClass(task.status)}">
              ${task.status}
            </span>
          </p>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <span class="text-sm font-medium text-gray-700">Place:</span>
          <p class="text-sm text-gray-900">${task.place}</p>
        </div>
        <div>
          <span class="text-sm font-medium text-gray-700">Place Information:</span>
          <p class="text-sm text-gray-900">${task.description}</p>
        </div>
      </div>
      <div>
        <span class="text-sm font-medium text-gray-700">Implementor:</span>
        <p class="text-sm text-gray-900">
          <span class="${this.getImplementorBadgeClass(task.implementor)}">${task.implementor}</span>
        </p>
      </div>
    </div>
  `;
  
  modal.classList.remove('hidden');
}

  formatMonthYear(date) {
    return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
  }

  formatDateKey(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

  isToday(date) {
    const today = new Date();
    return date.toDateString() === today.toDateString();
  }

  isCurrentMonth(date) {
    return date.getMonth() === this.viewDate.getMonth() &&
           date.getFullYear() === this.viewDate.getFullYear();
  }

  generateCalendarDays() {
    const year = this.viewDate.getFullYear();
    const month = this.viewDate.getMonth();

    const firstDay = new Date(year, month, 1);
    const startDay = new Date(firstDay);
    startDay.setDate(firstDay.getDate() - firstDay.getDay());

    const days = [];
    for (let i = 0; i < 42; i++) {
      days.push(new Date(startDay));
      startDay.setDate(startDay.getDate() + 1);
    }
    return days;
  }

  getStatusColor(status) {
  switch (status) {
    case 'completed':
      return 'text-green-600';
    case 'scheduled':
      return 'text-blue-600';
    case 'pending':
      return 'text-yellow-600';
    case 'cancelled':
      return 'text-red-600';
    default:
      return 'text-gray-900';
  }
}

getStatusBadgeClass(status) {
  switch (status) {
    case 'completed':
      return 'bg-green-100 text-green-800 border-green-200 text-xs font-medium px-2.5 py-0.5 rounded-sm';
    case 'scheduled':
      return 'bg-blue-100 text-blue-800 border-blue-200 text-xs font-medium px-2.5 py-0.5 rounded-sm';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800 border-yellow-200 text-xs font-medium px-2.5 py-0.5 rounded-sm';
    case 'cancelled':
      return 'bg-red-100 text-red-800 border-red-200 text-xs font-medium px-2.5 py-0.5 rounded-sm';
    default:
      return 'bg-gray-100 text-gray-800 border-gray-200 text-xs font-medium px-2.5 py-0.5 rounded-sm';
  }
}

  getImplementorColor(implementor) {
    const normalizedName = implementor.toLowerCase();
    switch (normalizedName) {
      case 'adit':
        return {
          bg: 'bg-yellow-100',
          text: 'text-yellow-800',
          border: 'border-yellow-200',
          hover: 'hover:bg-yellow-200'
        };
      case 'pipin':
        return {
          bg: 'bg-purple-100',
          text: 'text-purple-800',
          border: 'border-purple-200',
          hover: 'hover:bg-purple-200'
        };
      default:
        return {
          bg: 'bg-gray-100',
          text: 'text-gray-800',
          border: 'border-gray-200',
          hover: 'hover:bg-gray-200'
        };
    }
  }

  getImplementorBadgeClass(implementor) {
    const colors = this.getImplementorColor(implementor);
    return `${colors.bg} ${colors.text} text-xs font-medium px-2.5 py-0.5 rounded-sm`;
  }

renderDay(date) {
  const isCurrentMonth = this.isCurrentMonth(date);
  const isToday = this.isToday(date);
  const dateKey = this.formatDateKey(date);
  const dayEvents = this.events[dateKey] || [];

  const bgClass = isCurrentMonth ? 'bg-white' : 'bg-gray-50 text-gray-400';
  const dateClass = isToday
    ? 'flex h-6 w-6 items-center justify-center rounded-full bg-gray-900 font-semibold text-white'
    : '';

  const minHeight = Math.max(96, 32 + (dayEvents.length * 20)); 
  
  let eventsHtml = '';
  if (dayEvents.length > 0) {
    const visibleEvents = dayEvents.slice(0, 3);
    const hiddenCount = dayEvents.length - 3;
    
    eventsHtml = `
      <ol class="mt-1 space-y-0.5">
        ${visibleEvents.map(event => {
          const colors = this.getImplementorColor(event.implementor);
          const statusBadge = this.getStatusBadgeClass(event.status);
          return `
            <li>
              <button type="button" class="group flex w-full text-left task-event rounded px-1 py-0.5 ${colors.bg} ${colors.border} border ${colors.hover} relative" data-task='${JSON.stringify(event)}'>
                <div class="flex-1 min-w-0">
                  <p class="flex-auto truncate text-xs font-medium ${colors.text} group-hover:opacity-80">${event.title}</p>
                  <div class="flex items-center gap-1 mt-0.5">
                    <span class="inline-block w-2 h-2 rounded-full ${event.status === 'completed' ? 'bg-green-500' : event.status === 'scheduled' ? 'bg-blue-500' : event.status === 'pending' ? 'bg-yellow-500' : 'bg-gray-500'}"></span>
                    <time datetime="${event.datetime}" class="text-xs ${colors.text} opacity-75">${event.time}</time>
                  </div>
                </div>
              </button>
            </li>
          `;
        }).join('')}
        ${hiddenCount > 0 ? `
          <li>
            <button type="button" class="w-full text-left text-xs text-gray-500 hover:text-gray-700 px-1 py-0.5 more-events" data-date="${dateKey}">
              +${hiddenCount} more
            </button>
          </li>
        ` : ''}
      </ol>
    `;
  }

  return `
    <div class="relative ${bgClass} px-2 py-2 flex flex-col border-b border-gray-100" style="min-height: ${minHeight}px;">
      <time datetime="${dateKey}" class="${dateClass} mb-1">${date.getDate()}</time>
      <div class="flex-1">
        ${eventsHtml}
      </div>
    </div>
  `;
}

showMoreEvents(dateKey) {
  const dayEvents = this.events[dateKey] || [];
  const modal = document.getElementById('taskModal');
  const modalContent = document.getElementById('modal-content');
  
  modalContent.innerHTML = `
    <div class="space-y-3">
      <h4 class="font-medium text-gray-900">Events for ${dateKey}</h4>
      <div class="space-y-2 max-h-96 overflow-y-auto">
        ${dayEvents.map(event => {
          const colors = this.getImplementorColor(event.implementor);
          const statusBadge = this.getStatusBadgeClass(event.status);
          return `
            <div class="border rounded-lg p-3 ${colors.hover} cursor-pointer task-event ${colors.bg} ${colors.border}" data-task='${JSON.stringify(event)}'>
              <div class="flex justify-between items-start">
                <h5 class="font-medium ${colors.text}">${event.title}</h5>
                <span class="text-xs ${colors.text} opacity-75">${event.time}</span>
              </div>
              <p class="text-sm text-gray-600 mt-1">${event.description || 'No description'}</p>
              <div class="flex gap-4 mt-2 text-xs">
                <span class="text-gray-500">📍 ${event.place}</span>
                <span class="inline-block px-2 py-1 rounded-full ${statusBadge}">
                  ${event.status}
                </span>
                <span class="${this.getImplementorBadgeClass(event.implementor)}">👤 ${event.implementor}</span>
              </div>
            </div>
          `;
        }).join('')}
      </div>
    </div>
  `;
  
  modal.classList.remove('hidden');
}

  render() {
    this.updateHeaderDate(); 
    
    const days = this.generateCalendarDays();
    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = days.map(day => this.renderDay(day)).join('');

    document.querySelectorAll('.task-event').forEach(button => {
      button.addEventListener('click', (e) => {
        const task = JSON.parse(e.currentTarget.dataset.task);
        this.showTaskDetails(task);
      });
    });

    document.querySelectorAll('.more-events').forEach(button => {
      button.addEventListener('click', (e) => {
        const dateKey = e.currentTarget.dataset.date;
        this.showMoreEvents(dateKey);
      });
    });

    const loading = document.getElementById('loading');
    if (loading) {
      loading.remove();
    }
  }

  updateHeaderDate() {
    const headerDate = document.getElementById('headerDate');
    headerDate.textContent = this.viewDate.toLocaleDateString('en-US', { 
      month: 'long', 
      year: 'numeric' 
    });
    headerDate.setAttribute('datetime', this.viewDate.toISOString().slice(0, 7));
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new RealTimeCalendar();
});

let notifiedTasks = new Set(); 

document.addEventListener('DOMContentLoaded', function() {
    checkOverdueTasks();
    setInterval(checkOverdueTasks, 300000); 
});

function checkOverdueTasks() {
    fetch('/overdue-tasks')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const newOverdueTasks = data.filter(task => !notifiedTasks.has(task.id));
                if (newOverdueTasks.length > 0) {
                    showOverduePopup(newOverdueTasks);
                    newOverdueTasks.forEach(task => notifiedTasks.add(task.id));
                }
            }
        })
        .catch(error => console.error('Error checking overdue tasks:', error));
}

function showOverduePopup(overdueTasks) {
    let taskList = '';
    let criticalCount = 0;
    let regularCount = 0;
    
    overdueTasks.forEach(task => {
        const urgencyClass = task.overdue_days > 1 ? 'text-red-800' : 'text-red-800';
        const urgencyIcon = task.overdue_days > 1 ? '🚨' : '⚠️';
        
        if (task.overdue_days > 1) criticalCount++;
        else regularCount++;
        
        taskList += `
            <div class="border-l-4 ${task.overdue_days > 1 ? 'border-red-800' : 'border-red-800'} bg-gray-50 p-2 mb-3 rounded-md">
                <div class="flex items-start">
                    <span class="mr-2 text-sm">${urgencyIcon}</span>
                    <div class="flex-1 text-xs">
                        <p class="font-semibold text-sm text-gray-900">${task.company_name}</p>
                        <p class="text-gray-600">${task.description}</p>
                        <div class="mt-1 text-gray-500">
                            <span>${task.datetime}</span>
                            <span>${task.place}</span> 
                            <span>${task.implementor}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    const title = criticalCount > 0 ? 
        `${criticalCount} Task Kritis Overdue!` : 
        `${regularCount} Task Overdue`;
    
    const description = "Task-task berikut sudah melewati jadwal";
    
    const popupHTML = `
        <div id="overduePopup" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="max-w-md w-full">
                    <div class="p-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800">
                        <div class="flex items-center mb-2">
                            <svg class="shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <h3 class="text-base font-semibold">${title}</h3>
                        </div>
                        <div class="mb-3 text-xs">${description}</div>
                        <div class="max-h-64 overflow-y-auto mb-4 text-xs">
                            ${taskList}
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" onclick="viewAllTasks()" class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-4 py-2 inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <svg class="mr-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                    <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                                </svg>
                                Lihat Semua Task
                            </button>
                            <button type="button" onclick="closeOverduePopup()" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-4 py-2 dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', popupHTML);
    
    markOverdueNotified(overdueTasks.map(task => task.id));
}

function closeOverduePopup() {
    const popup = document.getElementById('overduePopup');
    if (popup) {
        popup.remove();
    }
}

function viewAllTasks() {
    closeOverduePopup();
    window.location.href = '/tasks?filter=overdue'; 
}

function markOverdueNotified(taskIds) {
    fetch('/mark-overdue-notified', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ task_ids: taskIds })
    })
    .catch(error => console.error('Error marking overdue notified:', error));
}

setInterval(() => {
    notifiedTasks.clear();
}, 24 * 60 * 60 * 1000); 
</script>

</body>
</html>