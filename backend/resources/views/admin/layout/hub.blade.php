@extends('layouts.admin')
@section('page_title', ucwords(str_replace('-', ' ', $hubSlug)).' Hub Layout')

@section('content')
<x-admin.page-header :title="ucwords(str_replace('-', ' ', $hubSlug)).' Hub'" subtitle="Curate this section page. Unfilled slots fall back to latest articles in the matching category." />

@include('admin.layout._form', [
    'action' => route('admin.layout.hub.update', $hubSlug),
    'title' => ucwords(str_replace('-', ' ', $hubSlug)).' slots',
])

@endsection
