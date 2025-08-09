<div class="login-container">
    <div class="login-header">
        <img src="{{ asset('assets/login.png') }}" alt="Library Logo">
        <h2>Perpustakaan Login</h2>
    </div>
    @if ($errorMessage)
        <div class="alert alert-warning">
            {{ $errorMessage }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="proses">
        <div class="form-group">
            <input type="text" wire:model="email" class="form-control" id="email" placeholder="Email Address">
            @error('email')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" wire:model="password" class="form-control" id="password" placeholder="Password">
            @error('password')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-login">
            Login
            <span wire:loading wire:target="proses" class="spinner-border spinner-border-sm ml-2" role="status"
                aria-hidden="true"></span>
        </button>
    </form>

    <div class="text-center">
        <a href="#">Forgot password?</a>
        <span class="text-muted">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></span>
    </div>
</div>
