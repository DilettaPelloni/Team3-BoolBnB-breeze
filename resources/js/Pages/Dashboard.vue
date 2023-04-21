<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'Dashboard',
    props: {
        views: Array,
        user_firstname: String,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Bar,
    },
    data() {
        return {
            chartData: {
                labels: [this.views[0].title],
                datasets: [
                    {
                        label: 'Visualizzazioni Totali ',
                        backgroundColor: '#fe5e62',
                        data: [this.views.length]
                    }
                ]
            }
        }
    }
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
                        Sponsor belle belle here
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
