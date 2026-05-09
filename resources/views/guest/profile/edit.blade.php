@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-1">Edit Profile</h2>
        <p class="text-muted mb-0">Update your personal information and profile photo.</p>
    </div>

    <a href="{{ route('guest.dashboard') }}" class="btn btn-outline-dark rounded-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

<div class="row g-4">

    <div class="col-lg-4">
        <div class="profile-preview-card">
            <div class="profile-photo-wrap">
                @if($guest->profile_photo)
                    <img src="{{ asset('storage/' . $guest->profile_photo) }}" class="profile-photo" alt="Profile Photo">
                @else
                    <div class="profile-initial">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <h4>{{ auth()->user()->name }}</h4>
            <p>{{ auth()->user()->email }}</p>

            <div class="profile-info-item">
                <i class="bi bi-telephone"></i>
                <span>{{ $guest->phone_number ?? 'No phone number added' }}</span>
            </div>

            <div class="profile-info-item">
                <i class="bi bi-geo-alt"></i>
                <span>{{ $guest->address ?? 'No address added' }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="edit-card">
            <form method="POST" action="{{ route('guest.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text"
                           name="name"
                           class="form-control rounded-3"
                           value="{{ old('name', auth()->user()->name) }}"
                           required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email"
                           class="form-control rounded-3"
                           value="{{ auth()->user()->email }}"
                           readonly>
                    <small class="text-muted">Email is used for login and cannot be edited here.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Phone Number</label>
                    <input type="text"
                           name="phone_number"
                           class="form-control rounded-3"
                           value="{{ old('phone_number', $guest->phone_number) }}"
                           placeholder="Enter phone number">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Address</label>
                    <textarea name="address"
                              class="form-control rounded-3"
                              rows="4"
                              placeholder="Enter address">{{ old('address', $guest->address) }}</textarea>
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <input type="file"
                           name="profile_photo"
                           class="form-control rounded-3"
                           accept="image/png,image/jpeg,image/jpg">
                    <small class="text-muted">Accepted: JPG, JPEG, PNG. Max size: 2MB.</small>
                    @error('profile_photo')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark rounded-3 px-4">
                    <i class="bi bi-save me-1"></i> Save Changes
                </button>

                <a href="{{ route('guest.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">
                    Cancel
                </a>
            </form>
        </div>
    </div>

</div>

<style>
.profile-preview-card,
.edit-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
}

.profile-preview-card {
    text-align: center;
}

.profile-photo-wrap {
    width: 120px;
    height: 120px;
    margin: 0 auto 18px;
}

.profile-photo,
.profile-initial {
    width: 120px;
    height: 120px;
    border-radius: 50%;
}

.profile-photo {
    object-fit: cover;
    border: 4px solid #facc15;
}

.profile-initial {
    background: linear-gradient(135deg, #0f172a, #1e40af);
    color: #facc15;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    font-weight: 900;
}

.profile-preview-card h4 {
    font-weight: 900;
    margin-bottom: 4px;
}

.profile-preview-card p {
    color: #64748b;
    margin-bottom: 20px;
}

.profile-info-item {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: left;
    margin-bottom: 10px;
}

.profile-info-item i {
    color: #1e40af;
}
</style>

@endsection