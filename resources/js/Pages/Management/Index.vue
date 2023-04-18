<script>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import { Link } from '@inertiajs/vue3';


	export default {
		name:'Index',
    props: {
        apartments: Array,
    },
    components: {
      Head,
      AuthenticatedLayout,
      Link
    }

	}
</script>

<template>
    <Head title="Appartamenti" />

    <AuthenticatedLayout>
        <div class="container-cards grid grid-cols-5 gap-10">
           
            <div class="card" v-for="apartment in apartments">
              <Link :href="route('gestione-appartamenti.show', apartment.id)" class="flex flex-col h-full">
                <img :src="'storage/apartments/' + apartment.cover_img" alt="immagine casa">
                <div class="card-info p-4 grow flex flex-col justify-center">
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
            </div><!-- CHIUSURA CARD -->
         
        </div>
    </AuthenticatedLayout>
  </template>

<style scoped lang="scss">
  .container-cards {
    width: 90%;
    margin: 0 auto;
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
