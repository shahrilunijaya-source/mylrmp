{{--
    Custom login form — uses wire models to talk to Filament's authenticate()
    while rendering identical HTML to the industri login (no Filament form components).
--}}

@if ($errors->any())
    <div class="error-box">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form wire:submit.prevent="authenticate" novalidate>
    @csrf

    <div class="field">
        <label for="adm-email">Emel</label>
        <div class="field-wrap">
            <input
                type="email"
                id="adm-email"
                wire:model="data.email"
                placeholder="nama@jabatan.gov.my"
                autocomplete="email"
                autofocus
            >
            <svg class="field-icon" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
            </svg>
        </div>
    </div>

    <div class="field">
        <label for="adm-password">Kata Laluan</label>
        <div class="field-wrap">
            <input
                type="password"
                id="adm-password"
                wire:model="data.password"
                placeholder="••••••••"
                autocomplete="current-password"
            >
            <svg class="field-icon" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>

    <div class="remember-row">
        <label class="remember-label">
            <input type="checkbox" wire:model="data.remember">
            Ingat saya
        </label>
        @if (filament()->hasPasswordReset())
            <a href="{{ filament()->getRequestPasswordResetUrl() }}" class="forgot-link">Lupa Kata Laluan?</a>
        @endif
    </div>

    <button type="submit" class="submit-btn" wire:loading.attr="disabled" wire:loading.class="opacity-75">
        <span wire:loading.remove wire:target="authenticate">Log Masuk</span>
        <span wire:loading wire:target="authenticate">Memproses…</span>
    </button>

</form>
