<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    Link
  }
}
</script>

<template>
  <Head :title="apartment.title" />
  <AuthenticatedLayout>

    <div class="main-container">
      <div class="container-title">
        <h1>
          {{ apartment.title }}
        </h1>
        <font-awesome-icon :icon="['fas', 'location-dot']"/> {{ apartment.address }}
      </div>
      <div class="container-img">
        <img :src="apartment.full_cover_img_path" alt="Cover Image Apartment">
      </div>
      <div class="container-info-msg flex justify-between mt-20">
        <div class="container-info flex flex-col justify-between border-b-2">
          <div class="border-b-2 py-5">
            <h2>
              {{ apartment.title }}
            </h2>
            <span>{{ apartment.rooms }} Stanze &bull; </span>
            <span>{{ apartment.beds }} Letti &bull; </span>
            <span>{{ apartment.bathrooms }} Bagni &bull; </span>
            <span>{{ apartment.size }} M<sup>2</sup></span>
          </div>
          <div v-for="service in apartment.services">
            <span>{{ service.icon }}</span>
            <span>{{ service.name }}</span>
          </div>
          <div class="border-y-2 py-5">
            <div>
              <h2>
                Descrizione Appartamento
              </h2>
              <p>
                {{ apartment.description }}
              </p>
            </div>
          </div>
        </div>
        <div class="container-msg">
          <h2>
            Manda un messaggio
          </h2>
          <form action="" method="post">
            <p><label for="name">Nome e Cognome</label></p>
            <input type="text" name="name" id="name">
            <p><label for="email">La tua E-Mail</label></p>
            <input type="text" name="email" id="email">
            <p><label for="message">Messaggio</label></p>
            <input type="text" name="message" id="message">
            <button type="submit" class="button rounded-full text-white px-4 py-2 mt-8">Invia il messaggio</button>
          </form>
        </div>
      </div>
      <div class="container-map mt-20">
        mappa dell'appartamento Here
      </div>
    </div>

  </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
// * {
//   border: 1px solid red;
// }

.main-container {
  width: 65%;
  margin: 60px auto;

  .container-title {
    margin-bottom: 50px;

    h1{
      font-size: 2rem;
    }
  }

  .container-img {
    width: 100%;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  .container-info {
    width: 65%;
  }

  .container-msg {
    width: 30%;

    h2 {
      font-size: 1.8rem;
    }

    input {
      width: 100%;
    }

    button{
      background-color: $main-color;
    }
  }
}
</style>
