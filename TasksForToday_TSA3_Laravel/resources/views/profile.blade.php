@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<p class="eyebrow">PERSONAL DETAILS</p>
<h1>Profile</h1>
@if ($user)
    <section class="profile-panel" aria-labelledby="profile-name">
        <h2 id="profile-name">{{ $user->full_name }}</h2>
        <dl><dt>Username</dt><dd>{{ $user->username }}</dd><dt>Full name</dt><dd>{{ $user->full_name }}</dd><dt>Email</dt><dd>{{ $user->email }}</dd></dl>
    </section>
@else
    <p class="empty-state">No profile record is available.</p>
@endif
@endsection
