<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TomTomMap from '@/Components/MyComponents/TomTomMap.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

export default {
  name: 'Show',
  props: {
    apartment: Object,
  },
  components: {
    Head,
    AuthenticatedLayout,
    Link,
    TomTomMap,
  }
}
</script>

<template>
  <Head :title="apartment.title" />
  <AuthenticatedLayout>

    <div class="main-container">
      <div class="container-title mb-[50px]">
        <h1 class="pb-2">
          {{ apartment.title }}
        </h1>
        <span>
          <font-awesome-icon :icon="['fas', 'location-dot']" /> {{ apartment.address }}
        </span>
      </div>
      <div class="container-img w-full">
        <img :src="apartment.full_cover_img_path" alt="Cover Image Apartment"
          class="w-full h-full object-cover max-h-[900px] object-center">
      </div>
      <div class="container-info-msg flex justify-between mt-20">
        <div class="container-info flex flex-col justify-between border-b-2">
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
            <h2 class="pt-5">
              Servizi inclusi
            </h2>
            <div v-for="service in apartment.services" class="py-3">
              <span><font-awesome-icon :icon="['fas', service.icon]" /></span>
              <span>{{ service.name }}</span>
            </div>
          </div>
          <div v-else>
            <span>Nessun Servizio Aggiuntivo Disponibile</span>
          </div>
          <div class="border-y-2 py-5">
            <div>
              <h2>
                Descrizione Appartamento
              </h2>
              <p class="pt-3 text-gray-600">
                {{ apartment.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <TomTomMap :apartment="apartment" />
    </div>



  </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.main-container {
  width: 65%;
  margin: 60px auto;
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
</style>
