@extends('photographer.layout')

@section('title', 'Profile Overview')

@section('styles')
<style>
    :root {
        --primary: #a67c52;
        --secondary: #c4a484;
        --bg: #faf7f8;
        --text: #232222;
        --muted: #64748b;
        --white: #fff;
        --border: #e5e7eb;
        --radius: 1rem;
        --shadow: 0 4px 10px rgba(0, 0, 0, .08);
    }

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 0 1.5rem
    }

    .page-header {
        background: var(--white);
        border-bottom: 1px solid var(--border);
        padding: 3rem 0 2rem;
        margin-bottom: 2.5rem;
    }

    .header-flex {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    h1,
    h2,
    h3 {
        font-family: Georgia, serif;
        color: var(--text)
    }

    .btn {
        padding: .7rem 1.4rem;
        border-radius: .8rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
    }

    .btn-primary {
        background: var(--primary);
        color: #fff
    }

    .btn-outline {
        border: 1px solid var(--border);
        color: var(--text)
    }

    .btn-outline:hover {
        background: #f3f4f6
    }

    .card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .two-col {
        display: grid;
        grid-template-columns: 1.4fr .9fr;
        gap: 2rem;
    }

    .profile-head {
        display: flex;
        gap: 1.5rem;
        border-bottom: 1px solid var(--border);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--secondary);
    }

    .label {
        font-weight: 700;
        width: 170px;
        color: var(--text);
    }

    .row {
        display: flex;
        gap: 1rem;
        padding: .8rem 0;
        border-bottom: 1px dashed var(--border);
    }

    .row:last-child {
        border-bottom: 0
    }

    .tags {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .tag {
        background: rgba(166, 124, 82, .12);
        color: var(--primary);
        border: 1px solid rgba(166, 124, 82, .3);
        padding: .25rem .7rem;
        border-radius: 999px;
        font-size: .85rem;
    }

    .social a {
        display: inline-flex;
        width: 38px;
        height: 38px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f3f4f6;
        color: var(--text);
        margin-right: .4rem;
    }

    .social a:hover {
        background: var(--primary);
        color: #fff
    }

    @media(max-width:900px) {
        .two-col {
            grid-template-columns: 1fr
        }
    }
</style>
@endsection

@section('content')

{{-- Header --}}
<header class="page-header">
    <div class="container header-flex">
        <div>
            <h1>Profile Overview</h1>
            <p style="color:var(--muted)">View and manage your photographer profile</p>
        </div>

        <div style="display:flex;gap:.7rem">
            <a href="{{ route('photographer.profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
        </div>
    </div>
</header>

<main class="container">

    @if(session('success'))
    <div class="card" style="border-color:#4ade80;background:#ecfdf5;color:#166534">
        {{ session('success') }}
    </div>
    @endif

    <div class="two-col">

        {{-- LEFT --}}
        <div>

            <div class="card">

                <div class="profile-head">
                    <img class="avatar"
                        src="{{ $profile->avatar
            ? asset('storage/'.$profile->avatar)
            : 'https://ui-avatars.com/api/?name='.urlencode($user->full_name).'&background=a67c52&color=fff' }}"
                        alt="Avatar">


                    <div>
                        <h2>{{ $user->name }}</h2>
                        <p style="color:var(--primary);font-weight:700">
                            Professional Photographer
                        </p>
                        <p style="color:var(--muted)">
                            Status: {{ ucfirst($profile->status ?? 'approved') }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="label">Email</div>
                    <div>{{ $user->email }}</div>
                </div>

                <div class="row">
                    <div class="label">Bio</div>
                    <div>{{ $profile->bio }}</div>
                </div>

                <div class="row">
                    <div class="label">City</div>
                    <div>{{ $profile->city }}</div>
                </div>

                <div class="row">
                    <div class="label">Experience</div>
                    <div>{{ $profile->years_of_experience }} years</div>
                </div>

                <div class="row">
                    <div class="label">Photography Types</div>
                    <div class="tags">
                        @foreach($profile->photography_types as $type)
                        <span class="tag">{{ $type }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="label">Starting Price</div>
                    <div style="font-weight:800;color:var(--primary)">
                        ${{ $profile->starting_price }}
                    </div>
                </div>
            </div>

            {{-- Social --}}
            <div class="card">
                <h3>Social Links</h3>

                <div class="social" style="margin-top:1rem">
                    @if($profile->instagram_url)
                    <a href="{{ $profile->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($profile->website_url)
                    <a href="{{ $profile->website_url }}" target="_blank"><i class="fas fa-globe"></i></a>
                    @endif
                    @if($profile->behance_url)
                    <a href="{{ $profile->behance_url }}" target="_blank"><i class="fab fa-behance"></i></a>
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div>

            <div class="card">
                <h3>Portfolio</h3>
                <p style="color:var(--muted)">
                    Show your best work to attract more clients
                </p>

                <a href="{{ route('photographer.portfolio.index') }}"

                    class="btn btn-outline" style="width:100%;margin-top:1rem">
                    <i class="fas fa-images"></i> Manage Portfolio
                </a>


            </div>

        </div>

    </div>

</main>
@endsection