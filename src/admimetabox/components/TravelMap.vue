<template>
    <div>

    <GoogleMapLoader
            apiKey="AIzaSyAbz4NWK8NfeybeMGfBqQyablVMv2Xm0Lw"
    >
        <template slot-scope="{ google, map }">
            <GoogleGeocode
                    :google="google"
                    :map="map"
            />
            <GoogleMapMarker
                    v-for="marker in markers"
                    :key="marker.id"
                    :marker="marker"
                    :google="google"
                    :map="map"
            />
        </template>
    </GoogleMapLoader>
    </div>
</template>

<script>
    import GoogleMapLoader from "./map/GoogleMapLoader.vue";
    import GoogleMapMarker from "./map/GoogleMapMarker.vue";
    import GoogleGeocode from "./map/GoogleGeocode.vue";
    import axios from "axios";

    import  './map/includes/url';

    export default {
        name: "TravelMap",
        components: {
            GoogleMapLoader,
            GoogleMapMarker,
            GoogleGeocode
        },
        data(){
            return{
                markers: [],
                start: false,
            }
        },

        mounted(){
            this.initialize();
        },

        methods: {
           initialize(){

               axios.get(this.urlGeneralConsult)
                   .then(res => (this.markers = res.data))

           }
        }

    };
</script>

