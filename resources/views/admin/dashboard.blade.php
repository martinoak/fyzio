@extends('_layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?m={{ filemtime(public_path('css/tailwind.css')) }}">
@endsection

@section('content')
    <div id="wrapper">
        @include('partials.announcement')
        <main id="content">
            <section id="about" class="introduction scrollto">
                <div class="row clearfix">
                    <div class="col-1">
                        <a href="{{ route('homepage') }}"><i class="fa-solid fa-house"></i> Na domovskou stránku</a>
                    </div>
                    <div class="col-3">
                        <div class="section-heading">
                            <h2 class="section-title">OZNÁMENÍ</h2>
                            <form id="announcement-form" action="{{ route('set-announcement') }}" method="post">
                                @csrf
                                <textarea
                                        type="text"
                                        name="message"
                                        id="name"
                                        class="contact-input"
                                        placeholder="Zpráva"
                                        v-model="preview"
                                        aria-label
                                ></textarea>
                                <h4 class="mt-4">Pozadí</h4>
                                <ul class="grid grid-rows-3 gap-4">
                                    <li>
                                        <input type="radio" id="hosting-small" name="background" value="#f5b648" class="hidden peer" @checked(($announcement->background ?? '#f5b648') === '#f5b648')>
                                        <label for="hosting-small" class="inline-flex p-2 px-5 bg-[#f5b648] border rounded-lg cursor-pointer peer-checked:border-2 peer-checked:border-blue-600">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold text-white">@{{ preview | truncate(25, '...') }}</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="hosting-medium" name="background" value="#3f994f" class="hidden peer" @checked($announcement->background === '#3f994f')>
                                        <label for="hosting-medium" class="inline-flex p-2 px-5 bg-[#3f994f] border rounded-lg cursor-pointer peer-checked:border-2 peer-checked:border-blue-600">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold text-white">@{{ preview | truncate(25, '...') }}</div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="hosting-large" name="background" value="#212121" class="hidden peer" @checked($announcement->background === '#212121')>
                                        <label for="hosting-large" class="inline-flex p-2 px-5 bg-[#212121] border rounded-lg cursor-pointer peer-checked:border-2 peer-checked:border-blue-600">
                                            <div class="block">
                                                <div class="w-full text-lg font-semibold text-white">@{{ preview | truncate(25, '...') }}</div>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                                <h4 class="mt-4">Konec zprávy (nepovinný)</h4>
                                <input type="datetime-local" name="end" class="contact-input" value="{{ $announcement->ends_at?->format('Y-m-d\TH:i') }}" aria-label>
                            </form>

                            <div class="mt-4">
                                <button form="announcement-form" type="submit" class="button me-4 bg-white">PROPSAT</button>
                                @if(!empty($announcement->message))
                                    <form action="{{ route('set-announcement') }}" method="post" style="display: inline">
                                        @csrf
                                        <button type="submit" class="button button-red">
                                            SMAZAT
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="section-heading">
                            <h2 class="section-title">ÚPRAVA WEBU</h2>
                            <div class="mb-4">
                                <a href="{{ route('admin.pricing') }}" class="button" style="background-color: #3F994F; color: white;">
                                    <i class="fa-solid fa-money-bill"></i> Upravit ceník
                                </a>
                            </div>
                        </div>
                        <form method="post" action="{{ route('save-methods') }}">
                            <div class="flex-col sm:flex">
                                <div class="w-full sm:w-1/2" style="min-width: 50%">
                                    <div class="section-heading">
                                        <h3 class="section-title">Terapeutické metody</h3>
                                    </div>
                                    <div class="w-3/4 my-2" v-for="(method, index) in methods" :key="index">
                                        <div class="flex items-center">
                                            <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5" v-model="methods[index]" name="methods[]" autocomplete="off" aria-label="" />
                                            <button class="button button-small" @click="removeMethod(index)" type="button">Smazat</button>
                                        </div>
                                    </div>
                                    <button @click="addMethod()" class="button button-small ms-0" type="button">PŘIDAT</button><br>
                                </div>
                                <div class="w-full sm:w-1/2" style="min-width: 50%">
                                    <div class="section-heading">
                                        <h3 class="section-title">Fyzikální terapie</h3>
                                    </div>
                                    <div class="w-3/4 my-2" v-for="(therapy, index) in therapies" :key="index">
                                        <div class="flex items-center">
                                            <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5" v-model="therapies[index]" name="therapies[]" autocomplete="off" aria-label="" />
                                            <button class="button button-small" @click="removeTherapy(index)" type="button">Smazat</button>
                                        </div>
                                    </div>
                                    <button @click="addTherapy()" class="button button-small ms-0" type="button">PŘIDAT</button><br>
                                </div>
                            </div>
                            <div class="w-full">
                                <button class="button" type="submit">ULOŽIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        new Vue({
            el: '#wrapper',
            data: {
                preview: @json($announcement->message ?? ''),
                methods: @json($methods),
                therapies: @json($therapies)
            },
            methods: {
                addMethod: function() {
                    this.methods.push('');
                },
                removeMethod: function(index) {
                    this.methods.splice(index, 1);
                },
                addTherapy: function() {
                    this.therapies.push('');
                },
                removeTherapy: function(index) {
                    this.therapies.splice(index, 1);
                }
            }
        });


        const filter = function (text, length, clamp) {
            clamp = clamp || '...';
            const node = document.createElement('div');
            node.innerHTML = text;
            const content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        };

        Vue.filter('truncate', filter);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
@endsection
