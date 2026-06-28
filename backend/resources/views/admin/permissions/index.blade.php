@extends('layouts.admin')
@section('page_title', 'Permissions Matrix')

@section('content')
<x-admin.page-header title="Permissions Matrix" subtitle="What each role can see and do in the editorial console" />

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Permission</th>
                @foreach($roles as $role)
                    <th>{{ $role->label() }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>
                        <strong>{{ $permission->label() }}</strong>
                        <br><span style="font-size:12px;color:var(--text-muted);">{{ $permission->value }}</span>
                    </td>
                    @foreach($roles as $role)
                        @php $allowed = in_array($permission->value, $matrix[$role->value] ?? [], true); @endphp
                        <td>
                            <span class="badge {{ $allowed ? 'badge-success' : 'badge-muted' }}">
                                {{ $allowed ? 'Yes' : '—' }}
                            </span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card" style="margin-top: 16px;">
    <div class="card-body">
        <p style="margin:0;font-size:14px;color:var(--text-muted);">
            Writers only see <strong>Dashboard</strong> and <strong>Articles</strong> in the sidebar.
            Staff, layout orchestration, review queue, and desk tools are editor-only.
            Empty layout slots on the public site fall back to the latest published articles.
        </p>
    </div>
</div>
@endsection
