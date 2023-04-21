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
            map: null,
        }
    },

    methods: {
        initMap() {

            const mapElement = document.getElementById("map");
            const map = tt.map({
                key: 'sgtrLeYcFVDMrQS9K4HbYHzzxVNDFuG5',
                container: mapElement,
                center: [this.apartment.latitude, this.apartment.longitude],
                zoom: 10
            });

            const marker = new tt.Marker().setLngLat([this.apartment.latitude, this.apartment.longitude]).addTo(map);

            const popupOffsets = {
                top: [0, 0],
                bottom: [0, -70],
                'bottom-right': [0, -70],
                'bottom-left': [0, -70],
                left: [25, -35],
                right: [-25, -35]
            }

            const popup = new tt.Popup({ offset: popupOffsets }).setHTML(
                `<h3>${this.apartment.title}</h3><p>${this.apartment.address}</p>`
            );

            marker.setPopup(popup).togglePopup();

            this.map = map;
        }
    },

    mounted() {
        this.initMap();
    }
}




//

</script>


<template>
    <div id='map'>
        <div class="container-map">
            <div class="container-map-title">
                <h2>
                    Mappa
                </h2>
            </div>
            <div class="container-map-content">
                <div class="container-map-content-map">
                    <div class="container-map-content-map-tomtom">
                        <div class="container-map-content-map-tomtom-map" id="map"></div>
                    </div>
                </div>
                <div class="container-map-content-info">
                    <div class="container-map-content-info-title">
                        <h2>
                            Indirizzo
                        </h2>
                    </div>
                    <div class="container-map-content-info-address">
                        <p>
                            {{ apartment.address }}
                        </p>
                    </div>
                    <div class="container-map-content-info-title">
                        <h2>
                            Coordinate
                        </h2>
                    </div>
                    <div class="container-map-content-info-coordinates">
                        <p>
                            {{ apartment.latitude }}
                        </p>
                        <p>
                            {{ apartment.longitude }}
                        </p>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- <button @click="initMap">Init Map</button> -->












    <div id='map' class='window-height'></div>
</template>



<style lang="scss">
.container-map {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    margin-bottom: 20px;
}

.container-map-title {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.container-map-content {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container-map-content-map {
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container-map-content-map-tomtom {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container-map-content-map-tomtom-map {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container-map-content-info {
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.container-map-content-info-title {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.container-map-content-info-address {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.container-map-content-info-coordinates {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.container-map-content-info-coordinates p {
    margin-right: 20px;
}
</style>

