@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Profil Saya – Tiket Bioskop')
@section('header', 'Profil Saya')

@section('content')
<div class="profile-edit-container {{ auth()->user()->role === 'admin' ? 'py-4' : 'py-12 bg-[#FAF3E0] min-h-screen' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="mb-4">
            <h1 class="text-3xl font-black text-[#4B3935] {{ auth()->user()->role === 'admin' ? '' : 'font-baloo' }}">Pengaturan Profil</h1>
            <p class="text-sm text-slate-500">Kelola informasi akun, kata sandi, dan keamanan Anda di sini.</p>
        </div>

        <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl border border-[#C8C2BC]/40">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl border border-[#C8C2BC]/40">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl border border-[#C8C2BC]/40">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
    /* Scope overrides to the profile-edit-container to prevent pollution of navbar/global styles */
    
    /* 1. Form headings & texts */
    .profile-edit-container h2 {
        @if(auth()->user()->role !== 'admin')
        font-family: 'Baloo 2', cursive !important;
        @endif
        font-weight: 800 !important;
        font-size: 1.5rem !important;
        color: #4B3935 !important;
    }
    
    .profile-edit-container p {
        color: #708090 !important;
    }

    /* 2. Style input labels */
    .profile-edit-container label {
        color: #4B3935 !important;
        font-weight: 700 !important;
        font-size: 0.85rem !important;
    }

    /* 3. Style text inputs */
    .profile-edit-container input[type="text"],
    .profile-edit-container input[type="email"],
    .profile-edit-container input[type="password"] {
        background-color: rgba(250, 243, 224, 0.1) !important;
        border: 1px solid rgba(75, 57, 53, 0.2) !important;
        border-radius: 0.75rem !important;
        padding: 0.625rem 1rem !important;
        color: #4B3935 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s !important;
    }
    
    .profile-edit-container input[type="text"]:focus,
    .profile-edit-container input[type="email"]:focus,
    .profile-edit-container input[type="password"]:focus {
        border-color: #4B3935 !important;
        box-shadow: 0 0 0 2px rgba(75, 57, 53, 0.15) !important;
        background-color: #ffffff !important;
        outline: none !important;
    }

    /* 4. Style primary save buttons */
    .profile-edit-container button[type="submit"].bg-gray-800,
    .profile-edit-container button.bg-gray-800,
    .profile-edit-container .inline-flex.items-center.bg-gray-800 {
        background: linear-gradient(135deg, #4B3935 0%, #2c1e1a 100%) !important;
        color: #FAF3E0 !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        padding: 0.65rem 1.5rem !important;
        border-radius: 0.75rem !important;
        border: none !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        box-shadow: 0 4px 6px -1px rgba(75, 57, 53, 0.1), 0 2px 4px -1px rgba(75, 57, 53, 0.06) !important;
        transition: all 0.2s !important;
    }

    .profile-edit-container button[type="submit"].bg-gray-800:hover,
    .profile-edit-container button.bg-gray-800:hover {
        opacity: 0.9 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 10px 15px -3px rgba(75, 57, 53, 0.2), 0 4px 6px -2px rgba(75, 57, 53, 0.05) !important;
    }

    /* 5. Style secondary cancel buttons */
    .profile-edit-container button.bg-white.text-gray-700,
    .profile-edit-container .bg-white.text-gray-700 {
        background-color: #ffffff !important;
        border: 1px solid rgba(75, 57, 53, 0.2) !important;
        color: #4B3935 !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        padding: 0.65rem 1.5rem !important;
        transition: all 0.2s !important;
    }
    
    .profile-edit-container button.bg-white.text-gray-700:hover {
        background-color: rgba(250, 243, 224, 0.1) !important;
    }

    /* 6. Style danger buttons */
    .profile-edit-container button.bg-red-600,
    .profile-edit-container .bg-red-600 {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        padding: 0.65rem 1.5rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        transition: all 0.2s !important;
    }
    
    .profile-edit-container button.bg-red-600:hover {
        background-color: #b91c1c !important;
        transform: translateY(-1px) !important;
    }
</style>
@endsection
