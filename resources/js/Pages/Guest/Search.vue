<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    name: "Index",
    props: {
        apartments: Array,
        services: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Link,
    },
    data() {
        return {
            rooms: 1,
            beds: 1,
            bathrooms: 1,
            activeServices: [],
        };
    },
    methods: {
        toggleService(serviceId) {
            if (this.activeServices.includes(serviceId)) {
                this.activeServices.splice(this.activeServices.indexOf(serviceId), 1);
            } else {
                this.activeServices.push(serviceId);
            }
        }, //toggleService
    },
    computed: {
        showApartments() {
            let apartments = this.apartments;
            apartments = apartments.filter(apartment => apartment.rooms >= this.rooms);
            apartments = apartments.filter(apartment => apartment.beds >= this.beds);
            apartments = apartments.filter(apartment => apartment.bathrooms >= this.bathrooms);

            if (this.activeServices.length > 0) {
                apartments = apartments.filter((apartment)=> {
                    let flag = true;

                    let servicesIds = [];

                    apartment.services.forEach((service) => servicesIds.push(service.id));

                    this.activeServices.forEach((service) => {
                        if(!servicesIds.includes(service)) { flag = false }
                    });//forEach
                    return flag;
                })
            }
            return apartments;
        },//showApartments
    }
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
                <!-- RAGGIO DI RICERCA -->
                <div class="flex flex-col w-1/3">
                    <label class="mb-2">Definisci il raggio di ricerca (km)</label>
                    <input type="range" min="1" max="100" value="20" class="slider" id="myRange">
                </div>
                <!-- ROOMS BATHROOMS BEDS -->
                <div class="flex justify-center my-10">
                    <!-- SCATOLA -->
                    <div class="flex flex-wrap gap-10">
                        <!-- ROOMS -->
                        <div class="flex flex-col w-1/3">
                            <label class="mb-2">Filtro per numero di stanze</label>
                            <select class="rounded-full py-2 px-4 w-full" v-model="rooms">
                                <option v-for="i in 10" :value="i">{{ i }}</option>
                            </select>
                        </div>
                        <!-- BEDS -->
                        <div class="flex flex-col w-1/3">
                            <label class="mb-2">Filtro per numero di letti</label>
                            <select class="rounded-full py-2 px-4 w-full" v-model="beds">
                                <option v-for="i in 10" :value="i">{{ i }}</option>
                            </select>
                        </div>
                        <!-- BATHROOMS -->
                        <div class="flex flex-col w-1/3">
                            <label class="mb-2">Filtro per numero di bagni</label>
                            <select class="rounded-full py-2 px-4 w-full" v-model="bathrooms">
                                <option v-for="i in 4" :value="i">{{ i }}</option>
                            </select>
                        </div>
                    </div><!-- CHIUSURA SCATOLA -->
                </div><!-- CHIUSURA ROOMS BATHROOMS BEDS -->
                <!-- SERVIZI -->
                <div class="mb-3 pt-[45px]">
                    <p class="block pb-2 font-medium text-gray-700 text-lg">
                        Servizi offerti
                    </p>
                    {{ activeServices }}
                    <div class="flex flex-wrap">
                        <template v-for="service in services">
                            <label :for="service.id" class="mr-2">
                                <span class="inline-block font-bold">{{
                                    service.name
                                }}</span>
                                {{ service.icon }}
                            </label>
                            <input
                                type="checkbox"
                                :id="service.id"
                                :name="service.id"
                                :value="service.id"
                                class="mx-2"
                                @click="toggleService(service.id)"
                            />
                        </template>
                    </div>
                </div> <!-- CHIUSURA SERVIZI -->
            </div><!-- CHIUSURA CAMPI RICERCA -->




            <div class="container-cards grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 sm:grid-col-1 gap-10">
                <div class="card flex flex-col self-end" v-for="apartment in showApartments">
                    <Link :href="route('gestione-appartamenti.show', apartment.id)
                        " class="flex flex-col">
                    <!-- IMMAGINE -->
                    <img :src="apartment.full_cover_img_path" alt="immagine casa" />
                    <!-- CARD INFO -->
                    <div class="card-info px-4 pt-4 flex flex-col justify-center ">
                        <span><b>{{ apartment.title }}</b></span>
                        <div class="mt-2 grow flex items-center">
                            <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2" />
                            {{ apartment.address }}
                        </div>
                        <div class="mt-2">
                            <font-awesome-icon :icon="['fas', 'maximize']" />
                            {{ apartment.size }} m<sup>2</sup>
                        </div>
                        {{ apartment.rooms }}
                        {{ apartment.beds }}
                        {{ apartment.bathrooms }}
                        <ul>
                            <li v-for="service in apartment.services">
                                {{ service.name }}
                            </li>
                        </ul>
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
