@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="w-2/4 mx-auto my-10">
            <x-errors />
            <form method="POST" action="{{ route('password.update') }}">
                <x-card title="Reset Password" card-classes="border mt-3" shadow="shadow-sm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <x-input label="Email Address"
                                 type="email"
                                 name="email"
                                 value="{{ $email ?? old('email') }}"
                                 required
                                 autocomplete="email" autofocus
                        />
                        @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-input label="Password"
                                 type="password"
                                 name="password"
                                 required
                                 autocomplete="new-password"
                        />
                        @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-input label="Confirm Password"
                                 type="password"
                                 name="password_confirmation"
                                 required
                                 autocomplete="new-password"
                        />
                    </div>

                    <x-slot:footer>
                        <x-button label="Reset Password" type="submit" color="primary" />
                    </x-slot:footer>

                </x-card>
            </form>
        </div>
    </div>
@endsection
