<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

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
};
</script>

<template>
    <Head title="Appartamenti" />

    <AuthenticatedLayout>
        <div class="container">
            <Link
                :href="route('gestione-appartamenti.create')"
                class="mt-8 px-4 py-2 rounded-full button text-white"
            >
                Aggiungi un appartamento
            </Link>

            <div class="container-cards grid grid-cols-5 gap-10">
                <div class="card" v-for="apartment in apartments">
                    <Link
                        :href="
                            route('gestione-appartamenti.show', apartment.id)
                        "
                        class="flex flex-col h-full"
                    >
                        <img
                            :src="apartment.full_cover_img_path"
                            alt="immagine casa"
                        />
                        <div
                            class="card-info p-4 grow flex flex-col justify-center"
                        >
                            <span
                                ><b>{{ apartment.title }}</b></span
                            >
                            <div class="mt-2 grow flex items-center">
                                <font-awesome-icon
                                    :icon="['fas', 'location-dot']"
                                    class="me-2"
                                />
                                {{ apartment.address }}
                            </div>
                            <div class="mt-2 mb-4">
                                <font-awesome-icon
                                    :icon="['fas', 'maximize']"
                                />
                                {{ apartment.size }} m<sup>2</sup>
                            </div>
                        </div>
                        <!-- CHIUSURA CARD INFO -->
                        <div class="button-box px-4 pb-8 text-center">
                            <Link
                                :href="
                                    route(
                                        'gestione-appartamenti.edit',
                                        apartment.id
                                    )
                                "
                                class="mt-4 px-4 py-2 rounded-full button text-white"
                            >
                                Modifica
                            </Link>
                        </div>
                        <!-- CHIUSURA NUTTON BOX -->
                    </Link>
                </div>
                <!-- CHIUSURA CARD -->
            </div>
            <!-- CHIUSURA CONTAINER CARDS -->
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
.button {
    background-color: $main-color;
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

.card:hover {
    @apply hover:shadow-lg;
    @apply hover:shadow-lg hover:scale-105;
}
</style>
