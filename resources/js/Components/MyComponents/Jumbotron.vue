<script>
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    name: "Jumbotron",
    components: {
        Link,
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
        }
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
    }
};
</script>

<template>
    <div class="container-jumbotron">
        <!-- video -->
        <video autoplay muted loop class="video-bg">
            <source src="/img/sfondo.mp4" type="video/mp4" />
        </video>
        <!-- fine video -->
        <h1 class="text-center text-white text-[53px]">
            Quale sarà la tua prossima meta?
        </h1>
        <h2 class="text-center text-white text-[20px]">
            Scegli subito la tua destinazione!
        </h2>
        <form @submit.prevent="searchApartments" class="flex flex-col items-stretch sm:block">
            <!-- INDIRIZZO -->
            <input type="text" id="addressInput" name="addressInput" placeholder="Inserisci un indirizzo..."
                v-model="addressInput" @input="getAutocompleteSearch()" class="sm:me-3 rounded-full focus:ring-transparent" />
            <button type="submit" class="button text-white">
                Cerca la tua meta
            </button>
        </form>
        <!-- ELENCO INDIRIZZI SUGGERITI -->
        <div v-if="(addresses.length > 0) && (showAddresses)"
            class="top-[450px] md:top-[430px] absolute z-10 bg-white w-[500px] rounded-b-lg shadow-lg">
            <ul class="w-[500px]">
                <li v-for="address in addresses" :key="address.id" class="border-b border-gray-200 w-[500px]">
                    <p class="hover:bg-gray-100 p-3" @click="selectAddress(address)">
                        {{ address.address.freeformAddress }}
                    </p>
                </li>
            </ul>
        </div><!-- CHIUSURA INDIRIZZI SUGGERITI -->
    </div>
</template>

<style lang="scss" scoped>
@import '../../../scss/app.scss';

.video-bg {
    position: absolute;
    top: 0;
    left: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: -9;
    object-fit: cover;
}

.container-jumbotron {
    height: 505px;
    width: 100%;
    background-position: 36% 67%;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    justify-content: center;
    flex-direction: column;
    gap: 30px;
    align-items: center;
    position: relative;
}

/* bottone */
button {
    padding: 8px 20px;
    border-radius: 50px;
    border: none;
    background-color: #fe5b5f;
    color: #fff;
    font-family: "Figtree";
    font-size: 17px;
    cursor: pointer;
    margin-top: 40px;
}

button:hover {
    background-color: #fd4e4e;
}

button:active {
    background-color: #fc9aa1 !important;
    box-shadow: 0 5px #dd5b5f;
    transform: translateY(4px);
}

#addressInput {
    border-color: $main-color;
}

// .indirizzi-suggeriti{
//     top: 400px;
// }
</style>
