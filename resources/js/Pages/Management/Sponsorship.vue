<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";



export default {
    name: "Sponsoship",
    props: {
        sponsorships: Array,
        apartments: Array,
        activeSponsorships: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
    },
    data() {
        return {
            modalVisible: false,//mostra il modale per scegliere il tipo di sponsorizzazione
            payModalVisible: false, //mostra il modale per pagare
            showPaymentButton: false, //mostra il bottone per pagare
            successMessage: false, //mostra un messaggio di successo se la creazione della sponsorship è andata a buon fine
            newActiveSponsorship: useForm({
                selectedApartment: null,
                selectedSponsor: null, //sponsorship scelta dall'utente
            }),
            clientToken: '',
            error: '',
            dropinInstance: null,
            amount: null,
        };
    },
    methods: {
        isSponsorized(apartment) {
            //di base ritorno vero
            let flag = true;
            //prendo la data di oggi
            const today = new Date();
            //se ci sono sponsorships attive sugli appartamenti di questo utente
            if (this.activeSponsorships.length > 0) {
                //per ogni sponsorship attiva
                this.activeSponsorships.forEach((sponsorship) => {
                    //vedo se è relativa all'appartamento che sto esaminando
                    if (sponsorship.apartment_id == apartment.id) {
                        //trasformo la sua data di fine in un ogetto Date
                        let end_date = new Date(sponsorship.end_date);
                        //se la data di fine è maggiore della data di oggi ritorno falso
                        if (end_date > today) {
                            flag = false;
                        }
                    }
                });
            }
            return flag;
        }, //isSponsorized
        selectsApartment(apartment) {
            this.newActiveSponsorship.selectedApartment = apartment.id;
            this.modalVisible = true;
        },//selectsApartment
        activateSponsorship(sponsorship) {
            this.modalVisible = false;
            this.payModalVisible = true;
            this.newActiveSponsorship.selectedSponsor = sponsorship;
            this.getClientToken();
        },//activateSponsorship
        endDate(apartment) {
            let endDate = '';
            const today = new Date();
            //se ci sono sponsorship sugli appartamenti
            if (this.activeSponsorships.length > 0) {
                //per ogni sponsorship
                this.activeSponsorships.forEach((sponsorship) => {
                    //vedo se è relativa all'appartamento che sto esaminando
                    if (sponsorship.apartment_id == apartment.id) {
                        let end_date = new Date(sponsorship.end_date);
                        //verifico se è attiva
                        if (end_date > today) {
                            let year = end_date.getFullYear();
                            let month = (end_date.getMonth() + 1 < 10 ? '0' : '') + (end_date.getMonth() + 1);
                            let day = (end_date.getDate() < 10 ? '0' : '') + end_date.getDate();
                            endDate = day + '/' + month + '/' + year;
                        }
                    }
                });
            }
            return endDate;
        },//endDate
        getClientToken() {
            axios.get('http://127.0.0.1:8000/api/token')
                .then(response => {
                    this.clientToken = response.data.token;
                    this.showPaymentButton = true;
                    braintree.dropin.create({
                        authorization: this.clientToken,
                        selector: '#dropin-container',
                        locale: 'it_IT'
                    },
                        (err, instance) => {
                            this.dropinInstance = instance;
                        });
                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Could not get client token';
                });
        },//getClientToken
        sendPayment() {
            this.showPaymentButton = false;
            this.amount = this.newActiveSponsorship.selectedSponsor.price;

            this.dropinInstance.requestPaymentMethod((error, payload) => {
                const nonce = payload.nonce;

                axios.post('http://127.0.0.1:8000/api/transaction/create', {
                    nonce: nonce,
                    amount: this.amount,
                })
                    .then(response => {
                        if (response.data.success) {
                            this.createActiveSponsorship();

                        } else {
                            console.log(response.data);
                            this.error = response.data.message;
                        }
                    })
            });
        },//sendPayment
        createActiveSponsorship() {
            this.newActiveSponsorship.post(route('createActiveSponsoship'), {
                onSuccess: () => {
                    this.payModalVisible = false;
                    this.successMessage = true;
                },
            });
        },//createActiveSponsorship
        endHour(apartment) {
            let endHour = '';
            const today = new Date();
            //se ci sono sponsorship sugli appartamenti
            if (this.activeSponsorships.length > 0) {
                //per ogni sponsorship
                this.activeSponsorships.forEach((sponsorship) => {
                    //vedo se è relativa all'appartamento che sto esaminando
                    if (sponsorship.apartment_id == apartment.id) {
                        let end_date = new Date(sponsorship.end_date);
                        //verifico se è attiva
                        if (end_date > today) {
                            let hour = (end_date.getHours() < 10 ? '0' : '') + end_date.getHours();
                            let minutes = (end_date.getMinutes() < 10 ? '0' : '') + end_date.getMinutes();
                            endHour = hour + ':' + minutes;
                        }
                    }
                });
            }
            return endHour;
        },//endHour
    },
    created() {
        let recaptchaScript = document.createElement('script');
        recaptchaScript.setAttribute('src', 'https://js.braintreegateway.com/web/dropin/1.36.1/js/dropin.js');
        document.head.appendChild(recaptchaScript);
    },
};
</script>

