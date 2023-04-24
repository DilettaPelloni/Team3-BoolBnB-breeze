<script>
import AppHeader from "../../Components/MyComponents/AppHeader.vue";
import AppFooter from "../../Components/MyComponents/AppFooter.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

//TOMOTOM MAP
import Maps from '@tomtom-international/web-sdk-maps';
import tt from '@tomtom-international/web-sdk-maps';
import '@tomtom-international/web-sdk-maps/dist/maps.css';
import '@tomtom-international/web-sdk-services/';

export default {
    name: "Search",
    props: {
        apartments: Array, //contiene gli appartamenti filtrati per indirizzo
        services: Array,
        canLogin: Boolean,
        canRegister: Boolean,
        error: String //contiene un errore se non viene passato un indirizzo quando si fa la ricerca
    },
    components: {
        AppHeader,
        AppFooter,
        Head,
        Link,
        Maps,
        tt,
    },
    data() {
        return {
            searchForm: useForm({
                radius: 20,  //raggio di ricerca
                completeAddress: null //qua va l'indirizzo completo di tutte le sue info preso da TomTom
            }),
            addressInput: '', //v-model dell'input indirizzo
            addresses: [], //qui vengono messi gli indirizzi suggeriti
            showAddresses: false, //determina se sono visibili gli indirizzi suggeriti
            zoom: 10, //determina lo zoom della mappa
            rooms: 1,
            beds: 1,
            activeServices: [],
        };
    },
    methods: {
        getAutocompleteSearch() {
            axios
                .get(
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(this.addressInput)}.json?key=waiWTZRECqzNGHIbW83D94YfzNv1Uc1e&language=it-IT&countrySet=IT&limit=5`
                )
                .then((resp) => {
                    //salvo tutti gli indirizzi suggeriti
                    this.addresses = resp.data.results;
                    //li mostro in pagina
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
            //scrivo nell'input l'indirizzo scelto
            this.addressInput = address.address.freeformAddress;
            //nascondo l'elenco dei suggeriti
            this.showAddresses = false;
            //salvo i dati dell'indirizzo completo
            this.searchForm.completeAddress = address;
        },//selectAddress

        searchApartments() {
            //se l'utente non ha scelto un indirizzo dalla lista
            if(this.searchForm.completeAddress == null) {
                axios
                .get(
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(this.addressInput)}.json?key=waiWTZRECqzNGHIbW83D94YfzNv1Uc1e&language=it-IT&countrySet=IT&limit=5`
                )
                .then((resp) => {
                    //salvo il primo risultato
                    this.searchForm.completeAddress = resp.data.results[0];
                })
                .catch((err) => {
                    console.log(err);
                });
            }
            //poi mando i dati al BE
            this.searchForm.post(route("apartmentSearch"));            
        },//searchApartments

        toggleService(serviceId) {
            if (this.activeServices.includes(serviceId)) {
                this.activeServices.splice(this.activeServices.indexOf(serviceId), 1);
            } else {
                this.activeServices.push(serviceId);
            }
        }, //toggleService
    },
    computed: {
        filteredApartments() {
            if(this.apartments != null) {
                let filteredApartments = this.apartments;
                return filteredApartments;
            }
        }, //filteredApartments
    },
    watch: {
        addressInput() {
            this.getAutocompleteSearch();
        },
        filteredApartments() {
            if(this.filteredApartments.length > 0) {
                //creo la mappa
                const mapElement = document.getElementById("map");
                const map = tt.map({
                    key: "waiWTZRECqzNGHIbW83D94YfzNv1Uc1e",
                    container: mapElement,
                    center: [this.searchForm.completeAddress.position.lon, this.searchForm.completeAddress.position.lat],
                    zoom: this.zoom,
                });
                //creo un marker per ogni appartamento
                this.apartments.forEach((apartment) => {
                    new tt.Marker()
                        .setLngLat([apartment.longitude, apartment.latitude])
                        .addTo(map);
                })
            }
        }
    },//watch
    mounted() {
    }//mounted
};
</script>

<template>
    <Head title="Appartamenti" />

    <!-- HEADER -->
    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

    <!-- MAIN -->
    <div class="container">
        <!-- SEARCH BOX -->
        <div class="search-box text-center p-10">
            <h2 class="mb-4">
                Inserisci una destinazione per cominciare la tua ricerca
            </h2>
            <form @submit.prevent="searchApartments">
                <!-- INDIRIZZO -->
                <input
                    type="text"
                    id="addressInput"
                    name="addressInput"
                    placeholder="Inserisci un indirizzo..."
                    v-model="addressInput"
                    @input="getAutocompleteSearch()"
                    class="me-3"
                />
                <button type="submit" class="button p-2 text-white">
                    Cerca
                </button>
            </form>
            <!-- ELENCO INDIRIZZI SUGGERITI -->
            <div v-if="(addresses.length > 0) && (showAddresses)"
                class="absolute z-10 bg-white w-[500px] rounded-b-lg shadow-lg">
                <ul class="w-[500px]">
                    <li v-for="address in addresses" :key="address.id" class="border-b border-gray-200 w-[500px]">
                        <p class="hover:bg-gray-100 p-3" @click="selectAddress(address)">
                            {{ address.address.freeformAddress }}
                        </p>
                    </li>
                </ul>
            </div><!-- CHIUSURA INDIRIZZI SUGGERITI -->
        </div><!-- CHIUSURA SEARCH BOX -->

        <!-- CONTAINER CARTE -->
        <div
            v-if="filteredApartments != null"
            class="container-cards grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10"
        >
            <div class="card flex flex-col self-end" v-for="apartment in filteredApartments">
                <Link :href="route('gestione-appartamenti.show', apartment.id)" class="flex flex-col">
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
                    </div><!-- CHIUSURA CARD INFO -->
                </Link><!-- CHIUSURA CARD LINK -->
            </div><!-- CHIUSURA CARD -->
        </div><!-- CHIUSURA CONTAINER CARDS -->

        <!-- MAPPA -->
        <div class="w-full mt-20 mb-20">
            <div v-show="filteredApartments != null" class="w-full">
                <div id="map" class="h-96 "></div>
            </div>
        </div>
    </div><!-- CHIUSURA CONTAINER -->
    <AppFooter />
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.button {
    background-color: $main-color;
}

.container {
    padding: 0 20px;
    min-height: calc(100vh - 355px - 50px);
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
