<div class="card">
    <div class="card-head">
        <h2 class="card-title">{{ $title }}</h2>
    </div>
    <form method="POST" action="{{ $action }}">
        @csrf
        @method('PUT')
        <div class="card-body" style="display: grid; gap: 24px;">
            @foreach($definitions as $sectionKey => $definition)
                @php
                    $count = (int) ($definition['count'] ?? 1);
                    $sectionSlots = $slots->get($sectionKey, collect());
                @endphp
                <div class="card" style="box-shadow: none;">
                    <div class="card-head">
                        <h3 class="card-title">{{ $definition['label'] }}</h3>
                    </div>
                    <div class="card-body" style="display: grid; gap: 12px;">
                        @if(!empty($definition['description']))
                            <p style="margin:0;font-size:13px;color:var(--text-muted);">{{ $definition['description'] }}</p>
                        @endif

                        @for($position = 0; $position < $count; $position++)
                            @php
                                $selectedId = old("slots.{$sectionKey}.{$position}", $sectionSlots->firstWhere('position', $position)?->post_id);
                            @endphp
                            <div>
                                <label class="field-label">Slot {{ $position + 1 }}</label>
                                <select name="slots[{{ $sectionKey }}][{{ $position }}]" class="select">
                                    <option value="">— Auto (latest) —</option>
                                    @foreach($publishedPosts as $post)
                                        <option value="{{ $post->id }}" {{ (string) $selectedId === (string) $post->id ? 'selected' : '' }}>
                                            {{ $post->title }}
                                            @if($post->categories->isNotEmpty())
                                                ({{ $post->categories->pluck('name')->join(', ') }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Save Layout</button>
        </div>
    </form>
</div>

<div class="card" style="margin-top: 16px;">
    <div class="card-body">
        <p style="margin:0;font-size:14px;color:var(--text-muted);">
            <strong>Auto (latest)</strong> fills from the newest published articles not already used elsewhere on the page.
            Hub pages match articles by category slug (e.g. <code>politics</code>).
        </p>
    </div>
</div>