<template>
    <Head>
        <title>
            Sponsorship - BoolBnB
        </title>
        <link rel="icon" href="/favicon.svg" />
    </Head>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul class="p-6 text-gray-900">
                        <li v-for="apartment in apartments"
                            class="py-5 border-b border-mainColor-300 item flex flex-col sm:flex-row sm:justify-between sm:items-center justify-center items-start">
                            <!-- TITOLO E IMMAGINE -->
                            <div class="flex items-center">
                                <img :src="apartment.full_cover_img_path" alt="apartment_image"
                                    class="image-preview rounded-md w-[100px] aspect-square object-cover">
                                <h4 class="ms-10">
                                    {{ apartment.title }}
                                </h4>
                            </div>

                            <!-- BOTTONE -->
                            <div class="flex flex-col items-start sm:items-center md:mt-0 mt-5">
                                <button class="rounded-full my-button mb-3 py-2 px-4 text-white bg-mainColor-300" :class="{
                                    disabled: !isSponsorized(apartment),
                                }" :disabled="!isSponsorized(apartment)" @click="selectsApartment(apartment)">
                                    {{ isSponsorized(apartment) ? 'Sponsorizza' : 'Sponsorizzazione attiva' }}
                                </button>
                                <p class="remaining-time" v-if="!isSponsorized(apartment)">
                                    <font-awesome-icon :icon="['far', 'calendar']" />
                                    {{ endDate(apartment) }}
                                </p>
                                <p class="remaining-time" v-if="!isSponsorized(apartment)">
                                    <font-awesome-icon :icon="['far', 'clock']" />
                                    {{ endHour(apartment) }}
                                </p>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>

            <!-- MODALE SCELTA SPONSOR -->
            <div class="modal-overlay fixed top-0 right-0 bottom-0 left-0 bg-black/[0.6]" v-if="modalVisible" @click="modalVisible = false">
                <div class="modal translate-x-[-50%] translate-y-[-50%] fixed top-[20%] left-[50%] mt-[80px] flex flex-col justify-center items-center min-h-[250px] min-w-[250px] rounded-[15px] p-8 text-center bg-white" @click.stop>
                    <h3>Scegli il tuo piano di sponsorizzazione</h3>
                    <div class="columns-container flex mt-3">
                        <div class="column ps-4 pe-4" v-for="sponsorship in sponsorships">
                            <h4 class="font-bold ">
                                {{ sponsorship.name }}
                            </h4>
                            <div class="price mt-3">
                                <p class="subtitle text-mainColor-300">Prezzo</p>
                                <p>{{ sponsorship.price.replace(/\./g, ',') }} €</p>
                            </div>
                            <div class="duration mt-3">
                                <p class="subtitle text-mainColor-300">Durata della sponsorizzazione</p>
                                <p>{{ sponsorship.duration.substring(0, sponsorship.duration.indexOf(":")) }} ore</p>
                            </div>

                            <button class="rounded-full mt-10 px-4 py-2 bg-mainColor-300 text-white my-button" @click="activateSponsorship(sponsorship)">
                                Inizia
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- CHIUSURA MODALE SCELTA SPONSOR -->

            <!-- MODALE PAGAMENTO -->
            <div class="modal-overlay fixed top-0 right-0 bottom-0 left-0 bg-black/[0.6]" v-show="payModalVisible" @click="payModalVisible = false">
                <div class="modal translate-x-[-50%] translate-y-[-50%] fixed top-[20%] left-[50%] mt-[80px] flex flex-col justify-center items-center min-h-[250px] min-w-[250px] rounded-[15px] p-8 text-center bg-white" @click.stop>

                    <form @submit.prevent="sendPayment">

                        <!-- QUA DENTRO SI CREA LA MASCHERA PER IL PAGAMENTO -->
                        <div id="dropin-container"></div>

                        <!-- IN CASO DI ERRORE LO MOSTRO -->
                        <div v-if="error != ''">
                            <p>{{ error }}</p>
                        </div>

                        <!-- ANIMAZIONE DI CARICAMENTO -->
                        <div v-show="!showPaymentButton">
                            <div class="lds-default">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>

                        <!-- COMPARE QUANDO OTTENGO IL TOKEN, SCOMPARE QUANDO CREO LA TRANSAZIONE -->
                        <div v-show="showPaymentButton">
                            <!-- PREZZO E DURATA DELLA SPONSORIZZAZIONE -->
                            <h3 class="mt-5 mb-5">
                                Importo della transazione:
                                <strong>
                                    {{ newActiveSponsorship.selectedSponsor?.price.replace(/\./g, ',') }} €
                                </strong>
                            </h3>
                            <h3 class="mt-5 mb-5">
                                Durata della sponsorizzazione:
                                <strong>
                                    {{ newActiveSponsorship.selectedSponsor?.duration.substring(0,
                                        newActiveSponsorship.selectedSponsor.duration.indexOf(":")) }} ore
                                </strong>
                            </h3>

                            <!-- PULSANTE PER PAGARE -->
                            <button id="submit-button" type="submit" class="button py-[10px] px-[20px] text-sm cursor-pointer font-medium bg-mainColor-300 text-white rounded-full">
                                Inizia sponsorizzazione
                            </button>
                        </div>

                    </form>
                </div>
            </div><!-- CHIUSURA MODALE SCELTA SPONSOR -->

            <!-- MODALE SUCCESSO -->
            <div class="modal-overlay fixed top-0 right-0 bottom-0 left-0 bg-black/[0.3]" v-if="successMessage" @click="successMessage = false">
                <div class="modal translate-x-[-50%] translate-y-[-50%] fixed top-[20%] left-[50%] mt-[80px] flex flex-col justify-center items-center min-h-[250px] min-w-[250px] rounded-[15px] p-8 text-center bg-white" @click.stop>
                    <div class="messaggioInviato flex flex-col justify-center items-center py-[40px] gap-[15px]">
                        <p>Sponsorizzazione attivata correttamente!</p>
                        <img src="/img/mailSent.png"
                        class="h-[100px] mt-8" 
                        />
                    </div>
                </div>
            </div><!-- CHIUSURA MODALE SUCCESSO -->
        </div>

    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
