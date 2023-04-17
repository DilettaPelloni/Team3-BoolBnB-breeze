<script>
import { Link } from '@inertiajs/vue3';
import AppHeader from '../Components/MyComponents/AppHeader.vue';
import AppFooter from '../Components/MyComponents/AppFooter.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
    Link,
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
  }
}
</script>

<template>
  <AppHeader />
  <div class="container-page-index container-fluid">
    <div class="container-cards flex justify-between flex-wrap h-full overflow-y-scroll">
      <div class="card h-[400px] w-[300px] ">
        <div class="image h-3/4 w-full">
          <img src="https://a0.muscache.com/im/pictures/53992414/64510035_original.jpg?im_w=1200" alt="immagine casa"
            class="w-full h-full object-cover rounded-2xl">
        </div>
        <div class="card-info w-full h-1/5">
          <div class="flex justify-between">
            <span>
              <b>Riva, italia</b>
            </span>
            <span>
              4,8 ⭐
            </span>
          </div>
          <div>Visto sul mare, lago</div>
          <div>Host Privato</div>
          <div><b>Tanti $</b> notte</div>
        </div>
      </div>
      <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
          class="font-semibold text-black  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
        Dashboard</Link>

        <template v-else>
          <Link :href="route('login')"
            class="font-semibold text-black  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
          Log in</Link>

          <Link v-if="canRegister" :href="route('register')"
            class="ml-4 font-semibold text-black  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
          Register</Link>
        </template>
      </div>
    </div>
  </div>
  <AppFooter />
</template>

<style scoped lang="scss">
.container-page-index {
  // height: calc(100vh - 140px);
}
</style>
