@extends('layouts.admin')
@section('page_title', 'Homepage Layout')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Homepage Orchestration</h1>
        <p class="page-subtitle">Choose what appears in each slot. Empty slots show the latest published articles.</p>
    </div>
</div>

@include('admin.layout._form', [
    'action' => route('admin.layout.homepage.update'),
    'title' => 'Homepage slots',
])

@endsection
