<script>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AppHeader from '../../Components/MyComponents/AppHeader.vue';
import AppFooter from '../../Components/MyComponents/AppFooter.vue';


export default {
  name: 'Show',
  props: {
    apartment: Object,
    canLogin: Boolean,
    canRegister: Boolean,
  },
  components: {
    Head,
    Link,
    AppHeader,
    AppFooter,
  }
}
</script>

<template>
    <Head :title="apartment.title" />
    <!-- APPHEADER -->
    <AppHeader :canLogin="canLogin" :canRegister="canRegister"/>

    <!-- CARD CONTAINER -->
    <div class="container-cards grid grid-cols-5 gap-10">

        <!-- CARD -->
        <div class="card">
            <img :src="apartment.full_cover_img_path">
            <div class="card-info p-4 grow flex flex-col justify-center">
                <span><b>{{ apartment.title }}</b></span>
                <div class="mt-2 grow flex items-center ">
                    <font-awesome-icon :icon="['fas', 'location-dot']" class="me-2" />
                    {{ apartment.address }}
                </div>
                <div class="mt-2">
                    <font-awesome-icon :icon="['fas', 'maximize']" />
                    {{ apartment.size }} m<sup>2</sup>
                </div>
            </div><!-- CHIUSURA CARD INFO -->
        </div><!-- CHIUSURA CARD -->

    </div><!-- CHIUSURA CARD CONTAINER-->
    
    <!-- APP FOOTER -->
    <AppFooter />

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
