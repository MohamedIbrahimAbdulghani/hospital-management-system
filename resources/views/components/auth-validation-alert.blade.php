@php
    $authError = \App\Helpers\AuthErrorHelper::getAuthFailure($errors);
@endphp

@if ($authError)
    <div class="alert alert-danger py-2 px-3 mb-3 tx-13 rounded d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-circle mr-2 ml-2 text-danger"></i>
        <span>{{ $authError }}</span>
    </div>
@endif
