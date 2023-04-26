<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

export default {
    name: "Sponsoship",
    props: {
        sponsorships: Array,
        apartments: Array,
        activeSponsorships: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
    },
    data() {
        return {

        };
    },
    methods: {
        isSponsorized (apartment) {
            let flag = true;
            const today = new Date();
            if(this.activeSponsorships.length > 0) {
                this.activeSponsorships.forEach((sponsorship) => {
                    if(sponsorship.apartment_id == apartment.id) {
                        let end_date = new Date(sponsorship.end_date);
                        if(end_date > today) {
                            console.log(end_date);
                            console.log(today);
                            console.log('sono qui');
                            flag = false;
                        }
                    }
                });
            }
            return flag;
        }
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
                    <ul class="p-6 text-gray-900">
                        <li
                            v-for="apartment in apartments"
                            class="py-5 border-b item flex justify-between"
                        >
                            <h4>{{ apartment.title }}</h4>

                            <button
                                class="rounded-full"
                                :class="{
                                    disabled: !isSponsorized(apartment),
                                }"
                            >
                                {{ isSponsorized(apartment) ? 'Sponsorizza' : 'Sponsorizzazione attiva'}}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
@import "../../../scss/app.scss";

.item {
    border-color: $main-color;
    button {
        padding-block: 0.5rem;
        padding-inline: 0.5rem;
        background-color: $main-color;
        color: white;
        &.disabled {
            background-color: grey;
        }
    }
}

</style>
