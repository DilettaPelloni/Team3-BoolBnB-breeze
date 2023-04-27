<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";


export default {
    name: "Sponsoship",
    props: {
        sponsorships: Array,
        apartments: Array,
        activeSponsorships: Array,
        lastSponsorship: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
    },
    data() {
        return {
            modalVisible: false,
            payModalVisible: false,
            selectedApartment: null,
        };
    },
    methods: {
        isSponsorized (apartment) {
            //di base ritorno vero
            let flag = true;
            //prendo la data di oggi
            const today = new Date();
            //se ci sono sponsorships attive sugli appartamenti di questo utente
            if(this.activeSponsorships.length > 0) {
                //per ogni sponsorship attiva
                this.activeSponsorships.forEach((sponsorship) => {
                    //vedo se è relativa all'appartamento che sto esaminando
                    if(sponsorship.apartment_id == apartment.id) {
                        //trasformo la sua data di fine in un ogetto Date
                        let end_date = new Date(sponsorship.end_date);
                        //se la data di fine è maggiore della data di oggi ritorno falso
                        if(end_date > today) {
                            flag = false;
                        }
                    }
                });
            }
            return flag;
        }, //isSponsorized
        selectsApartment(apartment) {
            this.selectedApartment = apartment.id;
            this.modalVisible = true;
        },//selectsApartment
        activateSponsorship() {
            this.modalVisible = false;
            this.payModalVisible = true;

            let button = document.querySelector('#submit-button');

            braintree.dropin.create({
                authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
                selector: '#dropin-container'
            },
            function (err, instance) {
                button.addEventListener('click', function () {
                    instance.requestPaymentMethod(function (err, payload) {
                        // Submit payload.nonce to your server
                        console.log(err);
                    });
                    console.log('pago');
                })
            });
        },//activateSponsorship
        endDate(apartment) {
            
            return '12/05/2022';
        }
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
        
        {{ lastSponsorship }}
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <ul class="p-6 text-gray-900">
                        <li
                            v-for="apartment in apartments"
                            class="py-5 border-b item flex justify-between items-center"
                        >   
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
                                    {{ isSponsorized(apartment) ? 'Sponsorizza' : 'Sponsorizzazione attiva'}}
                                </button>
                                <p  
                                    class="remaining-time"
                                    v-if="!isSponsorized(apartment)"
                                >
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
                <div class="modal mt-[80px]">
                    <h3>Scegli il tuo piano di sponsorizzazione</h3>
                    <div class="columns-container flex mt-3" >
                        <div
                            class="column"
                            v-for="sponsorship in sponsorships"
                        >
                            <h4 class="font-bold ">
                                {{ sponsorship.name }}
                            </h4>
                            <div class="price mt-3">
                                <p class="subtitle">Prezzo</p>
                                <p>{{ sponsorship.price.replace(/\./g, ',')  }} €</p>
                            </div>
                            <div class="duration mt-3">
                                <p class="subtitle">Durata della sponsorizzazione</p>
                                <p>{{ sponsorship.duration.substring(0, sponsorship.duration.indexOf(":")) }} ore</p>
                            </div>

                            <button
                                class="rounded-full mt-10 my-button"
                                @click="activateSponsorship(sponsorship)"
                            >
                                Inizia
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- CHIUSURA MODALE SCELTA SPONSOR -->

            <!-- MODALE PAGAMENTO -->
            <div class="modal-overlay" v-show="payModalVisible" @click="payModalVisible = false">
                <div class="modal mt-[80px]">
                    <h3>Sono il modale per i pagamenti</h3>
                    <div id="dropin-container"></div>
                    <button id="submit-button" class="button button--small button--green">Purchase</button>
                </div>
            </div><!-- CHIUSURA MODALE SCELTA SPONSOR -->
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
  -webkit-appearance: none;
  -moz-appearance: none;
  display: inline-block;
}

.button--small {
  padding: 10px 20px;
  font-size: 0.875rem;
}

.button--green {
  outline: none;
  background-color: #64d18a;
  border-color: #64d18a;
  color: white;
  transition: all 200ms ease;
}

.button--green:hover {
  background-color: #8bdda8;
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

</style>
