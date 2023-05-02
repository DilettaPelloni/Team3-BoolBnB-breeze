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
        apartments: Array,
    },
    components: {
        Head,
        AuthenticatedLayout,
        Bar,
        Link,
    },
    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Visualizzazioni Totali ',
                        backgroundColor: '#fe5e62',
                        data: []
                    }
                ]
            },
            chartOptions: {
                responsive: true
            },
        }
    },
    created() {
        this.apartments.forEach((apartment) => {
            this.chartData.labels.push(apartment.title);
            let flag = false;
            this.viewsPerApartment.forEach((view) => {
                if(view.apartment_id == apartment.id){
                    this.chartData.datasets[0].data.push(view.total);
                    flag = true;
                }
            })
            if(flag == false) {
                this.chartData.datasets[0].data.push(0);
            }
        });
    }
}



</script>

<template>
    <Head>
        <title>
            Dashboard - BoolBnB
        </title>
        <link rel="icon" href="/favicon.svg" />
    </Head>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Benvenuto {{ this.user_firstname }}! Questa è la tua Dashboard per la gestione dei tuoi appartamenti!
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Bar :options="chartOptions" :data="chartData" />
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
