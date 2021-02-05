<script>
    export default {
        name: "GoogleMapMarker",
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
                required: true
            }
        },

        mounted() {
            const { Marker } = this.google.maps;

            new Marker({
                position: { lat: parseFloat(this.marker.lat), lng: parseFloat( this.marker.lng) },
                marker: this.marker,
                map: this.map,
            });

        },

        render() {}
    };
</script>
