<div class="grid-stats grid-stats-5" style="margin-bottom: 20px;">
    @foreach($stats as $stat)
        <div class="stat">
            <div class="stat-accent"></div>
            <div class="stat-body">
                <p class="stat-label">{{ $stat['label'] }}</p>
                <p class="stat-value">{{ number_format($stat['value']) }}</p>
                <p class="stat-sub">{{ $stat['sub'] }}</p>
            </div>
        </div>
    @endforeach
</div>
