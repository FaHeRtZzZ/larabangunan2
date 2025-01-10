@extends('layouts.app')

@section('content')
<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/profile_photos/' . ($user->photo ?? 'profile-img.jpg')) }}" alt="Profile Photo" class="rounded-circle">
                    <h2>{{ $user->username }}</h2>
                    <h3>{{ $user->role }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <h5 class="card-title">Profile Details</h5>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Username</div>
                        <div class="col-lg-9 col-md-8">{{ $user->username }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Country</div>
                        <div class="col-lg-9 col-md-8">{{ $user->country }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Address</div>
                        <div class="col-lg-9 col-md-8">{{ $user->address }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Phone</div>
                        <div class="col-lg-9 col-md-8">{{ $user->phone }}</div>
                    </div>
                    <a href="{{ route('profile.change-password') }}" class="btn btn-warning mt-3">Change Password</a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
