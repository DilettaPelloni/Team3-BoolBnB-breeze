<script>
export default {
  name: 'AppFooter',
}
</script>

<template>
  <div class="container-footer flex items-center h-[40px] position">
    <div class="container-links-footer">
      <ul class="flex">
        <li><a href="http://"><font-awesome-icon :icon="['far', 'copyright']" /> 2023 BoolBnB, Inc.</a></li>
        <li><a href="http://">Privacy</a></li>
        <li><a href="http://">Termini</a></li>
        <li><a href="http://">Mappa del sito</a></li>
        <li><a href="http://">Dettagli dell'azienda</a></li>
        <li><a href="http://">Destinazioni</a></li>
      </ul>
    </div>
  </div>
</template>

<style scoped lang="scss">
.container-footer {
  height: 40px;
  background-color: lightcoral;
  position: relative;

  .container-links-footer {

    ul {
      list-style: none;
      margin: 0px;

      a {
        color: #222222;
        text-decoration: none;
        padding-right: 10px;
      }
    }
  }
}
</style>
