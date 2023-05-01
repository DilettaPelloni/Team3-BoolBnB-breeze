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
                            let month = end_date.getMonth() + 1;
                            let day = end_date.getDate();
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
        <title>Sponsorships</title>
    </Head>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul class="p-6 text-gray-900">
                        <li v-for="apartment in apartments" class="py-5 border-b item flex justify-between items-center">
                            <!-- TITOLO E IMMAGINE -->
                            <div class="flex items-center">
                                <img :src="apartment.full_cover_img_path" alt="apartment_image" class="image-preview">
                                <h4 class="ms-10">
                                    {{ apartment.title }}
                                </h4>
                            </div>

                            <!-- BOTTONE -->
                            <div class="flex flex-col justify-center items-center">
                                <button
                                    class="rounded-full my-button"
                                    :class="{
                                        disabled: !isSponsorized(apartment),
                                    }"
                                    :disabled="!isSponsorized(apartment)"
                                    @click="selectsApartment(apartment)"
                                >
                                    {{ isSponsorized(apartment) ? 'Sponsorizza' : 'Sponsorizzazione attiva' }}
                                </button>
                                <p class="remaining-time" v-if="!isSponsorized(apartment)">
                                    <font-awesome-icon :icon="['fas', 'stopwatch']" />
                                    {{ endDate(apartment) }}
                                </p>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>

            <!-- MODALE SCELTA SPONSOR -->
            <div class="modal-overlay" v-if="modalVisible" @click="modalVisible = false">
                <div class="modal mt-[80px]" @click.stop>
                    <h3>Scegli il tuo piano di sponsorizzazione</h3>
                    <div class="columns-container flex mt-3">
                        <div class="column" v-for="sponsorship in sponsorships">
                            <h4 class="font-bold ">
                                {{ sponsorship.name }}
                            </h4>
                            <div class="price mt-3">
                                <p class="subtitle">Prezzo</p>
                                <p>{{ sponsorship.price.replace(/\./g, ',') }} €</p>
                            </div>
                            <div class="duration mt-3">
                                <p class="subtitle">Durata della sponsorizzazione</p>
                                <p>{{ sponsorship.duration.substring(0, sponsorship.duration.indexOf(":")) }} ore</p>
                            </div>

                            <button class="rounded-full mt-10 my-button" @click="activateSponsorship(sponsorship)">
                                Inizia
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- CHIUSURA MODALE SCELTA SPONSOR -->

            <!-- MODALE PAGAMENTO -->
            <div class="modal-overlay" v-show="payModalVisible" @click="payModalVisible = false">
                <div class="modal mt-[80px]" @click.stop>

                    <form @submit.prevent="sendPayment">

                        <!-- QUA DENTRO SI CREA LA MASCHERA PER IL PAGAMENTO -->
                        <div id="dropin-container"></div>

                        <!-- IN CASO DI ERRORE LO MOSTRO -->
                        <div v-if="error != ''">
                            <p>{{ error }}</p>
                        </div>

                        <!-- ANIMAZIONE DI CARICAMENTO -->
                        <div v-show="!showPaymentButton">
                            <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
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
                                    {{ newActiveSponsorship.selectedSponsor?.duration.substring(0, newActiveSponsorship.selectedSponsor.duration.indexOf(":")) }} ore
                                </strong>
                            </h3>

                            <!-- PULSANTE PER PAGARE -->
                            <button
                                id="submit-button"
                                type="submit"
                                class="button button--small button--coral"
                            >
                                Inizia sponsorizzazione
                            </button>
                        </div>

                    </form>
                </div>
            </div><!-- CHIUSURA MODALE SCELTA SPONSOR -->

            <!-- MODALE SUCCESSO -->
            <div class="modal-overlay" v-if="successMessage" @click="successMessage = false">
                <div class="modal mt-[80px]" @click.stop>
                    <div class="messaggioInviato">
                        <p>Sponsorizzazione attivata correttamente!</p>
                        <img src="/img/mailSent.png"/>
                </div>
                </div>
            </div><!-- CHIUSURA MODALE SUCCESSO -->
        </div>

    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.item {
    border-color: $main-color;
}

.image-preview {
    width: 100px;
    aspect-ratio: 1/1;
    object-fit: cover;
}

.remaining-time {
    svg {
        margin-top: 1rem;
        color: $main-color;
        font-size: 1.5rem;
    }
}

.button {
    cursor: pointer;
    font-weight: 500;
    left: 3px;
    line-height: inherit;
    position: relative;
    text-decoration: none;
    text-align: center;
    border-style: solid;
    border-width: 1px;
    border-radius: 3px;
    display: inline-block;
}

.button--small {
    padding: 10px 20px;
    font-size: 0.875rem;
}

.button--coral {
    outline: none;
    background-color: $main-color;
    border-color: $main-color;
    color: white;
    transition: all 200ms ease;
}

.button--coral:hover {
    background-color: $main-color-light;
    color: white;
}

.my-button {
    padding-block: 0.5rem;
    padding-inline: 0.5rem;
    background-color: $main-color;
    color: white;

    &.disabled {
        background-color: grey;
    }
}

.modal-overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 2rem;
    min-height: 250px;
    min-width: 250px;
    text-align: center;
    border-radius: 15px;
    background-color: #fff;

    .column {
        padding-inline: 1rem;
        border-right: 1px solid gray;

        .subtitle {
            color: $main-color;
        }
    }

    .column:last-child {
        border: none;
    }
}

.messaggioInviato {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 15px;
    padding: 40px 0px;
    img {
        height: 100px;
        margin-top: 2rem;
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
  0%, 20%, 80%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.5);
  }
}

</style>
