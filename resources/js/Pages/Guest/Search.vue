<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    name: "Index",
    props: {
        apartments: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Link,
    },
    data() {
        return {

        };
    },
    methods: {

    },
};
</script>

<template>
    <Head title="Appartamenti" />

    <AuthenticatedLayout>
        <div class="container">



            <!-- crea una search bar per filtrare gli appartamenti -->
            <div class="flex justify-center my-10">
                <form class="w-1/2">
                    <input type="text" class="rounded-full py-2 px-4 w-full" placeholder="Cerca appartamento" />
                    <button type="submit" class="hidden" />
                </form>
            </div>

            <!-- crea una colonna laterale con i filtri all'interno -->
            <div class="flex flex-wrap gap-10">
                <div class="flex flex-col w-1/3">
                    <label class="mb-2">Definisci il raggio di ricerca (km)</label>
                    <input type="range" min="1" max="100" value="20" class="slider" id="myRange">
                </div>

                <div class="flex justify-center my-10">
                    <div class="flex flex-wrap gap-10">
                        <div class="flex flex-col w-1/3">
                            <label class="mb-2">Filtro per numero di stanze</label>
                            <select class="rounded-full py-2 px-4 w-full">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="flex flex-col w-1/3">
                            <label class="mb-2">Filtro per numero di letti</label>
                            <select class="rounded-full py-2 px-4 w-full">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="flex flex-col w-1/3">
                            <label class="mb-2">Filtro per numero di bagni</label>
                            <select class="rounded-full py-2 px-4 w-full">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>




            <div class="container-cards grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10">
                <div class="card flex flex-col self-end" v-for="apartment in apartments">
                    <Link :href="route('gestione-appartamenti.show', apartment.id)
                        " class="flex flex-col">
                    <!-- IMMAGINE -->
                    <img :src="apartment.full_cover_img_path" alt="immagine casa" />
                    <!-- CARD INFO -->
                    <div class="card-info px-4 pt-4 flex flex-col justify-center h-40">
                        <span><b>{{ apartment.title }}</b></span>
                        <div class="mt-2 grow flex items-center">
                            <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2" />
                            {{ apartment.address }}
                        </div>
                        <div class="mt-2">
                            <font-awesome-icon :icon="['fas', 'maximize']" />
                            {{ apartment.size }} m<sup>2</sup>
                        </div>
                    </div>
                    <!-- CHIUSURA CARD INFO -->
                    </Link>


                </div>
                <!-- CHIUSURA CARD -->
            </div>
            <!-- CHIUSURA CONTAINER CARDS -->


        </div>
        <!-- CHIUSURA CONTAINER -->
    </AuthenticatedLayout>
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
