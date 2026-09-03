@extends('admin.layouts.app')

@section('title', 'مشتری جدید')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">مشتری جدید</h2>
        <form action="{{ route('admin.customers.store') }}" method="POST">
            @include('admin.customers._form')
        </form>
    </div>
@endsection
