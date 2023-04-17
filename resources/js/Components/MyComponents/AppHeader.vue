<script>
export default {
  name: 'AppHeader',
}
</script>

<template>
  <div class="container-header container-fluid h-100 flex justify-between items-center border-b border-indigo-500">
    <div class="container-img h-50 w-250">
      <img src="storage/img/LogoBoolBnB.png" alt="Logo BoolBnB" class="object-contain h-full">
    </div>
    <div>
      Searchbar
    </div>
    <div class="flex">
      <div class="container-affitta flex items-center">
        <a href='#' class="no-underline">Affitta Con BoolBnB</a>
      </div>
      <div class="container-login ml-5">
        <font-awesome-icon :icon="['fas', 'circle-user']" size="2xl" />
        <!-- <font-awesome-icon :icon="['fas', 'bars']" /> -->
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
