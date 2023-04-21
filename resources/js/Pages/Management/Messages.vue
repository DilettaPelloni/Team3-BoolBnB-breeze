<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Messages',
    props: {
        messages: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Link
    }
}
</script>

<template>
    <Head :title="Messaggi" />

    <AuthenticatedLayout>

        <div class="main-container">
        
            <ul>
                <li v-for="message in messages">
                    {{ message.sender_name }}
                </li>
            </ul>

        </div>

    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
.main-container {
  width: 65%;
  margin: 60px auto;
}

</style>
