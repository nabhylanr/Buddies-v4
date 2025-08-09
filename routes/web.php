<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Recap;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', function () {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect('/dashboard');
        } elseif ($user->isUser()) {
            return redirect('/calendar');
        } elseif ($user->isImplementor()) {
            return redirect('/dashboard');
        }
        return redirect('/dashboard');
    });

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/overdue-tasks', function () {
        $user = Auth::user();
        if (!$user->canAccessTasks()) {
            return response()->json(['error' => 'You do not have permission to access this page.'], 403);
        }
        $controller = app(TaskController::class);
        return $controller->getOverdueTasks();
    })->name('tasks.overdue');

    Route::post('/mark-overdue-notified', function () {
        $user = Auth::user();
        if (!$user->canAccessTasks()) {
            return response()->json(['error' => 'You do not have permission to access this page.'], 403);
        }
        $controller = app(TaskController::class);
        return $controller->markOverdueNotified(request());
    })->name('tasks.mark-overdue-notified');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'getEvents'])->name('calendar.events');

    Route::get('/dashboard', function () {
        $user = Auth::user();
        if (!$user->canAccessDashboard()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(TaskController::class);
        return $controller->dashboard();
    })->name('dashboard');

    Route::get('/tasks', function (Request $request) {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isImplementor()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        return app(TaskController::class)->index($request);
    })->name('tasks.index');

    Route::get('/tasks/create', function () {
        $controller = app(TaskController::class);
        return $controller->create();
    })->name('tasks.create');

    Route::get('/tasks/history', function () {
        $controller = app(TaskController::class);
        return $controller->history(request());
    })->name('tasks.history');

    Route::post('/tasks', function () {
        $controller = app(TaskController::class);
        return $controller->store(request());
    })->name('tasks.store');

    Route::patch('/tasks/{task}/complete', function (Task $task) {
        $controller = app(TaskController::class);
        return $controller->complete($task);
    })->name('tasks.complete');

    Route::patch('/tasks/{task}/uncomplete', function (Task $task) {
        $controller = app(TaskController::class);
        return $controller->uncomplete($task);
    })->name('tasks.uncomplete');

    Route::get('/api/tasks/available-time-slots', function () {
        $controller = app(TaskController::class);
        return $controller->getAvailableTimeSlots();
    });

    Route::get('/tasks/{task}', function (Task $task) {
        $controller = app(TaskController::class);
        return $controller->show($task);
    })->name('tasks.show');

    Route::get('/tasks/{task}/edit', function (Task $task) {
        $controller = app(TaskController::class);
        return $controller->edit($task);
    })->name('tasks.edit');

    Route::put('/tasks/{task}', function (Task $task) {
        $controller = app(TaskController::class);
        return $controller->update(request(), $task);
    })->name('tasks.update');

    Route::delete('/tasks/{task}', function (Task $task) {
        $controller = app(TaskController::class);
        return $controller->destroy($task);
    })->name('tasks.destroy');

    // User-specific task routes (for User role)
    Route::get('/user/tasks', function (Request $request) {
        $user = Auth::user();
        if (!$user->isUser()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(TaskController::class);
        return $controller->userTasks($request); 
    })->name('user.tasks');

    Route::get('/user/create', function () {
        $user = Auth::user();
        if (!$user->isUser()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(TaskController::class);
        return $controller->create();
    })->name('user.task.create');

    Route::post('/user/create', function () {
        $user = Auth::user();
        if (!$user->isUser()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(TaskController::class);
        return $controller->store(request());
    })->name('user.task.store');

    Route::get('/api/user/available-time-slots', function () {
        $user = Auth::user();
        if (!$user->isUser()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $controller = app(TaskController::class);
        return $controller->getAvailableTimeSlots();
    });

    Route::get('/recaps/user', function (Request $request) {
        $user = Auth::user();
        if (!$user->isUser()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        return app(RecapController::class)->view($request); 
    })->name('user.recaps.user');

    Route::get('/user/recaps/{recap}', function (Recap $recap) {
        $user = Auth::user();
        if (!$user->isUser()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->show($recap);
    })->name('user.recaps.show');

    Route::get('/recaps', function (Request $request) {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        return app(RecapController::class)->index($request);
    })->name('recaps.index');

    Route::get('/recaps/create', function () {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->create();
    })->name('recaps.create');

    Route::post('/recaps', function () {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->store(request());
    })->name('recaps.store');

    Route::get('/recaps/{recap}', function (Recap $recap) {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->show($recap);
    })->name('recaps.show');

    Route::get('/recaps/{recap}/edit', function (Recap $recap) {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->edit($recap);
    })->name('recaps.edit');

    Route::put('/recaps/{recap}', function (Recap $recap) {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->update(request(), $recap);
    })->name('recaps.update');

    Route::delete('/recaps/{recap}', function (Recap $recap) {
        $user = Auth::user();
        if (!$user->canAccessRecaps()) {
            return redirect('/calendar')->with('error', 'You do not have permission to access this page.');
        }
        $controller = app(RecapController::class);
        return $controller->destroy($recap);
    })->name('recaps.destroy');
});

Route::get('/', function () {
    return redirect('/login');
})->name('home');