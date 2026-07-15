{{--
    SupportOS ticket widget.

    Renders a floating "Support" button that lets MyLRMP users submit a ticket
    straight into SupportOS, and (optionally) auto-captures uncaught JS errors.

    Configured via config/services.php -> supportos (SUPPORTOS_* env vars).
    Renders nothing unless both SUPPORTOS_ENABLED=true and a project token are set.
--}}
@php
    $supportos = config('services.supportos');
    $supportosUrl = rtrim($supportos['url'] ?? '', '/');
@endphp

@if (filter_var($supportos['enabled'] ?? false, FILTER_VALIDATE_BOOLEAN) && filled($supportos['token']) && filled($supportosUrl))
    <script src="{{ $supportosUrl }}/widget/v1/supportos.js"
            data-token="{{ $supportos['token'] }}"
            data-ingest="{{ $supportosUrl }}/ingest/v1/tickets"
            data-auto-capture="{{ filter_var($supportos['auto_capture'] ?? true, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }}" defer></script>
@endif
