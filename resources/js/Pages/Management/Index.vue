<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { useForm } from "@inertiajs/vue3";


export default {
    name:'Index',
    props: {
        apartments: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Link
    },
    data() {
        return {
            modalVisible: false,
            apartmentToDelete: null,
            deleteApartment: useForm({})
        }
    },
    methods: {
        toggleModal(apartmentId){
            if(this.modalVisible == false){
                this.modalVisible = true;
                this.apartmentToDelete = apartmentId;
            }
            else {
                this.modalVisible = false;
                this.apartmentToDelete = null;
            }
        },//toggleModal
        deleteElement() {
            this.deleteApartment.delete(route("gestione-appartamenti.destroy", this.apartmentToDelete));
            this.modalVisible = false;
        }
    },  
}
</script>

<template>
    <Head title="Appartamenti" />

    <AuthenticatedLayout>
        <div class="container">

        <Link :href="route('gestione-appartamenti.create')" class="mt-8 px-4 py-2 rounded-full button text-white">
            Aggiungi un appartamento
        </Link>

        <div class="container-cards grid grid-cols-5 gap-10">
            <div class="card" v-for="apartment in apartments">

                <Link :href="route('gestione-appartamenti.show', apartment.id)" class="flex flex-col">
                    <!-- IMMAGINE -->
                    <img :src="apartment.full_cover_img_path" alt="immagine casa">
                    <!-- CARD INFO -->
                    <div class="card-info px-4 pt-4 flex flex-col justify-center">
                        <span><b>{{ apartment.title }}</b></span>
                        <div class="mt-2 grow flex items-center ">
                            <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2"/>
                            {{ apartment.address }}
                        </div>
                        <div class="mt-2">
                            <font-awesome-icon :icon="['fas', 'maximize']" />
                            {{ apartment.size }} m<sup>2</sup>
                        </div>
                    </div><!-- CHIUSURA CARD INFO -->
                </Link>

                <div class="button-box text-center">
                    <Link :href="route('gestione-appartamenti.edit', apartment.id)" class="mt-8 px-4 py-2 rounded-full button text-white">
                        Modifica
                    </Link>
                    <button class="button rounded-full text-white px-4 py-2 mt-8" @click="toggleModal(apartment.id)">
                        <font-awesome-icon :icon="['far', 'trash-can']" />
                    </button>
                </div><!-- CHIUSURA BUTTON BOX -->
            </div><!-- CHIUSURA CARD -->
        </div><!-- CHIUSURA CONTAINER CARDS -->

        <!-- MODALE -->
        <div class="modal-overlay" v-if="modalVisible">
            <div class="modal">
                <h3>Sei sicuro di voler eliminare questo appartamento?</h3>
                <form @submit.prevent="deleteElement">
                    <button type="submit" class="mt-8 px-4 py-2 rounded-full button text-white">
                        Si, sono sicuro!
                    </button>
                </form>
                <button class="mt-8 px-4 py-2 rounded-full inverted-button text-white inline" @click="toggleModal('')">
                    No, ci ho ripensato!
                </button>
            </div>
        </div><!-- CHIUSURA MODALE -->

      </div><!-- CHIUSURA CONTAINER -->
      
    </AuthenticatedLayout>
  </template>

<style scoped lang="scss"> 
  @import '../../../scss/app.scss';
  .button {
    background-color: $main-color;
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
    width: 30%;
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

      img {
          aspect-ratio: 1/1;
          width: 100%;
          object-fit: cover;
        }
    }
</style>
