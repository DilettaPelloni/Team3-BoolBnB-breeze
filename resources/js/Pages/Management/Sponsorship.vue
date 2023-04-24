<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

export default {
    name: "Sponsoship",
    props: {
        sponsorships: Array,
        apartments: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
    },
    data() {
        return {
            
        };
    },
    created() {
        
    },
};
</script>

<template>
    <Head :title="Sponsorships" />

    <AuthenticatedLayout>
        <div class="main-container">
            Sponsorships
        </div><!-- CHIUSURA CONTAINER -->
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
.main-container {
    width: 65%;
    margin: 60px auto 0px auto;
    padding-bottom: 100px;
}

h1 {
    font-size: 25px;
    padding: 50px 0px 0px 0px;
}

h2 {
    font-size: 35px;
}

.utente {
    padding: 50px 0px;
    border-bottom: 1px solid #fe5b5f;
}
</style>
