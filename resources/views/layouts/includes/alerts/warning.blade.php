{{-- if "success message" come from "Session" --}}
@if (Session::has('update'))
    <div class="alert alert-warning text-white" role="alert">
        {{-- get value of 'success' key from session --}}
        {{ Session::get('update') }}
    </div>
@endif
