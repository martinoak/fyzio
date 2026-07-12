@extends('_layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?m={{ filemtime(public_path('css/tailwind.css')) }}">
@endsection

@section('content')
    <div id="wrapper">
        <main id="content">
            <section id="about" class="introduction scrollto">
                <div class="col-1">
                    <div class="section-heading">
                        <h2 class="section-title">LOG</h2>
                        <a href="{{ route('admin.log.clear') }}">
                            <button class="button button-red">
                                SMAZAT
                            </button>
                        </a>
                    </div>
                    <div class="w-full h-96 overflow-y-auto">
                        <pre>{{ $log }}</pre>
                    </div>

                </div>
                </section>
            </main>
        </div>
    </div>
@endsection

@section('bottomscripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
@endsection
