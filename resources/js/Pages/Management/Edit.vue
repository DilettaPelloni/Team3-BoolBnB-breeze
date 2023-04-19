<script>
import { Head } from '@inertiajs/vue3';
import { useForm } from "@inertiajs/vue3";
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
    name: "Edit",
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: {
        services: Array,
        apartment: Object,
    },
    data() {
        return {
            newApartment: useForm({
                _method: 'put',
                title: this.apartment.title,
                description: this.apartment.description,
                address: this.apartment.address,
                rooms: this.apartment.rooms,
                beds: this.apartment.beds,
                bathrooms: this.apartment.bathrooms,
                size: this.apartment.size,
                cover_img: null,
                visible: this.apartment.visible,
                activeServices: [],
            }),
            addresses: [],
            addressInput: "",
        };
    },
    methods: {
        pushService(serviceId) {
            let servicesArray = this.newApartment.activeServices;
            if (servicesArray.includes(serviceId)) {
                servicesArray.splice(servicesArray.indexOf(serviceId), 1);
            } else {
                servicesArray.push(serviceId);
            }
        }, //pushService
        submit() {
            this.newApartment.post(route("gestione-appartamenti.update", this.apartment.id));
        }, //submit
        // getHint() {
        //     axios.get('https://api.tomtom.com/search/2/autocomplete/', {
        //         params: {
        //             query: this.newApartment.address,
        //             ext: 'json',
        //             key: 'waiWTZRECqzNGHIbW83D94YfzNv1Uc1e',
        //             language: 'it-IT'
        //         }
        //     }).then((response) => {
        //         console.log(response)  
        //     });//richiesta
        // }
        getAutocompleteSearch(addressInput) {
            //questa funzione fa una chiamata axios per ottenere i risultati dell'autocomplete
            //in base all'input dell'indirizzo
            axios
                .get(
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(addressInput)}.json?key=DbiOfdWsIVqot1ZmNT2KUNMPv2Ydr0mG&language=it-IT&countrySet=IT&limit=5`
                )
                .then((resp) => {
                    this.addresses = resp.data.results;
                })
        }//getAutocompleteSearch
    },
    watch: {
        addressInput() {
            this.getAutocompleteSearch(this.newApartment.address);
        },
        //watch è un metodo che permette di eseguire una funzione quando una variabile cambia
        //in questo caso, quando cambia l'input dell'indirizzo, viene eseguita la funzione getAutocompleteSearch
        //che fa una chiamata axios per ottenere i risultati dell'autocomplete
    },//watch
    mounted() {
        //dentro a this.apartment.services ci sono tanti oggetti quanti sono i servizi collegati all'appartamento
        //ciclo questi oggetti, ne prendo la chiave "id" e la pusho nell'array this.newApartment.activeServices (che è dentro al form)
        if(this.apartment.services) {
            this.apartment.services.forEach(service => {
                this.newApartment.activeServices.push(service.id);
            });
        }
	}//mounted
};
</script>

<template>
    <Head :title="apartment.title" />
    <AuthenticatedLayout>
        <div class="small-container">
            <form
                @submit.prevent="submit"
            >
                <!-- ----------------------TITLE---------------------- -->
                <div class="mb-3">
                    <label
                        for="title"
                        class="block text-gray-700 font-bold mb-2 text-lg"
                        >Nome Appartamento</label
                    >
                    <input
                        type="text"
                        id="title"
                        name="title"
                        v-model="newApartment.title"
                        placeholder="Inserisci il nome..."
                        required
                        autofocus
                        maxlength="255"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                    <div
                        v-if="newApartment.errors.title"
                        class="text-red-500 text-xs italic"
                    >
                        {{ newApartment.errors.title }}
                    </div>
                </div>
                <!-- ----------------------DESCRIPTION---------------------- -->
                <div class="mb-3">
                    <label
                        for="description"
                        class="block text-gray-700 font-bold mb-2 text-lg"
                        >Descrizione</label
                    >
                    <textarea
                        v-model="newApartment.description"
                        rows="10"
                        id="description"
                        name="description"
                        placeholder="Inserisci una descrizione per la tua abitazione..."
                        maxlength="3000"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    ></textarea>
                    <div
                        v-if="newApartment.errors.description"
                        class="text-red-500 text-xs italic"
                    >
                        {{ newApartment.errors.description }}
                    </div>
                </div>
                <!-- ----------------------ADDRESS---------------------- -->
                <div class="mb-3 pt-[45px]">
                    <label for="address" class="block font-medium text-gray-700 text-lg">
                        Indirizzo
                    </label>
                    <input
                        v-model="newApartment.address"
                        type="text"
                        id="address"
                        name="address"
                        placeholder="Inserisci un indirizzo"
                        required
                        autofocus
                        maxlength="255"
                        @input="getAutocompleteSearch(addressInput)"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                    <div v-if="newApartment.errors.address" class="text-red-500 mt-2 text-xs italic">
                        {{ newApartment.errors.address }}
                    </div>

                    <div v-if="addresses.length > 0" class="absolute z-10 bg-white w-full rounded-b-lg shadow-lg">
                        <ul>
                            <li v-for="address in addresses" :key="address.id" class="border-b border-gray-200">
                                <a href="#" class="block hover:bg-gray-100 p-3">
                                    {{ address.address.freeformAddress }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ----------------------ROOMS---------------------- -->
                <div class="mb-3 pt-[45px]">
                    <label for="rooms" class="block font-medium text-gray-700 text-lg"
                        >Numero di stanze</label
                    >
                    <input
                        v-model="newApartment.rooms"
                        type="number"
                        min="1"
                        max="10"
                        id="rooms"
                        placeholder="Da 1 a 10"
                        name="rooms"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                    />
                    <div
                        v-if="newApartment.errors.rooms"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ newApartment.errors.rooms }}
                    </div>
                </div>
                <!-- ----------------------BEDS---------------------- -->
                <div class="mb-3">
                    <label for="beds" class="block font-medium text-gray-700 text-lg"
                        >Numero di letti</label
                    >
                    <input
                        v-model="newApartment.beds"
                        type="number"
                        min="1"
                        max="10"
                        placeholder="Da 1 a 10"
                        id="beds"
                        name="beds"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                    />
                    <div
                        v-if="newApartment.errors.beds"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ newApartment.errors.beds }}
                    </div>
                </div>
                <!-- ----------------------BATHROOMS---------------------- -->
                <div class="mb-4">
                    <label
                        for="bathrooms"
                        class="block font-medium text-gray-700 text-lg"
                        >Numero di bagni</label
                    >
                    <input
                        v-model="newApartment.bathrooms"
                        type="number"
                        min="1"
                        max="4"
                        id="bathrooms"
                        name="bathrooms"
                        placeholder="Da 1 a 4"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required
                    />
                    <div
                        v-if="newApartment.errors.bathrooms"
                        class="text-red-600 mt-2 text-sm"
                    >
                        {{ newApartment.errors.bathrooms }}
                    </div>
                </div>
                <!-- ----------------------SIZE---------------------- -->
                <div class="mb-4">
                    <label for="size" class="block font-medium text-gray-700 text-lg"
                        >Metri quadrati</label
                    >
                    <input
                        v-model="newApartment.size"
                        type="number"
                        min="12"
                        max="300"
                        id="size"
                        name="size"
                        placeholder="Da 12 a 300"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        required
                    />
                    <div
                        v-if="newApartment.errors.size"
                        class="text-red-600 mt-2 text-sm"
                    >
                        {{ newApartment.errors.size }}
                    </div>
                </div>

                <!-- ----------------------COVER IMG---------------------- -->
                <div class="mb-3 pt-[45px]">
                    
                    <label
                        for="cover_img"
                        class="block pb-2 font-medium text-gray-700 text-lg"
                        >Immagine di copertina</label
                    >
                    <!-- se l'appartamento ha un'immagine, la mostro in anteprima -->
                    <div v-if="apartment.cover_img != null">
                        <img :src="apartment.full_cover_img_path" alt="anteprima immagine" class="prev-img">
                    </div>
                    <input
                        @input="newApartment.cover_img = $event.target.files[0]"
                        type="file"
                        name="cover_img"
                        id="cover_img"
                        accept="image/*"
                        class="py-2 px-4 mb-2 leading-5 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                        placeholder="Inserisci l'immagine dell'appartamento"
                    />

                    <!-- PER VEDERE PROGRESSO DI CARICAMENTO DEL FILE (E' TROPPO VELOCE PER VEDERE QUALCOSA) -->
                    <!-- <progress v-if="newApartment.progress" :value="newApartment.progress.percentage" max="100">
                    {{ newApartment.progress.percentage }}%
                </progress> -->

                    <div v-if="newApartment.errors.cover_img" class="text-red-600">
                        {{ newApartment.errors.cover_img }}
                    </div>
                </div>
                <!-- ----------------------VISIBLE---------------------- -->
                <div class="mb-3 flex items-center pt-[45px]">
                    <p class="block font-medium text-gray-700 text-lg pr-5">
                        Vuoi che l'appartamento sia visibile?
                    </p>
                    <div>
                        <label for="not-visibile" class="inline-block font-bold">
                            NO
                        </label>
                        <input
                            v-model="newApartment.visible"
                            type="radio"
                            id="not-visibile"
                            name="visibile"
                            value="0"
                            class="mx-2"
                            :checked="!apartment.visible"
                        />

                        <label for="visibile" class="inline-block font-bold">
                            SI
                        </label>
                        <input
                            v-model="newApartment.visible"
                            type="radio"
                            id="visibile"
                            name="visibile"
                            value="1"
                            class="mx-2"
                            :checked="apartment.visible"
                        />
                        <div v-if="newApartment.errors.visible" class="text-red-600">
                            {{ newApartment.errors.visible }}
                        </div>
                    </div>
                </div>
                <!-- ----------------------SERVICES---------------------- -->
                <div class="mb-3 pt-[45px]">
                    <p class="block pb-2 font-medium text-gray-700 text-lg">
                        Servizi offerti
                    </p>
                    <div class="flex flex-wrap">
                        <template v-for="service in services">
                            <label :for="service.id" class="mr-2">
                                <span class="inline-block font-bold">{{
                                    service.name
                                }}</span>
                                {{ service.icon }}
                            </label>
                            <input
                                @click="pushService(service.id)"
                                type="checkbox"
                                :id="service.id"
                                :name="service.id"
                                :value="service.id"
                                class="mx-2"
                                :checked="newApartment.activeServices.includes(service.id)"
                            />
                            
                        </template>
                    </div>
                    <div v-if="newApartment.errors.activeServices" class="text-red-600">
                        {{ newApartment.errors.activeServices }}
                    </div>
                </div>

                <div class="text-center">
                    <button
                        type="submit"
                        :disabled="newApartment.processing"
                        class="mt-8 px-4 py-2 rounded-full pink text-white"
                    >
                        Modifica appartamento
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import '../../../scss/app.scss';
.pink {
    background-color: #fe5b5f;
}

[type="radio"]:checked {
    color: #fe5b5f;
}

[type="checkbox"]:checked {
    color: #fe5b5f;
}

[type="number"]:focus {
    border-color: #fe5b5f;
    --tw-ring-color: #fe5b5f;
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0
        calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
}

[type="text"]:focus {
    --tw-ring-color: #fe5b5f;
    border-color: #fe5b5f;
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0
        calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
}

text-area:focus {
    --tw-ring-color: #fe5b5f;
    border-color: #fe5b5f;
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0
        calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
}

.focus\:ring-2:focus {
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0
        calc(2px + var(--tw-ring-offset-width)) rgb(254 91 95);
}

.prev-img{
    width: 400px;
    margin-bottom: 1rem;
}
</style>
