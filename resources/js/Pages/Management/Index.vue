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
                <Link
                :href="route('gestione-appartamenti.create')"
                class="btn-add rounded-full text-white"
            >
                Aggiungi un appartamento
            </Link>
            </div>

            <div
                class="container-cards grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10"
            >
                <div
                    class="card flex flex-col"
                    v-for="apartment in apartments"
                >
                    <Link
                        :href="
                            route('gestione-appartamenti.show', apartment.id)
                        "
                        class="grow flex flex-col"
                    >
                        <!-- IMMAGINE -->
                        <img
                            :src="apartment.full_cover_img_path"
                            alt="immagine casa"
                            class="mb-4"
                        />
                        <!-- CARD INFO -->
                        <div
                            class="card-info p-4 grow flex flex-col"
                        >
                            <span
                                ><b>{{ apartment.title }}</b></span
                            >
                            <div class="mt-2 grow flex items-start">
                                <font-awesome-icon
                                    :icon="['fas', 'location-dot']"
                                    class="me-2 mt-1 text-mainColor-300"
                                />
                                {{ apartment.address }}
                            </div>
                            <div class="mt-2">
                                <font-awesome-icon
                                    :icon="['fas', 'maximize']"
                                    class="me-2 text-mainColor-300"
                                />
                                {{ apartment.size }} m<sup>2</sup>
                            </div>
                        </div>
                        <!-- CHIUSURA CARD INFO -->
                    </Link>

                    <div
                        class="button-box text-center flex justify-around mb-[20px]"
                    >
                        <Link
                            :href="
                                route(
                                    'gestione-appartamenti.edit',
                                    apartment.id
                                )
                            "
                            class="mt-8 px-4 py-2 rounded-full button text-white"
                        >
                            <font-awesome-icon
                                :icon="['far', 'pen-to-square']"
                            />
                            Modifica
                        </Link>
                        <button
                            class="button rounded-full text-white px-4 mt-8"
                            @click="toggleModal(apartment.id)"
                        >
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
            <div class="modal-overlay" v-if="modalVisible">
                <div class="modal mt-[80px]">
                    <img
                        src="img/cancella.png"
                        alt="imgCancella"
                        class="object-contain w-48 mb-[25px]"
                    />
                    <h3>Sei sicuro di voler eliminare questo appartamento?</h3>
                    <div
                        class="form-button-container flex justify-between xl:gap-4 lg:gap-0 md:gap-0 sm:gap-0 md:flex-row flex-col"
                    >
                        <form @submit.prevent="deleteElement">
                            <button
                                type="submit"
                                class="mt-8 sm:mr-4 px-4 py-2 rounded-full button text-white border-color-pink"
                            >
                                Si, sono sicuro!
                            </button>
                        </form>
                        <button
                            class="mt-8 px-4 py-2 rounded-full inverted-button text-white inline"
                            @click="toggleModal('')"
                        >
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

<style scoped lang="scss">
@import "../../../scss/app.scss";
.border-color-pink {
    border: 3px solid $main-color;
}

.inverted-button {
    background-color: white;
    color: $main-color;
    border: 3px solid $main-color;
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

/* bottone */
.btn-add {
    padding: 11px 20px;
    border-radius: 50px;
    border: none;
    background-color: $main-color;
    color: #fff;
    font-family: "Figtree";
    font-size: 17px;
    cursor: pointer;
    margin-top: 40px;
}

.btn-add:hover {
    background-color: #fd4e4e;
}

.btn-add:active {
    background-color: #fc9aa1 !important;
    box-shadow: 0 5px #dd5b5f;
    transform: translateY(4px);
}

.button:hover {
    background-color: #fd4e4e;
}
</style>
