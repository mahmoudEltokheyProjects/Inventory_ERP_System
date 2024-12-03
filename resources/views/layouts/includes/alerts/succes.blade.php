{{-- if "success message" come from "Session" --}}
@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{-- get value of 'success' key from session --}}
        {{ Session::get('success') }}
    </div>
@endif
