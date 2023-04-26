<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Braintree from "../../Components/MyComponents/Braintree.vue";

export default {
    name: "Sponsoship",
    props: {
        sponsorships: Array,
        apartments: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Braintree,
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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sponsor</th>
                                    <th>Durata</th>
                                    <th>Prezzo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ sponsorships[0].name }}</td>
                                    <td>{{ sponsorships[0].duration }}</td>
                                    <td>{{ sponsorships[0].price }}&euro;</td>
                                </tr>
                                <tr>
                                    <td>{{ sponsorships[1].name }}</td>
                                    <td>{{ sponsorships[1].duration }} </td>
                                    <td>{{ sponsorships[1].price }}&euro;</td>
                                </tr>
                                <tr>
                                    <td>{{ sponsorships[2].name }}</td>
                                    <td>{{ sponsorships[2].duration }} </td>
                                    <td>{{ sponsorships[2].price }}&euro;</td>
                                </tr>
                            </tbody>
                        </table>
                        <Braintree />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";
</style>
