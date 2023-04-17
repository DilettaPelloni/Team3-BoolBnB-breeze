<script>
import AppHeader from '../Components/MyComponents/AppHeader.vue';
import AppFooter from '../Components/MyComponents/AppFooter.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
  }
}
</script>

<template>
  <AppHeader :canLogin="canLogin" :canRegister="canRegister"/>
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
    </div>
  </div>
  <AppFooter />
</template>

<style scoped lang="scss">
.container-page-index {
  // height: calc(100vh - 140px);
}
</style>
