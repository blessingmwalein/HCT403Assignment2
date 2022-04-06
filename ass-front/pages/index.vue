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
         v-for="station in stations"
         :key="station.id"
          :position="station.cordObj"
          :clickable="true"
          :draggable="true"
          @click="center = m.currentLocation"
        />
      </GmapMap>
    </v-card>
    <v-card class="mt-4" color=" lighten-4" max-width="100%" >
      <v-card-title>
        <v-icon
          :color="checking ? 'red lighten-2' : 'indigo'"
          class="mr-12"
          size="64"
          @click="takePulse"
        >
          mdi-heart-pulse
        </v-icon>
        <v-row align="start">
          <div class="text-caption grey--text text-uppercase">Overal Network Speed</div>
          <div>
            <span class="text-h3 font-weight-black" v-text="avg || '—'"></span>
            <strong v-if="avg">Mps</strong>
          </div>
        </v-row>

        <v-spacer></v-spacer>

        <v-btn icon class="align-self-start" size="28">
          <v-icon>mdi-arrow-right-thick</v-icon>
        </v-btn>
      </v-card-title>

      <v-sparkline
        :key="String(avg)"
        :smooth="16"
        :gradient="['#f72047', '#ffd200', '#1feaea']"
        :line-width="3"
        :value="heartbeats"
        auto-draw
        stroke-linecap="round"
      ></v-sparkline>
    </v-card>
  </v-content>
</template>

<script>
const exhale = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
export default {
  data() {
    return {
      currentLocation: { lat: 0, lng: 0 },
      checking: false,
      heartbeats: [],
      stations:[]
    };
  },
  mounted() {
    this.geolocation();
    this.initialize();
  },
  methods: {
     async initialize() {
      try {
        let data = await this.$axios.$get("/stations");
        console.log(data);
        this.stations = data.response.result;
        var me = this;
        this.stations= this.stations.map( (data) => {
          var cordString = data.pointLocation.substring(6);
          var cord = cordString.split(' ');
          var cordObj = {lng:parseFloat(cord[0]), lat:parseFloat(cord[1])}
          console.log(cordObj);
          return {...data, cordObj}
        } )
      } catch (error) {
        console.log(error);
      }
    },
    geolocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.currentLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
      });
    },

    heartbeat() {
      return Math.ceil(Math.random() * (120 - 80) + 80);
    },
    async takePulse(inhale = true) {
      this.checking = true;

      inhale && (await exhale(1000));

      this.heartbeats = Array.from({ length: 20 }, this.heartbeat);

      this.checking = false;
    },
  },
  computed: {
    avg() {
      const sum = this.heartbeats.reduce((acc, cur) => acc + cur, 0);
      const length = this.heartbeats.length;

      if (!sum && !length) return 0;

      return Math.ceil(sum / length);
    },
  },

  created() {
    this.takePulse(false);
  },

  getCordinate(point){
    return point.split(' ')
  }
};
</script>

<style>
</style>
