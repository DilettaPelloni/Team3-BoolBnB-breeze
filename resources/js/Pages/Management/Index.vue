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
            modalVisible: false,
            apartmentToDelete: null,
            deleteApartment: useForm({}),
        };
    },
    methods: {
        toggleModal(apartmentId) {
            if (this.modalVisible == false) {
                this.modalVisible = true;
                this.apartmentToDelete = apartmentId;
            } else {
                this.modalVisible = false;
                this.apartmentToDelete = null;
            }
        }, //toggleModal
        deleteElement() {
            this.deleteApartment.delete(
                route("gestione-appartamenti.destroy", this.apartmentToDelete)
            );
            this.modalVisible = false;
        },
    },
};
</script>

<template>
    <Head>
        <title>
            Appartamenti - BoolBnB
        </title>
        <link rel="icon" href="/favicon.svg" />
    </Head>

    <AuthenticatedLayout>
        <div class="container pb-[135px]">
            <div class="text-center md:text-start">
                <Link :href="route('gestione-appartamenti.create')"
                    class="btn-add rounded-full text-white py-[11px] px-[20px] border-hidden bg-mainColor-300 cursor-pointer mt-[40px] hover:bg-[#fd4e4e]">
                Aggiungi un appartamento
                </Link>
            </div>

            <div class="container-cards pt-[50px] grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10">
                <div class="card flex flex-col bg-white rounded-[15px] overflow-hidden transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105"
                    v-for="apartment in apartments">
                    <Link :href="route('gestione-appartamenti.show', apartment.id)
                        " class="grow flex flex-col">
                    <!-- IMMAGINE -->
                    <img :src="apartment.full_cover_img_path" alt="immagine casa"
                        class="mb-4 aspect-square w-full object-cover" />
                    <!-- CARD INFO -->
                    <div class="card-info p-4 grow flex flex-col">
                        <span><b>{{ apartment.title }}</b></span>
                        <div class="mt-2 grow flex items-start">
                            <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2 mt-1 text-mainColor-300" />
                            {{ apartment.address }}
                        </div>
                        <div class="mt-2">
                            <font-awesome-icon :icon="['fas', 'maximize']" class="me-2 text-mainColor-300" />
                            {{ apartment.size }} m<sup>2</sup>
                        </div>
                    </div>
                    <!-- CHIUSURA CARD INFO -->
                    </Link>

                    <div class="button-box text-center flex justify-around mb-[20px]">
                        <Link :href="route(
                            'gestione-appartamenti.edit',
                            apartment.id
                        )
                            "
                            class="mt-8 px-4 py-2 rounded-full button bg-mainColor-300 text-white hover:bg-[#fd4e4e]">
                        <font-awesome-icon :icon="['far', 'pen-to-square']" />
                        Modifica
                        </Link>
                        <button class="button bg-mainColor-300 rounded-full text-white px-4 mt-8 hover:bg-[#fd4e4e]"
                            @click="toggleModal(apartment.id)">
                            <font-awesome-icon :icon="['far', 'trash-can']" />
                            Cancella
                        </button>
                    </div>
                    <!-- CHIUSURA BUTTON BOX -->
                </div>
                <!-- CHIUSURA CARD -->
            </div>
            <!-- CHIUSURA CONTAINER CARDS -->

            <!-- MODALE -->
            <div class="modal-overlay fixed top-0 bottom-0 right-0 left-0 bg-black/[0.7]" v-if="modalVisible">
                <div
                    class="modal mt-[180px] flex flex-col justify-center items-center fixed top-[20%] left-[50%] translate-x-[-50%] translate-y-[-50%] p-8 min-h-[250px] min-w-[280px] text-center rounded-[15px] bg-white">
                    <img src="img/cancella.png" alt="imgCancella" class="object-contain w-48 mb-[25px]" />
                    <h3>Sei sicuro di voler eliminare questo appartamento?</h3>
                    <div
                        class="form-button-container flex justify-between xl:gap-4 lg:gap-0 md:gap-0 sm:gap-0 md:flex-row flex-col">
                        <form @submit.prevent="deleteElement">
                            <button type="submit"
                                class="mt-8 sm:mr-4 px-4 py-2 rounded-full button bg-mainColor-300 text-white">
                                Si, sono sicuro!
                            </button>
                        </form>
                        <button
                            class="mt-8 px-4 py-2 rounded-full text-mainColor-300 bg-white border-[3px] border-mainColor-300 inline"
                            @click="toggleModal('')">
                            No, ci ho ripensato!
                        </button>
                    </div>
                </div>
            </div>
            <!-- CHIUSURA MODALE -->
        </div>
        <!-- CHIUSURA CONTAINER -->
    </AuthenticatedLayout>
</template>

<style scoped></style>
