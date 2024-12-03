{{-- if "error message" come from "Session" --}}
@if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{-- get value of 'error' key from session --}}
        {{ Session::get('error') }}
    </div>
@endif
