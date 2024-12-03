{{-- ====== extend "parent page" ====== --}}
@extends('layouts.admin')
{{-- ====== contentHeader ====== --}}
@section('contentHeader')
    Test 1 Header
@endsection
{{-- ====== contentHeaderLink ====== --}}
@section("contentHeaderLink")
    <a href="#">Link 1</a>
@endsection
{{-- ====== contentHeaderActiveLink ====== --}}
@section("contentHeaderActiveLink")
    <a href="#">Link 2</a>
@endsection
{{-- ====== content ====== --}}
@section("content")
    Content 1 Content 1 Content 1 Content 1 Content 1
@endsection
