<template>
  <v-content>
    <v-card>
      <GmapMap
        :center="currentLocation"
        :zoom="6"
        map-type-id="terrain"
        style="width: 100%; height: 500px"
      >
        <GmapMarker
          v-for="(station, index) in stations"
          :key="station.id"
          :position="station.cordObj"
          :clickable="true"
          :draggable="true"
          @click="toggleInfoWindow(station, index)"
        />
        <gmap-info-window
          :options="infoOptions"
          :position="infoWindowPos"
          :opened="infoWinOpen"
          @closeclick="infoWinOpen = false"
        >
          <div v-html="infoContent"></div>
        </gmap-info-window>

        <gmap-polyline
          v-for="cable in cables"
          :key="`${cable.id}key-bfd`"
          v-bind:path.sync="cable.path"
          v-bind:options="{ strokeColor: '#008000' }"
        >
        </gmap-polyline>
        <gmap-polyline
          v-bind:path.sync="path"
          v-bind:options="{ strokeColor: '#0000FF' }"
        >
        </gmap-polyline>
      </GmapMap>
    </v-card>
    <Loader v-if="loading"></Loader>
  </v-content>
</template>

<script>
import { mapActions, mapState, mapGetters } from "vuex";

import Loader from "../components/Loader.vue";
const exhale = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
export default {
  data() {
    return {
      currentLocation: { lat: 0, lng: 0 },
      checking: false,
      infoContent: "",
      infoWindowPos: {
        lat: 0,
        lng: 0,
      },
      infoWinOpen: false,
      currentMidx: null,
      //optional: offset infowindow so it visually sits nicely on top of our marker
      infoOptions: {
        pixelOffset: {
          width: 0,
          height: -35,
        },
      },
    };
  },
  computed: {
    ...mapGetters({
      user: "app/getUser",
      loading: "app/getLoading",
      stations: "app/getStations",
      cables: "app/getCables",
      path: "app/getStationPath",
    }),
  },
  mounted() {
    this.initialize();
  },
  methods: {
    ...mapActions({
      getStations: "app/getStations",
      getCables: "app/getCables",
    }),
    initialize() {
      this.getStations().then((data) => {
        this.geolocation();
      });
    },
    geolocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.currentLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.getCables();
      });
    },

    toggleInfoWindow: function (marker, idx) {
      this.infoWindowPos = marker.cordObj;
      this.infoContent = this.getInfoWindowContent(marker);

      //check if its the same marker that was selected if yes toggle
      if (this.currentMidx == idx) {
        this.infoWinOpen = !this.infoWinOpen;
      }
      //if different marker set infowindow to open and reset current marker index
      else {
        this.infoWinOpen = true;
        this.currentMidx = idx;
      }
    },

    getInfoWindowContent: function (marker) {
      return `<div class="card">
      <div class="card-content">
        <div class="media">
          <div class="media-content">
            <p class="title is-4">${marker.name}</p>
          </div>
        </div>
        <div class="content">
          ${marker.address}
          <br>
        </div>
      </div>
    </div>`;
    },
  },
  components: { Loader },
};
</script>

<style>
</style>
