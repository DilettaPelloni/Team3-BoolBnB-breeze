<script>
import AppHeader from "../Components/MyComponents/AppHeader.vue";
import AppFooter from "../Components/MyComponents/AppFooter.vue";
import Jumbotron from "../Components/MyComponents/Jumbotron.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

export default {
    name: "App",
    components: {
        AppHeader,
        Jumbotron,
        AppFooter,
        Link,
        Head,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        apartments: Array,
    },
};
</script>

<template>
    <Head title="Home" />

    <AppHeader :canLogin="canLogin" :canRegister="canRegister" />
    <Jumbotron />
    <div class="container-main pb-[95px]">

        <div class="content pt-16 pb-10 text-center text-4xl font-bold text-mainColor-300">
            <h2>Destinazioni suggerite:</h2>
        </div><!-- CHIUSURA CONTENT -->
        <div
                class="container-cards justify-items-center 2xl:mx-[160px] md:mx-[100px] grid 2xl:grid-cols-5 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10"
            >

                <div
                    v-for="apartment in apartments"
                    class="card flex flex-col"
                >
                    <div class="w-full">
                        <img
                            :src="apartment.full_cover_img_path"
                            alt="immagine casa"
                        />
                    </div>
                    <!-- CARD INFO -->
                    <div
                        class="card-info p-4 grow flex flex-col"
                    >   
                        <!-- TITOLO -->
                        <div>
                            <strong> {{ apartment.title }} </strong>
                        </div>
                        <!-- INDIRIZZO -->
                        <div class="mt-2 grow flex items-start">
                            <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2 mt-1" />
                            {{ apartment.address }}
                        </div>
                    </div>
                    <!-- BOTTONE -->
                    <div class="text-center mb-5">
                        <Link
                            :href="route('guest_show', apartment.title_slug)"
                            class="mt-8 px-4 py-2 rounded-full button text-white mb-[20px]"
                        >
                            Vedi appartamento
                        </Link>
                    </div>

                </div>
            </div><!-- CHIUSURA CARD CONTAINER -->
    </div><!-- CHIUSURA CONTAINER -->
    <AppFooter />
</template>

<style scoped lang="scss">
@import "../../scss/app.scss";
.button {
    background-color: $main-color;
}

.button:hover {
    background-color: #fd4e4e;
}
.content {
    margin: 0 auto;
    max-width: 1200px;
}
.container-main {
    background-color: #f1f1f1;
    .card {
        background-color: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        width: 274px;

        img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
        }
    }
}
.card:hover {
    @apply hover:shadow-lg;
    @apply hover:shadow-lg hover:scale-105;
}
</style>
