<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'Dashboard',
    props: {
        views: Array,
        user_firstname: String,
        viewsPerApartment: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Bar,
        Link,
    },
    data() {
        return {
            titleArr: [],
            chartData: {
                labels: ['prova1', 'prova2', 'prova3'],
                datasets: [
                    {
                        label: 'Visualizzazioni Totali ',
                        backgroundColor: '#fe5e62',
                        data: [this.views.length]
                    }
                ]
            }
        }
    },
    // mounted() {
    //     for (let i = 0; i < (this.views.length -1); i++) {

    //         dove.push(cosa)           
    //     }
    //     console.log() 
    // }
}



</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <!-- {{ views }} -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Benvenuto! Per cominciare a gestire gli appartamenti fai click su
                        "Appartamenti"</div>
                </div>
            </div>
        </div>
        {{ viewsPerApartment }}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <button class="button rounded-full text-white px-4 py-2">
                            <Link :href="route('sponsorship')">Sponsorizza un appartamento</Link>
                        </button>
                    </div>
                    <div class="p-6 text-gray-900 flex justify-between">
                        <div>
                            nome appartamento
                        </div>
                        <div class="flex">
                            <div class="pr-3">
                                sponsor attiva/scaduta
                            </div>
                            <div>
                                data scadenza / v-if rinnova btn
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
@import "../../scss/app.scss";

.button {
    background-color: $main-color;
}
</style>
