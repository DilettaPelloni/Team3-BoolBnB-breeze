<script>
import { Link } from '@inertiajs/vue3';
export default {
  name: 'AppHeader',
  components: {
    Link,
  },
  data() {
    return {
      menuVisibility: false,
    }
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
  },
  methods: {
    toggleVisibilty() {
        this.menuVisibility = !this.menuVisibility;
    }
  }
}
</script>

<template>
  <div class="container-header flex justify-between items-center border-b border-black py-[5px] px-[20px]">
    <div class="container-img h-[50px] w-[250px]">
      <img src="/img/LogoBoolBnB.png" alt="Logo BoolBnB" class="object-contain h-full">
    </div>
    <div class="flex">
      <div class="container-affitta flex items-center">
        <a href='#' class="no-underline">Affitta Con BoolBnB</a>
      </div>
      <div class="container-login ml-5 relative">
        <font-awesome-icon :icon="['fas', 'circle-user']" size="2xl" @click="toggleVisibilty"/>
        <!-- <font-awesome-icon :icon="['fas', 'bars']" /> -->
        <div class="absolute z-50 rounded-md shadow-lg w-48 origin-top-right right-0 text-right p-3 bg-white mt-3" v-if="menuVisibility" id="loginMenu">
          <!-- menu login -->
          <div v-if="canLogin">
            <Link
              v-if="$page.props.auth.user" :href="route('dashboard')"
              class="font-semibold text-black  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 "
            >
              Dashboard
            </Link>
            <template v-else>
              <Link
                :href="route('login')"
                class="font-semibold text-black  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 "
              >
                Log in
              </Link>
              <Link
                v-if="canRegister"
                :href="route('register')"
                class="ml-4 font-semibold text-black  focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
              >
                Register
              </Link>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style  lang="scss" scoped>
  @import "../../../scss/app.scss";
  #loginMenu a:hover {
    color: $main-color;
  }
</style>
