<template>
    <div>
        <v-container class="grey lighten-5  container-margin-top">
            <v-row no-gutters>
                <v-col md="8" class="column-input-search">
                    <input type="text" :disabled="disabled === true" class="input-search-address" ref="pacinput"
                           @change="changeDate($event)"
                           v-on:keydown="onInputAdrress($event)" v-model="address" placeholder="Ingresa la dirección"/>
                    <button type="button" v-show="visible === true" @click="refreshMap" class="btn-refresh"
                            value="Refrescar"><em class="figure-refresh"></em></button>
                </v-col>
                <v-col v-if="visible === false" md="2">
                    <input type="button" class="input-button-address" @click="searchMap" value="Buscar"/>
                </v-col>
                <v-col v-else md="3">
                    <input type="button" class="search-buttom" @click="addMakermap"
                           value="Adjuntar Tendero"/>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    import axios from 'axios'
    import puente from '../map/includes/bus';
    import './includes/url'
    export default {
        name: "GoogleGeocode",
        props: {
            google: {
                type: Object,
                required: true
            },
            map: {
                type: Object,
                required: true
            },
            marker: {
                type: Object,
                required: false
            }

        },

        data: function () {
            return {
                infodate: [],
                visible: false,
                disabled: false,
                refresh: false
            }
        },

        computed: {
            ...mapState(['address']),
            address: {
                get() {
                    return this.$store.state.address
                },
                set(value) {
                    this.$store.commit('GET_ADDRESS', value)
                }
            },

        },

        methods: {
            ...mapMutations(['GET_INFOADRESS', 'GET_REFRESH']),
            searchMap: function () {
                const map = new this.google.maps.Map(
                    document.getElementById("google-map"),
                    {
                        zoom: 12,
                        center: {lat: 8.3788373, lng: -81.2266423},
                        mapTypeControl: false,

                    }
                );
                const geocoder = new this.google.maps.Geocoder();
                this.gecoderAddress(geocoder, map);
            },


            changeDate: function (event) {
                setTimeout(() => {
                    let value = event.target.value;
                    this.$store.commit('GET_ADDRESS', value);
                }, 500)
            },


            onInputAdrress: function () {
                const input = this.$refs.pacinput;
                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.setFields(["address_components", "geometry", "icon", "name"]);
                const address_auto = []
                autocomplete.addListener("place_changed", () => {
                    const place = autocomplete.getPlace();

                    for (const component of place.address_components) {
                        const addressType = component.types[0];
                        address_auto[addressType] = component.long_name
                    }

                });
                this.infodate = address_auto;
            },


            gecoderAddress: function (geocoder, resultsMap) {

                const address = this.$store.state.address;

                geocoder.geocode({address: address}, (results, status) => {

                    if (status === "OK") {
                        resultsMap.setCenter(results[0].geometry.location);

                        new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });

                        let lat = results[0].geometry.location.lat();
                        let lng = results[0].geometry.location.lng();

                        this.infodate["latitude"] = lat;
                        this.infodate["longitude"] = lng;

                        let  {country, locality, postal_code,  route, street_number, sublocality_level_1, latitude,  longitude } = this.infodate;

                        (country === undefined)? country = '' : country;
                        (locality === undefined)? locality = '' : locality;
                        (postal_code === undefined)? postal_code = '' : postal_code;
                        (route === undefined)? route = '' : route;
                        (street_number === undefined)? street_number = '' : street_number;
                        (sublocality_level_1 === undefined)? sublocality_level_1 = '' : sublocality_level_1;
                        (latitude === undefined)? latitude = '' : latitude;
                        (longitude === undefined)? longitude = '' : longitude;

                        this.$store.commit('GET_INFOADRESS', [country, locality, postal_code, route, street_number, sublocality_level_1, latitude, longitude]);

                        this.visible = true;
                        this.disabled = true;
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }

                })
            },

            refreshMap: function () {
                this.address = "";
                this.disabled = false;
                this.visible = false;
                this.$store.commit('GET_REFRESH', true);
            },

            addMakermap: function () {

                let data = this.$store.state.infogeneral;

                let currentUrl = window.location.href;
                let currentPath = currentUrl.substr( currentUrl.indexOf('?post='));
                currentPath = currentPath.split("&");
                currentPath = currentPath[0].split("=");

                axios.post(this.urlInsert, {
                    id_post : currentPath[1],
                    country: data[0],
                    locality: data[1],
                    postal_code: data[2],
                    route: data[3],
                    street_number: data[4],
                    sublocality_level_1: data[5],
                    latitude: data[6],
                    longitude: data[7]
                })
                    .then((response) => {
                        console.log('Se ha insertado correctamente: ');
                        puente.$emit('consult-table',true);
                        this.$store.commit('GET_REFRESH', true);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                this.address = "";
                this.disabled = false;
                this.visible = false;

            }

        }

    }
</script>

<style scoped>

</style>
