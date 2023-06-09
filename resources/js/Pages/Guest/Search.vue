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
        centerAddress: Object,
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
                completeAddress: null, //qua va l'indirizzo completo di tutte le sue info preso da TomTom
                filters: {
                    rooms: 1, //numero minimo di stanze
                    beds: 1, //numero minimo di letti
                    services: [], //servizi richiesti
                }
            }),
            addressInput: '', //v-model dell'input indirizzo
            addresses: [], //qui vengono messi gli indirizzi suggeriti
            showAddresses: false, //determina se sono visibili gli indirizzi suggeriti
            zoom: 10, //determina lo zoom della mappa
            error: null, //contiene messaggio d'errore
            showFilters: false, //determina se sono visibili i filtri
            filterButton: 'Mostra più filtri', //contenuto del bottone che toggola i filtri
            noResult: false, //mostra il messaggio "La ricerca non ha prodotto risultati"
            displayMap: false, //determina se la mappa è visibile
        };
    },
    methods: {
        getAutocompleteSearch() {
            this.addresses = [];
            axios
                .get(
                    `https://api.tomtom.com/search/2/geocode/${encodeURIComponent(this.addressInput)}.json?key=waiWTZRECqzNGHIbW83D94YfzNv1Uc1e&language=it-IT&countrySet=IT&limit=5`
                )
                .then((resp) => {
                    //salvo tutti gli indirizzi suggeriti
                    this.addresses = resp.data.results;
                    //li mostro in pagina
                    this.showAddresses = true;
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
            //se l'utente clicca cerca senza aver inserito un indirizzo
            if (this.addresses.length == 0) {
                this.error = 'Devi inserire un indirizzo valido per cercare';
                return;
            }
            //se l'utente non ha scelto un indirizzo dalla lista
            if (this.searchForm.completeAddress == null) {
                this.searchForm.completeAddress = this.addresses[0];
                this.addressInput = this.addresses[0].address.freeformAddress;
            }
            //poi mando i dati al BE
            this.searchForm.post(route("apartmentSearch"), {
                onSuccess: () => {
                    this.error = null;
                    this.searchForm.completeAddress = null;
                    //se non ho risultati mostro un messaggio
                    this.noResult = (this.apartments == null);
                },
            });

            //nascondo gli indirizzi suggeriti
            this.showAddresses = false;
        },//searchApartments

        toggleFilters() {
            if (this.showFilters) {
                this.showFilters = false;
                this.filterButton = 'Mostra più filtri';
            }
            else {
                this.showFilters = true;
                this.filterButton = 'Nascondi filtri';
            }
        },//toggleFilters

        createMap() {
            this.displayMap = true;
            if (this.searchForm.radius <= 20) {
                this.zoom = 10;
            }
            else {
                this.zoom = 8;
            }
            setTimeout(() => {
                //creo la mappa
                const mapElement = document.getElementById("map");
                const map = tt.map({
                    key: "waiWTZRECqzNGHIbW83D94YfzNv1Uc1e",
                    container: mapElement,
                    center: [this.centerAddress.position.lon, this.centerAddress.position.lat],
                    zoom: this.zoom,
                });
                //creo un marker per ogni appartamento
                this.apartments.forEach((apartment) => {
                    new tt.Marker()
                        .setLngLat([apartment.longitude, apartment.latitude])
                        .addTo(map);
                })
            }, 500);

        }
    },
    computed: {
    },
    watch: {
        apartments() {
            if (this.apartments?.length > 0) {
                //determino lo zoom in base al raggio di ricerca
                this.createMap();
            }
            else {
                this.displayMap = false;
            }
        }
    },//watch
    mounted() {
        setTimeout(() => {
            if (this.apartments?.length > 0) {
                this.createMap();
                if(this.centerAddress != null) {
                    this.addressInput = this.centerAddress.address.freeformAddress;
                    this.searchForm.completeAddress = this.centerAddress;
                    this.addresses.push(this.centerAddress);
                }
            }
        }, 500);
    },
};
</script>

<template>
    <Head>
        <title>
            Ricerca Appartamenti - BoolBnB
        </title>
        <link rel="icon" href="/favicon.svg" />
    </Head>

    <!-- HEADER -->
    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

    <!-- MAIN -->
    <div class="container">
        <!-- SEARCH BOX -->
        <div class="search-box text-center">
            <h2 class="mb-4">
                Inserisci una destinazione per cominciare la tua ricerca
            </h2>
            <form @submit.prevent="searchApartments" class="relative w-fit mx-auto ">
                <!-- INDIRIZZO -->
                <input type="text" id="addressInput" name="addressInput" placeholder="Inserisci un indirizzo..."
                    v-model="addressInput" @input="getAutocompleteSearch()" class="me-3 rounded-full focus:ring-transparent focus:border-mainColor-300" autocomplete="off"/>
                <button type="submit" class="button bg-mainColor-300 px-4 py-2 text-white rounded-full mt-5 sm:mt-0 hover:bg-[#fd4e4e]">
                    Cerca
                </button>

                <!-- ELENCO INDIRIZZI SUGGERITI -->
                <div v-if="(addresses.length > 0) && (showAddresses)"
                    class="absolute z-10 bg-white w-[200px] sm:w-[400px] md:w-[500px] rounded-lg shadow-lg overflow-hidden top-[150%] left-[50%] translate-x-[-50%]">
                    <ul>
                        <li v-for="address in addresses" :key="address.id" class="border-b border-gray-200">
                            <p class="hover:bg-gray-100 p-3" @click="selectAddress(address)">
                                {{ address.address.freeformAddress }}
                            </p>
                        </li>
                    </ul>
                </div><!-- CHIUSURA INDIRIZZI SUGGERITI -->
            </form>


            <!-- ERRORE -->
            <div v-if="error != null">
                <p>{{ error }}</p>
            </div>

            <!-- FILTRI -->
            <button @click="toggleFilters" class="button bg-mainColor-300 p-2 mt-8 text-white rounded-full py-2 px-4 hover:bg-[#fd4e4e]">
                {{ filterButton }}
            </button>

            <!-- CONTENITORE FILTRI -->
            <div class="filter-box py-5 " v-if="showFilters">
                <!-- RAGGIO DI RICERCA -->
                <div class="py-5">
                    <label class="mb-2" for="radius">
                        Definisci il raggio di ricerca
                    </label>
                    <input type="range" id="radius" name="radius" min="10" max="30" class="mx-3" v-model="searchForm.radius"
                        @change="searchApartments" />
                    <span>{{ searchForm.radius }} km</span>
                </div>

                <!-- STANZE -->
                <div>
                    <label class="mb-2 me-3">Filtra per numero di stanze</label>
                    <select class="rounded-full py-2 px-8 focus:ring-transparent" v-model="searchForm.filters.rooms" @change="searchApartments">
                        <option v-for="i in 10" :value="i">{{ i }}</option>
                    </select>
                </div>

                <!-- LETTI -->
                <div>
                    <label class="mb-2 me-3">Filtra per numero di posti letto</label>
                    <select class="rounded-full py-2 px-8 my-4 focus:ring-transparent" v-model="searchForm.filters.beds"
                        @change="searchApartments">
                        <option v-for="i in 10" :value="i">{{ i }}</option>
                    </select>
                </div>

                <!-- SERVIZI -->
                <div>
                    <p class="block py-5 font-bold text-gray-700 text-lg">
                        Servizi offerti:
                    </p>
                    <div
                        class="grid 2xl:grid-cols-4 xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-30 items-center justify-items-start">
                        <template v-for="service in services">
                            <label :for="service.id" class="my-3">
                                <input type="checkbox" :id="service.id" :name="service.id" :value="service.id"
                                    v-model="searchForm.filters.services" class="mr-4" @change="searchApartments" />
                                <span class="font-bold ">
                                    {{ service.name }}
                                    <font-awesome-icon :icon="['fas', service.icon]" class= "ml-3 text-mainColor-200 pr-[9px] h-[25px]"/>
                                </span>
                            </label>
                        </template>
                    </div>
                </div>

            </div><!-- CHIUSURA CONTENITORE FILTRI -->

        </div><!-- CHIUSURA SEARCH BOX -->

        <!-- NESSUN RISULTATO -->
        <div v-if="noResult" class="text-center mt-16 ">
            <h3 class="text-2xl font-bold text-mainColor-300 ">
                La ricerca non ha prodotto risultati
            </h3>
            <img src="/img/search.png" alt="Nessun risultato" class="w-[300px] mt-3 inline-block">
        </div>

        <h2 v-if="apartments != null" class="mt-10 px-3 text-mainColor-300 font-bold text-lg">
            {{ apartments?.length }} risultati trovati
        </h2>
        <!-- CONTAINER CARTE -->
        <div v-if="apartments != null"
            class="container-cards rounded-[7.5px] px-4 pt-6 md:p-10 grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10 bg-[#f5f5f5]">
            <div class="card flex flex-col bg-white rounded-[15px] overflow-hidden cursor-pointer transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105" v-for="apartment in apartments">
                <Link :href="route('guest_show', apartment.title_slug)" class="flex flex-col grow">
                <!-- IMMAGINE -->
                <img :src="apartment.full_cover_img_path" alt="immagine casa" class=" aspect-square w-full object-cover" />
                <!-- CARD INFO -->
                <div class="card-info px-4 pt-4 flex flex-col pb-4 grow">
                    <span><b>{{ apartment.title }}</b></span>
                    <div class="mt-2 grow flex items-center">
                        <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2 text-mainColor-300" />
                        {{ apartment.address }}
                    </div>
                    <div class="my-3 grow">
                        <p>Stanze: {{ apartment.rooms }}</p>
                        <p>Posti letto: {{ apartment.beds }}</p>
                    </div>
                    <ul class="flex flex-wrap">
                        <li v-for="service in apartment.services">
                            <font-awesome-icon :icon="['fas', service.icon]" class="me-2 text-mainColor-300"/>
                        </li>
                    </ul>
                </div><!-- CHIUSURA CARD INFO -->
                </Link><!-- CHIUSURA CARD LINK -->
            </div><!-- CHIUSURA CARD -->
        </div><!-- CHIUSURA CONTAINER CARDS -->

        <!-- MAPPA -->
        <div class="mt-20 mb-20 w-full" v-if="displayMap">
            <div>
                <div id="map" class="h-96 rounded-[7.5px]"></div>
            </div>
        </div>
    </div><!-- CHIUSURA CONTAINER -->

    <AppFooter />
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
.container {
    min-height: calc(100vh - 355px - 50px);
}
input,
select {
    border-color: $main-color;
}
</style>
