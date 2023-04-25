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
                sender_name: null,
            }),
            okMessage: false,
        };
    }, //data
    methods: {
        submit() {
            this.newMessage.post(route("messages.store"), {
                onSuccess: () => (this.okMessage = true),
            });
            this.newMessage.reset();
        }, //submit
    },
};
</script>

<template>
    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

    <Head :title="apartment.title" />
    <div class="main-container">
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
                class="w-full h-full object-cover max-h-[900px] object-center"
            />
        </div>
        <div class="container-info-msg flex justify-between mt-20 mb-[65px]">
            <div
                class="container-info flex flex-col justify-between border-b-2"
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
                <div v-else>
                    <span>Nessun Servizio Aggiuntivo Disponibile</span>
                </div>
                <div class="border-y-2 py-5">
                    <div>
                        <h2>Descrizione Appartamento</h2>
                        <p class="pt-3 text-gray-600">
                            {{ apartment.description }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="container-msg">
                <h2>Manda un messaggio</h2>
                <p class="text-sm pb-5">*tutti i campi sono obbligatori</p>
                <!-- FORM  -->
                <form @submit.prevent="submit">
                    <!-- SENDER NAME  -->
                    <p><label for="sender_name">Nome e Cognome</label></p>
                    <input
                        type="text"
                        name="sender_name"
                        id="sender_name"
                        class="my-4"
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
                        type="text"
                        name="sender_email"
                        id="sender_email"
                        class="my-4"
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
                    <input
                        type="text"
                        name="content"
                        id="content"
                        class="my-4"
                        v-model="newMessage.content"
                    />
                    <div
                        v-if="newMessage.errors.content"
                        class="text-red-500 text-xs italic"
                    >
                        {{ newMessage.errors.content }}
                    </div>
                    <!-- BOTTONE -->
                    <button type="submit" class="button px-4 py-2">
                        Invia il messaggio
                    </button>
                    <!-- MESSAGGIO OK -->
                    <div class="messaggioInviato" v-if="okMessage">
                        <p>Il tuo messaggio è stato inviato correttamente!</p>
                        <img src="img/mailSent.png" />
                    </div>
                </form>
            </div>
        </div>
        <TomTomMap :apartment="apartment" />
    </div>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.messaggioInviato {
    display: flex;
    gap: 15px;
    padding: 40px 0px;
}

.main-container {
    width: 65%;
    margin: 60px auto;

    .container-info {
        width: 65%;
    }

    .container-msg {
        width: 30%;

        input {
            width: 100%;
        }

        button {
            background-color: $main-color;
        }
    }
}

h1 {
    font-size: 2rem;
}

h2 {
    font-size: 1.8rem;
}

span {
    color: rgb(75, 85, 99);
}

input {
    border-radius: 50px;
}

/* bottone */
button {
    padding: 11px 20px;
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
    background-color: #df5759;
}

button:active {
    background-color: #fc9aa1 !important;
    box-shadow: 0 5px #dd5b5f;
    transform: translateY(4px);
}
</style>
