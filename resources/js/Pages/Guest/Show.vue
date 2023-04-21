<script>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { useForm } from "@inertiajs/vue3";
import AppHeader from '../../Components/MyComponents/AppHeader.vue'

export default {
  name: 'Show',
  props: {
    apartment: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    user_email: String,
  },
  components: {
    Head,
    Link,
    AppHeader
  },
  data() {
    return {
      newMessage: useForm({
        apartmentId: this.apartment.id,
        content: null,
        sender_email: this.user_email,
        sender_name: null,
      }),
      okMessage: false,
    }
  },//data
  methods: {
    submit() {
      this.newMessage.post(route("messages.store"), {
        onSuccess: () => this.okMessage = true,
      });
      this.newMessage.reset();
    }, //submit
  },
}
</script>

<template>
  <AppHeader :canLogin="canLogin" :canRegister="canRegister"/>

  <Head :title="apartment.title" />
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
            <span>{{ service.icon }}</span>
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
      <div class="container-msg">
        <h2>
          Manda un messaggio
        </h2>
        <p class="text-sm pb-5">
          *tutti i campi sono obbligatori
        </p>
        <!-- FORM  -->
        <form @submit.prevent="submit">
          <!-- SENDER NAME  -->
          <p><label for="sender_name">Nome e Cognome</label></p>
          <input
            type="text"
            name="sender_name"
            id="sender_name"
            class="my-4"
            v-model="newMessage.sender_name"
          >
          <div v-if="newMessage.errors.sender_name" class="text-red-500 text-xs italic">
              {{ newMessage.errors.sender_name }}
          </div>
          <!-- SENDER EMAIL  -->
          <p><label for="sender_email">La tua E-Mail</label></p>
          <input
            type="text"
            name="sender_email"
            id="sender_email"
            class="my-4"
            v-model="newMessage.sender_email"
          >
          <div v-if="newMessage.errors.sender_email" class="text-red-500 text-xs italic">
              {{ newMessage.errors.sender_email }}
          </div>
          <!-- CONTENT  -->
          <p><label for="content">Messaggio</label></p>
          <input
            type="text"
            name="content"
            id="content"
            class="my-4"
            v-model="newMessage.content"
          >
          <div v-if="newMessage.errors.content" class="text-red-500 text-xs italic">
              {{ newMessage.errors.content }}
          </div>
          <!-- BOTTONE -->
          <button type="submit" class="button rounded-full text-white px-4 py-2 mt-8">Invia il messaggio</button>
          <!-- MESSAGGIO OK -->
          <p v-if="okMessage">
            Il tuo messaggio è stato inviato correttamente!
          </p>
        </form>
      </div>
    </div>
    <div class="container-map mt-20">
      mappa dell'appartamento Here
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.main-container {
  width: 65%;
  margin: 60px auto;

  .container-info {
    width: 65%;
  }

  .container-msg {
    width: 30%;


    input {
      width: 100%;
    }

    button {
      background-color: $main-color;
    }
  }
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
