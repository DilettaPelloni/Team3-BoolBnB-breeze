<script>
import AppHeader from "../../Components/MyComponents/AppHeader.vue";
import AppFooter from "../../Components/MyComponents/AppFooter.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    name: "Index",
    props: {
        apartments: Array,
        services: Array,
        canLogin: Boolean,
        canRegister: Boolean,
    },
    components: {
        AppHeader,
        AppFooter,
        Head,
        Link,
    },
    data() {
        return {
            rooms: 1,
            beds: 1,
            addressInput: '',
            activeServices: [],
            centerAddress: null,
            centerLatitude: null,
            centerLongitude: null,
            radius: 20,
            addresses: [],
            showAddresses: false,
        };
    },
    methods: {
        toggleService(serviceId) {
            if (this.activeServices.includes(serviceId)) {
                this.activeServices.splice(this.activeServices.indexOf(serviceId), 1);
            } else {
                this.activeServices.push(serviceId);
            }
        }, //toggleService
        getAutocompleteSearch(address) {
            axios
                .get(
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(address)}.json?key=waiWTZRECqzNGHIbW83D94YfzNv1Uc1e&language=it-IT&countrySet=IT&limit=5`
                )
                .then((resp) => {
                    this.addresses = resp.data.results;
                    this.showAddresses = true;
                    this.centerAddress = resp.data.results[0];
                    this.centerLatitude = this.centerAddress.position.lat;
                    this.centerLongitude = this.centerAddress.position.lon;
                })
                .catch((err) => {
                    console.log(err);
                });
        },//getAutocompleteSearch
        selectAddress(address) {
            this.addressInput = address.address.freeformAddress;
            this.centerAddress = address;
            this.showAddresses = false;
            this.centerLatitude = address.position.lat;
            this.centerLongitude = address.position.lon;
        },//selectAddress
    },
    computed: {
        showApartments() {
            //all'inizio mostro tutti gli appartamenti
            let apartments = this.apartments;
            //filtro per stanze
            apartments = apartments.filter(apartment => apartment.rooms >= this.rooms);
            //filtro per letti
            apartments = apartments.filter(apartment => apartment.beds >= this.beds);
            //filtro per servizi
            if (this.activeServices.length > 0) {
                apartments = apartments.filter((apartment)=> {
                    let flag = true;
                    let servicesIds = [];
                    apartment.services.forEach((service) => servicesIds.push(service.id));
                    this.activeServices.forEach((service) => {
                        if(!servicesIds.includes(service)) { flag = false }
                    });//forEach
                    return flag;
                })//filetr
            }//if

            //filtro per coordinate
            if(this.centerAddress) {
                apartments = apartments.filter((apartment)=> {
                    const R = 6371e3; // metres
                    const φ1 = this.centerLatitude * Math.PI/180; // φ, λ in radians
                    const φ2 = apartment.latitude * Math.PI/180;
                    const Δφ = (apartment.latitude - this.centerLatitude) * Math.PI/180;
                    const Δλ = (apartment.longitude - this.centerLongitude) * Math.PI/180;

                    const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                            Math.cos(φ1) * Math.cos(φ2) *
                            Math.sin(Δλ/2) * Math.sin(Δλ/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

                    const d = R * c; // in metres

                    console.log(d);
                    
                    if(d <= (this.radius * 1000)) {
                        return true;
                    }
                    return false;
                })
            }
            return apartments;
        },//showApartments
    },
    watch: {
        addressInput() {
            this.getAutocompleteSearch(this.addressInput);
        },
    }//watch
};
</script>

<template>
    <Head title="Appartamenti" />

    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />
    <div class="container">
        <!-- crea una search bar per filtrare gli appartamenti -->
        <div class="flex justify-center my-10">
            <form class="w-1/2">
                <!-- INDIRIZZO -->
                <input
                    id="addressInput"
                    name="addressInput"
                    type="text"
                    class="rounded-full py-2 px-4 w-full"
                    placeholder="Cerca appartamento"
                    v-model="addressInput"
                    autofocus
                    @input="getAutocompleteSearch(addressInput)"
                />
                <div v-if="(addresses.length > 0) && (showAddresses)"
                    class="absolute z-10 bg-white w-[500px] rounded-b-lg shadow-lg">
                    <ul class="w-[500px]">
                        <li v-for="address in addresses" :key="address.id" class="border-b border-gray-200 w-[500px]">
                            <p class="hover:bg-gray-100 p-3" @click="selectAddress(address)">
                                {{ address.address.freeformAddress }}
                            </p>
                        </li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- crea una colonna laterale con i filtri all'interno -->
        <div class="flex flex-wrap gap-10">
            <!-- RAGGIO DI RICERCA -->
            <div class="flex flex-col w-1/3">
                <label class="mb-2">Definisci il raggio di ricerca (km)</label>
                <input
                    type="range"
                    min="10"
                    max="200"
                    v-model="radius"
                    class="slider"
                    id="radius"
                    name="radius"
                />
                {{ radius }}
            </div>
            <!-- ROOMS BEDS -->
            <div class="flex justify-center my-10">
                <!-- SCATOLA -->
                <div class="flex flex-wrap gap-10">
                    <!-- ROOMS -->
                    <div class="flex flex-col w-1/3">
                        <label class="mb-2">Filtro per numero di stanze</label>
                        <select class="rounded-full py-2 px-4 w-full" v-model="rooms">
                            <option v-for="i in 10" :value="i">{{ i }}</option>
                        </select>
                    </div>
                    <!-- BEDS -->
                    <div class="flex flex-col w-1/3">
                        <label class="mb-2">Filtro per numero di letti</label>
                        <select class="rounded-full py-2 px-4 w-full" v-model="beds">
                            <option v-for="i in 10" :value="i">{{ i }}</option>
                        </select>
                    </div>
                </div><!-- CHIUSURA SCATOLA -->
            </div><!-- CHIUSURA ROOMS BATHROOMS BEDS -->
            <!-- SERVIZI -->
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
                            type="checkbox"
                            :id="service.id"
                            :name="service.id"
                            :value="service.id"
                            class="mx-2"
                            @click="toggleService(service.id)"
                        />
                    </template>
                </div>
            </div> <!-- CHIUSURA SERVIZI -->
        </div><!-- CHIUSURA CAMPI RICERCA -->




        <div class="container-cards grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10">
            <div class="card flex flex-col self-end" v-for="apartment in showApartments">
                <Link :href="route('gestione-appartamenti.show', apartment.id)
                    " class="flex flex-col">
                <!-- IMMAGINE -->
                <img :src="apartment.full_cover_img_path" alt="immagine casa" />
                <!-- CARD INFO -->
                <div class="card-info px-4 pt-4 flex flex-col justify-center ">
                    <span><b>{{ apartment.title }}</b></span>
                    <div class="mt-2 grow flex items-center">
                        <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2" />
                        {{ apartment.address }}
                    </div>
                    <div class="mt-2">
                        <font-awesome-icon :icon="['fas', 'maximize']" />
                        {{ apartment.size }} m<sup>2</sup>
                    </div>
                    {{ apartment.rooms }}
                    {{ apartment.beds }}
                    {{ apartment.bathrooms }}
                    <ul>
                        <li v-for="service in apartment.services">
                            {{ service.name }}
                        </li>
                    </ul>
                </div>
                <!-- CHIUSURA CARD INFO -->
                </Link>


            </div>
            <!-- CHIUSURA CARD -->
        </div>
        <!-- CHIUSURA CONTAINER CARDS -->


    </div>
    <!-- CHIUSURA CONTAINER -->
    <AppFooter />
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.button {
    background-color: $main-color;
}

.container {
    padding: 0 20px;
}

.container-cards {
    padding-top: 50px;
}

.card {
    background-color: white;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease-in-out;

    img {
        aspect-ratio: 1/1;
        width: 100%;
        object-fit: cover;
    }
}
</style>
