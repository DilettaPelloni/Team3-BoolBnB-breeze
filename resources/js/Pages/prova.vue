<script>
import { usePage } from '@inertiajs/vue3';
	export default {
		name:'Prova',
        data () {
            return {
                user: usePage().props.auth.user,
            };
        }
	}
</script>

<template>
    Prova

    {{ user }}

</template>

<style scoped>
</style>