import Vue from "vue";
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyD2aMS3Zy5ru63unlPgw1uV4v-fa7iRDfU",
        libraries: "places",
    },
});