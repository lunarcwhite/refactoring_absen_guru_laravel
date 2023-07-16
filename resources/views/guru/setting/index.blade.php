@extends('layouts.dashboard_mobile.master')
@section('pageTitle')
    Setting
@stop
@section('content')
    <div class="section mt-2">
        <div class="card mb-3">
            <div class="card-body text-center">
                <img src="{{asset('assets_mobile/img/sample/avatar/avatar1.jpg')}}" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128"
                    height="128" />
                <h5 class="card-title mb-0">{{ auth()->user()->username }}</h5>
                <div class="text-muted mb-2">{{ auth()->user()->email }}</div>
            </div>
            {{-- <div class="card-body">
                <h5 class="h6 card-title">Skills</h5>
                <a href="#" class="badge badge-primary mr-1 my-1">HTML</a>
                <a href="#" class="badge badge-primary mr-1 my-1">JavaScript</a>
                <a href="#" class="badge badge-primary mr-1 my-1">Sass</a>
                <a href="#" class="badge badge-primary mr-1 my-1">Angular</a>
                <a href="#" class="badge badge-primary mr-1 my-1">Vue</a>
                <a href="#" class="badge badge-primary mr-1 my-1">React</a>
                <a href="#" class="badge badge-primary mr-1 my-1">Redux</a>
                <a href="#" class="badge badge-primary mr-1 my-1">UI</a>
                <a href="#" class="badge badge-primary mr-1 my-1">UX</a>
            </div> --}}
        </div>
    </div>

    <div class="section full mt-2">
        <div class="tab-content" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <div class="listview-title mt-2">Navigation</div>
            <ul class="listview image-listview flush transparent">
                <li>
                    <a href="component-appbottommenu.html" class="item">
                        <div class="icon-box bg-primary">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </div>
                        <div class="in">
                            Profile
                        </div>
                    </a>
                </li>
                <li>
                    <a href="component-appheader.html" class="item">
                        <div class="icon-box bg-primary">
                            <ion-icon name="key-outline"></ion-icon>
                        </div>
                        <div class="in">
                            Akun
                        </div>
                    </a>
                </li>
                <li>
                    <div class="item">
                        <div class="icon-box bg-primary">
                            <ion-icon name="moon-outline"></ion-icon>
                        </div>
                        <div class="in">
                            Dark Mode
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input dark-mode-switch" id="darkmodesidebar">
                                <label class="custom-control-label" for="darkmodesidebar"></label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
            <button type="button" onclick="formConfirmationId('#form-logout','Logout Dari Aplikasi?')"
                class="btn btn-outline-danger btn-block btn-lg">Logout</button>
            </div>
            </div>
            </div>
        </div>
        
    </div>    
@endsection
