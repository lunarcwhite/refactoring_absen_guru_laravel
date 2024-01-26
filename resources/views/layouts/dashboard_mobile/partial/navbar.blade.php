<div class="android-detection ios-detection">
    <div class="appBottomMenu">
        <a href="{{ route('dashboard.index') }}" class="item">
            <div class="col">
                <ion-icon name="home-outline" class="md hydrated"></ion-icon>
                <strong>Dashboard</strong>
            </div>
        </a>
        <a href="{{ route('dashboard.histori.index') }}" class="item">
            <div class="col">
                <ion-icon name="calendar-outline" role="img" class="md hydrated" aria-label="calendar outline">
                </ion-icon>
                <strong>Riwayat</strong>
            </div>
        </a>
        <a href="{{ route('dashboard.absen.index') }}" class="item">
            <div class="col">
                <div class="action-button large bg-dark">
                    <ion-icon name="camera-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="{{ route('dashboard.izin.index') }}" class="item">
            <div class="col">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Izin</strong>
            </div>
        </a>
        <a href="{{ route('dashboard.setting.index') }}" class="item">
            <div class="col">
                <ion-icon name="settings-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                <strong>Setting</strong>
            </div>
        </a>
    </div>
</div>
