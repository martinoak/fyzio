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
                        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-arrow-left"></i> Zpět na dashboard</a>
                    </div>
                    <div class="col-1">
                        <div class="section-heading">
                            <h2 class="section-title">SPRÁVA CENÍKU</h2>
                            @if(session()->has('success'))
                                <div style="text-align: center; color: green; font-weight: bold; margin-bottom: 20px">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <form method="post" action="{{ route('admin.pricing') }}">
                            @csrf
                            <div class="mb-4">
                                <button type="button" @click="addPrice" class="button" style="background-color: #3F994F; color: white; margin-bottom: 20px">
                                    <i class="fa-solid fa-plus"></i> Přidat položku
                                </button>
                            </div>

                            <div v-for="(price, index) in prices" :key="index" class="mb-6 p-4 border border-gray-300 rounded-lg bg-white">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-semibold">Položka @{{ index + 1 }}</h3>
                                    <button type="button" @click="removePrice(index)" class="button button-small button-red">
                                        <i class="fa-solid fa-trash"></i> Smazat
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-2 font-semibold">Název služby *</label>
                                        <input
                                            type="text"
                                            v-model="prices[index].service_name"
                                            :name="'prices[' + index + '][service_name]'"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label class="block mb-2 font-semibold">Doba trvání</label>
                                        <input
                                            type="text"
                                            v-model="prices[index].duration"
                                            :name="'prices[' + index + '][duration]'"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5"
                                            placeholder="např. 30 min, 60 min"
                                        />
                                    </div>

                                    <div>
                                        <label class="block mb-2 font-semibold">Cena (Kč) *</label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            v-model="prices[index].price"
                                            :name="'prices[' + index + '][price]'"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5"
                                            required
                                        />
                                    </div>

                                    <div>
                                        <label class="block mb-2 font-semibold">Ikona (Font Awesome) *</label>
                                        <input
                                            type="text"
                                            v-model="prices[index].icon"
                                            :name="'prices[' + index + '][icon]'"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5"
                                            placeholder="např. fa-solid fa-person-walking"
                                            required
                                        />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block mb-2 font-semibold">Popis (volitelné)</label>
                                        <input
                                            type="text"
                                            v-model="prices[index].description"
                                            :name="'prices[' + index + '][description]'"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg w-full block p-2.5"
                                            placeholder="např. od 500 Kč"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="button" style="background-color: #3F994F; color: white;">
                                    <i class="fa-solid fa-save"></i> Uložit ceník
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@section('bottomscripts')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#wrapper',
            data: {
                prices: @json($prices)
            },
            methods: {
                addPrice: function() {
                    this.prices.push({
                        service_name: '',
                        duration: '',
                        price: '',
                        description: '',
                        icon: 'fa-solid fa-star',
                        order: this.prices.length + 1
                    });
                },
                removePrice: function(index) {
                    this.prices.splice(index, 1);
                }
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
@endsection