.remaining-time {
    svg {
        color: $main-color;
    }
}

.my-button {
    &.disabled {
        background-color: grey;
    }
}
.modal {
    .column {
        border-right: 1px solid gray;
    }
    .column:last-child {
        border: none;
    }
}

//loader
.lds-default {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}

.lds-default div {
    position: absolute;
    width: 6px;
    height: 6px;
    background: #fdd;
    border-radius: 50%;
    animation: lds-default 1.2s linear infinite;
}

.lds-default div:nth-child(1) {
    animation-delay: 0s;
    top: 37px;
    left: 66px;
}

.lds-default div:nth-child(2) {
    animation-delay: -0.1s;
    top: 22px;
    left: 62px;
}

.lds-default div:nth-child(3) {
    animation-delay: -0.2s;
    top: 11px;
    left: 52px;
}

.lds-default div:nth-child(4) {
    animation-delay: -0.3s;
    top: 7px;
    left: 37px;
}

.lds-default div:nth-child(5) {
    animation-delay: -0.4s;
    top: 11px;
    left: 22px;
}

.lds-default div:nth-child(6) {
    animation-delay: -0.5s;
    top: 22px;
    left: 11px;
}

.lds-default div:nth-child(7) {
    animation-delay: -0.6s;
    top: 37px;
    left: 7px;
}

.lds-default div:nth-child(8) {
    animation-delay: -0.7s;
    top: 52px;
    left: 11px;
}

.lds-default div:nth-child(9) {
    animation-delay: -0.8s;
    top: 62px;
    left: 22px;
}

.lds-default div:nth-child(10) {
    animation-delay: -0.9s;
    top: 66px;
    left: 37px;
}

.lds-default div:nth-child(11) {
    animation-delay: -1s;
    top: 62px;
    left: 52px;
}

.lds-default div:nth-child(12) {
    animation-delay: -1.1s;
    top: 52px;
    left: 62px;
}

@keyframes lds-default {

    0%,
    20%,
    80%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.5);
    }
}
</style>
