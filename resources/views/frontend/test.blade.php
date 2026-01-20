@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="my-20 w-2/5 mx-auto">
            <form method="post" action="{{ url('test') }}" enctype="multipart/form-data">
                @csrf
                <x-card title="Import Excel">
                    <x-input type="file"
                             name="file"
                    />
                    <x-slot:footer>
                        <div class="text-center">
                            <x-button rounded
                                      type="submit"
                                      primary
                            >
                                Submit
                            </x-button>
                        </div>
                    </x-slot:footer>
                </x-card>
            </form>
        </div>
    </div>
@endsection
