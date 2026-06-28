@extends('layouts.admin')
@section('page_title', ucwords(str_replace('-', ' ', $hubSlug)).' Hub Layout')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ ucwords(str_replace('-', ' ', $hubSlug)) }} Hub</h1>
        <p class="page-subtitle">Curate this section page. Unfilled slots fall back to latest articles in the matching category.</p>
    </div>
</div>

@include('admin.layout._form', [
    'action' => route('admin.layout.hub.update', $hubSlug),
    'title' => ucwords(str_replace('-', ' ', $hubSlug)).' slots',
])

@endsection
