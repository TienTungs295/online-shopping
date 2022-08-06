@extends('backend.layouts.master-no-sidebar')
@section('content')
    <div class="font-sans antialiased mt-50">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border/>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border/>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border/>
            @endif

            {{--            <div class="mt-10 sm:mt-0">--}}
            {{--                @livewire('profile.logout-other-browser-sessions-form')--}}
            {{--            </div>--}}

            {{--            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())--}}
            {{--                <x-jet-section-border />--}}

            {{--                <div class="mt-10 sm:mt-0">--}}
            {{--                    @livewire('profile.delete-user-form')--}}
            {{--                </div>--}}
            {{--            @endif--}}
                <div class="text-center">
                    <a class="btn btn-danger" href="{!! route('homeView') !!}">
                        <i class="bi bi-arrow-return-left me-1"></i>
                        Quay lại
                    </a>
                </div>
        </div>
    </div>
@endsection
