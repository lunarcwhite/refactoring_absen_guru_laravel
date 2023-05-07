<div class="appBottomMenu">
    <a href="{{ route('dashboard.user') }}" class="item">
        <div class="col">
            <ion-icon name="home-outline" class="md hydrated"></ion-icon>
            <strong>Dashboard</strong>
        </div>
    </a>
    <a href="{{ route('dashboard.rekapan') }}" class="item">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated" aria-label="calendar outline">
            </ion-icon>
            <strong>Rekapan</strong>
        </div>
    </a>
    <a href="{{ route('dashboard.presensi.absen') }}" class="item">
        <div class="col">
            <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            <strong>Absen</strong>
            {{-- <div class="action-button large">
            </div> --}}
        </div>
    </a>
    <a href="{{ route('dashboard.presensi.izin') }}" class="item">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="{{ route('dashboard.profile') }}" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
