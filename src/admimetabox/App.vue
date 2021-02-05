<template>
    <div>
        <v-main>
            <TravelMap class="travel-map"></TravelMap>
        </v-main>
        <v-main>
            <v-text-field
                    class="buttom-search-table"
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar Tenderos"
                    single-line
                    hide-details
            ></v-text-field>

            <v-main v-if="showModal" @close="showModal = false">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-container">
                                <v-card-title class="headline">Editar</v-card-title>
                                <v-row>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.address" class="text-input"
                                                      label="Direcci&#243;n"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.city" class="text-input"
                                                      label="Ciudad"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.country" class="text-input"
                                                      label="Country"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.lat" class="text-input"
                                                      label="Latitud"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.lng" class="text-input"
                                                      label="Longitud"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field v-model="editedItem.zip" class="text-input"
                                                      label="Zip Code"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                                </v-card-actions>
                            </div>
                        </div>
                    </div>
                </transition>
            </v-main>

            <v-data-table
                    :headers="headers"
                    :items="desserts"
                    :search="search"
                    :page.sync="page"
                    :items-per-page="itemsPerPage"
                    hide-default-footer
                    sort-by="calories"
                    class="elevation-1"
                    @page-count="pageCount = $event"
            >


                <template v-slot:item.actions="{ item }">
                    <v-icon
                            small
                            class="mr-2"
                            @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                            small
                            @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:no-data>
                    <p>No hay datos disponibles en este tendero</p>
                </template>
            </v-data-table>
            <div class="text-center pt-2">
                <v-pagination v-model="page" :length="pageCount"></v-pagination>
                <p>Item por pagina</p>
                <select v-model="itemsPerPage">
                    <option selected value="5">Seleccione un elemento</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="50">100</option>
                </select>

            </div>
        </v-main>
        <div class="loader-map" v-show="loader === true" >
            <div style="margin: auto; color:#636363">
                <div class="lds-ripple"><div></div><div></div></div>
               <p>Cargando...</p>
            </div>
        </div>
    </div>

</template>

<script>

    import TravelMap from "./components/TravelMap.vue";
    import axios from 'axios';
    import puente from './components/map/includes/bus';
    import {mapMutations} from "vuex";
    import './components/map/includes/url';

    export default {
        name: "App",
        components: {
            TravelMap,
        },
        data: () => ({
            page: 1,
            pageCount: 0,
            itemsPerPage: 10,
            search: '',
            refresh: false,
            showModal: false,
            loader: false,
            headers: [
                {text: 'Ciudad', value: 'city', sortable: false,},
                {text: 'Direcci&#243;n', value: 'address', sortable: false,},
                {text: 'Zip', value: 'zip', sortable: false,},
                {text: 'Pais', value: 'country', sortable: false,},
                {text: 'Latitud', value: 'lat', sortable: false},
                {text: 'Longitud', align: 'start', sortable: false, value: 'lng'},
                {text: 'Actions', value: 'actions', sortable: false},
            ],
            desserts: [],
            editedIndex: -1,
            editedItem: {
                city: '',
                address: '',
                zip: 0,
                country: 0,
                lat: 0,
                lng: 0,
            },
            defaultItem: {
                city: '',
                address: '',
                zip: 0,
                country: 0,
                lat: 0,
                lng: 0,
            },
        }),

        created() {
            puente.$on('consult-table', (parametro) => {
                if (parametro == true) {
                    this.initialize();
                }
            });

            this.initialize()
        },

        methods: {
            ...mapMutations(['GET_REFRESH']),
            initialize() {
                this.loader=true;
                axios.get(this.urlGeneralConsult)
                    .then(res => {this.desserts = res.data.reverse(); this.loader = false})
            },

            editItem(item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.showModal = true
            },

            deleteItem(item) {
                const index = this.desserts.indexOf(item);
                let id_data = item.id;
                let res = confirm('Deseas eliminar esta ubicaci&#243;n.');
                this.loader = true;
                if (res == true) {
                    axios.post(this.urlGeneralDelete,{id_data})
                    .then((res)=>{
                        this.loader =  false;
                        console.log('Eliminado ubicaci&#243;n correctamente')
                        this.desserts.splice(index, 1)
                        setTimeout(()=>{
                            this.$store.commit('GET_REFRESH', true);
                        },1000)
                    })
                }
            },

            close() {
                this.showModal = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            save() {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem);

                    let {address, city, country, id, id_post, lat, lng, type, zip} = this.editedItem;

                    this.loader = true;

                    axios.post(this.urlUpdate, {address, city, country, id, id_post, lat, lng, type, zip})
                            .then((res)=>{
                                this.loader = false;
                                console.log("Se ha modificado correctamente")
                            })

                }

                this.close()
            },
        },
    }
</script>




