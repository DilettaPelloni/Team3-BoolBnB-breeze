<script>
	export default {
		name:'Index',
        props: {
            apartments: Array,
        }
	}
</script>

<template>
    prova index
    <h2 v-for="apartment in apartments">
        {{ apartment.title }}
    </h2>
</template>

<style scoped>



</style>
