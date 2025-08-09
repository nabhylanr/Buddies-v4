<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Sign In</title>
  <style>
    .glass-card {
      background: rgba(237, 238, 240, 0.4);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(237, 238, 240, 0.3);
      box-shadow: 0 8px 32px 0 rgba(9, 62, 120, 0.4);
    }
    
    .input-glass {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(237, 238, 240, 0.4);
      transition: all 0.3s ease;
    }
    
    .input-glass:focus {
      background: rgba(255, 255, 255, 1);
      border-color: rgba(9, 62, 120, 0.8);
      box-shadow: 0 0 20px rgba(9, 62, 120, 0.4);
    }
    
    .btn-primary {
      background: black;
      border: 1px solid rgba(237, 238, 240, 0.3);
      backdrop-filter: blur(10px);
      transition: all 0.4s ease;
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
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.6s ease;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, rgba(9, 62, 120, 0.9) 0%, #093e78 100%);
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(9, 62, 120, 0.5);
      border-color: rgba(237, 238, 240, 0.5);
    }
    
    .btn-primary:hover::before {
      left: 100%;
    }
    
    .btn-primary:active {
      transform: translateY(-1px);
      box-shadow: 0 8px 25px rgba(9, 62, 120, 0.4);
    }
    
    .floating-animation {
      animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    
    .fade-in {
      animation: fadeIn 1s ease-in;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .custom-bg {
      background-image: url('/images/bg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    
  </style>
</head>
<body class="custom-bg min-h-screen flex items-center justify-center p-4">  
  <div class="relative z-10 w-full max-w-md fade-in">    
    <div class="text-center mb-8 floating-animation">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full glass-card mb-4">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.5a8.25 8.25 0 0116.5 0"></path>
        </svg>
      </div>
      <h1 class="text-3xl font-bold text-white mb-2">Hi, Buddies!</h1>
    </div>

    <div class="glass-card rounded-3xl p-8">
      <form class="space-y-6" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="space-y-2">
          <label for="email" class="block text-sm font-medium text-white tracking-wide">
            Email
          </label>
          <div class="relative">
            <input 
              type="email" 
              name="email" 
              id="email" 
              value="{{ old('email') }}" 
              placeholder="admin@mandiri.com"
              autocomplete="email" 
              required
              class="input-glass block w-full rounded-xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-0 text-sm"
            />
          @error('email')
            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="space-y-2">
          <label for="password" class="block text-sm font-medium text-white tracking-wide">
            Password
          </label>
          <div class="relative">
            <input 
              type="password" 
              name="password" 
              id="password" 
              placeholder="••••••••••"
              autocomplete="current-password" 
              required
              class="input-glass block w-full rounded-xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-0 text-sm pr-10"
            />
          </div>
          @error('password')
            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
        <button 
          type="submit"
          class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-transparent">Sign in
        </button>
      </form>

      <div class="text-center mt-8">
        <p class="text-gray-200 text-sm">
          Don't have an account?
          <a href="{{ route('register') }}" class="font-semibold text-white hover:text-gray-100 transition-colors ml-1">
            Create Account
          </a>
        </p>
      </div>
    </div>
</body>
</html>