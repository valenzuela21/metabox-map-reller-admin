<template>
    <div>
        <div
                id="google-map"
                class="google-map"
                ref="googleMap"
        ></div>
        <template v-if="Boolean(this.google) && Boolean(this.map)">
            <slot
                    :google="google"
                    :map="map"
            />
        </template>
        <v-main v-show="countPlusLocalState === true"> Actualizado ...</v-main>
    </div>

</template>

<script>
    import GoogleMapsApiLoader from "google-maps-api-loader";
    import {mapMutations, mapState} from "vuex";

    import './includes/url';

    export default {
        name: "GoogleMapLoader",
        props: {
            mapConfig: Object,
            apiKey: String
        },

        data() {
            return {
                google: null,
                map: null,
                refresh: false
            };
        },


        computed: mapState({
            countPlusLocalState(state) {
                this.refresh = state.refresh;
                return this.refresh
            }
        }),

        mounted() {
            this.googleMaps();
        },

        updated() {
            if (this.refresh === true) {
                this.resetMap();
            }
        },

        methods: {
            ...mapMutations(['GET_REFRESH']),

            async googleMaps() {
                const googleMapApi = await GoogleMapsApiLoader({
                    libraries: ['places'],
                    apiKey: this.apiKey
                });

                this.google = googleMapApi;
                this.initializeMap();
            },


            initializeMap() {
                const mapContainer = this.$refs.googleMap;
                this.map = new this.google.maps.Map(mapContainer, {
                    zoom: 12,
                    center: {lat: 8.3788373, lng: -81.2266423},
                    mapTypeControl: false,

                });
            },

            resetMap() {
                this.refreshMarker();
                this.updateRefresh();
            },


            refreshMarker() {
                const mapContainer = this.$refs.googleMap;

                const map = new google.maps.Map(mapContainer, {
                    zoom: 12,
                    center: {lat: 8.3788373, lng: -81.2266423},
                    mapTypeControl: false,
                });

                this.downloadUrl(this.urlGeneralMap, (data) => {
                    let xml = data.responseXML;
                    let markers = xml.documentElement.getElementsByTagName('marker');

                    Array.prototype.forEach.call(markers, function (markerElem) {

                        let point = new google.maps.LatLng(
                            parseFloat(markerElem.getAttribute('lat')),
                            parseFloat(markerElem.getAttribute('lng')));

                        let marker = new google.maps.Marker({
                            map: map,
                            position: point,
                        });

                    });


                });


            },


            downloadUrl(url, callback) {

                let request = window.ActiveXObject ?
                    new ActiveXObject('Microsoft.XMLHTTP') :
                    new XMLHttpRequest;

                request.onreadystatechange = function () {
                    if (request.readyState == 4) {
                        request.onreadystatechange = this.doNothing;
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);

            },

            doNothing() {
            },


            updateRefresh() {
                this.$store.commit('GET_REFRESH', false);
            },

        }
    };
</script>


