<script>

import Maps from '@tomtom-international/web-sdk-maps';
import tt from '@tomtom-international/web-sdk-maps';
import '@tomtom-international/web-sdk-maps/dist/maps.css';
import '@tomtom-international/web-sdk-services/';


export default {
    name: 'TomTomMap',

    components: {
        Maps,
        tt,
    },

    props: {
        apartment: Object,
    },

    data() {
        return {
        }
    },

    methods: {
    },

    mounted() {
        const mapElement = document.getElementById("map");
        const map = tt.map({
            key: "waiWTZRECqzNGHIbW83D94YfzNv1Uc1e",
            container: mapElement,
            center: [this.apartment.longitude, this.apartment.latitude],
            zoom: 15,
        });
        new tt.Marker()
            .setLngLat([this.apartment.longitude, this.apartment.latitude])
            .addTo(map);
    }//mounted
}
</script>


<template>
    <div class="w-full ">
        <div >
            <div id="map" class="h-96 rounded-[7.5px]"></div>
        </div>
    </div>
</template>



<style lang="scss">

</style>

