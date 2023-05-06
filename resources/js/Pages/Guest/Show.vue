<script>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import AppHeader from "../../Components/MyComponents/AppHeader.vue";
import TomTomMap from "@/Components/MyComponents/TomTomMap.vue";

export default {
    name: "Show",
    props: {
        apartment: Object,
        canLogin: Boolean,
        canRegister: Boolean,
        user_email: String,
        user_name: String,
    },
    components: {
        Head,
        Link,
        AppHeader,
        TomTomMap,
    },
    data() {
        return {
            newMessage: useForm({
                apartmentId: this.apartment.id,
                content: null,
                sender_email: this.user_email,
                sender_name: this.user_name,
            }),
            modalVisible: false,
        };
    }, //data
    methods: {
        submit() {
            this.newMessage.post(route("messages.store"), {
                onSuccess: () => (this.modalVisible = true),
            });
            this.newMessage.reset();
        }, //submit
    },
};
</script>

<template>
    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

    <Head>
        <title>
            {{ apartment.title }}
        </title>
        <link rel="icon" href="/favicon.svg" />
    </Head>
    <div class="main-container my-[60px] mx-auto w-[80%] lg:w-[65%]">
        <div class="container-title mb-[50px]">
            <h1 class="pb-2">
                {{ apartment.title }}
            </h1>
            <span>
                <font-awesome-icon
                    :icon="['fas', 'location-dot']"
                    style="color: #fe5b5f"
                />
                {{ apartment.address }}
            </span>
        </div>
        <div class="container-img w-full">
            <img
                :src="apartment.full_cover_img_path"
                alt="Cover Image Apartment"
                class="w-full h-full object-cover max-h-[900px] object-center rounded-[7.5px]"
            />
        </div>
        <div class="container-info-msg flex flex-col md:flex-row justify-between mt-20 mb-[65px]">
            <div
                class="container-info flex flex-col justify-between border-b-2 w-[100%] md:w-[65%]"
            >
                <div class="border-b-2 pb-5">
                    <h2 class="pb-2">
                        {{ apartment.title }}
                    </h2>
                    <span>{{ apartment.rooms }} Stanze &bull; </span>
                    <span>{{ apartment.beds }} Letti &bull; </span>
                    <span>{{ apartment.bathrooms }} Bagni &bull; </span>
                    <span>{{ apartment.size }} M<sup>2</sup></span>
                </div>
                <div v-if="apartment.services.length > 0">
                    <h2 class="pt-5">Servizi inclusi</h2>
                    <div class="grid grid-rows-5 grid-flow-col">
                        <div v-for="service in apartment.services" class="py-3">
                            <span
                                ><font-awesome-icon
                                    :icon="['fas', service.icon]"
                                    style="
                                        color: rgb(254 91 95 / 78%);
                                        padding-right: 9px;
                                        height: 25px;
                                    "
                            /></span>
                            <span>{{ service.name }}</span>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <span>Nessun Servizio Aggiuntivo Disponibile</span>
                </div>
                <div class="border-t-2 py-5">
                    <div>
                        <h2>Descrizione Appartamento</h2>
                        <p class="pt-3 text-gray-600">
                            {{ apartment.description }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="container-msg w-[100%] md:w-[30%] mt-8 md:mt-0">
                <h2>Manda un messaggio</h2>
                <p class="text-sm pb-5">*tutti i campi sono obbligatori</p>
                <!-- FORM  -->
                <form @submit.prevent="submit">
                    <!-- SENDER NAME  -->
                    <p><label for="sender_name">Nome e Cognome</label></p>
                    <input
                        required
                        type="text"
                        name="sender_name"
                        id="sender_name"
                        class="my-4 w-full rounded-full"
                        v-model="newMessage.sender_name"
                    />
                    <div
                        v-if="newMessage.errors.sender_name"
                        class="text-red-500 text-xs italic"
                    >
                        {{ newMessage.errors.sender_name }}
                    </div>
                    <!-- SENDER EMAIL  -->
                    <p><label for="sender_email">La tua E-Mail</label></p>
                    <input
                        required
                        type="text"
                        name="sender_email"
                        id="sender_email"
                        class="my-4 w-full rounded-full"
                        v-model="newMessage.sender_email"
                    />
                    <div
                        v-if="newMessage.errors.sender_email"
                        class="text-red-500 text-xs italic"
                    >
                        {{ newMessage.errors.sender_email }}
                    </div>
                    <!-- CONTENT  -->
                    <p><label for="content">Messaggio</label></p>
                    <textarea
                        name="content"
                        id="content"
                        cols="5"
                        rows="10"
                        class="my-4 min-w-full min-h-[100px] max-h-[200px] rounded-[25px]"
                        required
                        v-model="newMessage.content"
                    ></textarea>
                    <div
                        v-if="newMessage.errors.content"
                        class="text-red-500 text-xs italic"
                    >
                        {{ newMessage.errors.content }}
                    </div>
                    <!-- BOTTONE -->
                    <button type="submit" class="button mt-[40px] px-4 py-2 rounded-full text-white text-lg cursor-pointer bg-mainColor-300 hover:bg-[#df5759]">
                        Invia il messaggio
                    </button>
                    
                </form>
            </div>
        </div>
        <TomTomMap :apartment="apartment" />
        <!-- MODALE SUCCESSO MESSAGGIO -->
        <div class="modal-overlay fixed top-0 bottom-0 right-0 left-0 bg-black/[0.7]" v-show="modalVisible" @click="modalVisible = false">
            <div class="modal mt-[80px] flex flex-col justify-center items-center fixed top-[20%] left-[50%] translate-x-[-50%] translate-y-[-50%] p-8 min-h-[250px] text-center rounded-[15px] bg-white">
                <!-- MESSAGGIO OK -->
                <div class="messaggioInviato flex flex-col justify-center items-center gap-[15px] py-[40px]">
                    <p>Messaggio inviato correttamente!</p>
                    <img src="/img/mailSent.png" class="h-[100px] mt-8"/>
                </div>
            </div>
        </div><!-- CHIUSURA MODALE SUCCESSO MESSAGGIO -->
    </div>
</template>

<style scoped>
h1 {
    font-size: 2rem;
}

h2 {
    font-size: 1.8rem;
}

span {
    color: rgb(75, 85, 99);
}
</style>
