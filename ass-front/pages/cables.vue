<template>
  <v-card>
    <v-card-title>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <Loader v-if="loading"></Loader>
    <v-data-table
      v-else
      :headers="headers"
      :items="cables"
      :search="search"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>My Cables</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="orange lighten-2"
                text
                class="mb-2"
                v-bind="attrs"
                v-on="on"
              >
                New Cable
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        label="Name"
                        placeholder="Placeholder"
                        outlined
                        v-model="name"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="stationId"
                        :items="selectStations"
                        color="pink"
                        outlined
                        label="Station animal"
                        required
                      ></v-select>
                    </v-col>
                    <v-col
                      v-if="locations.length"
                      v-for="location in locations"
                      :key="location.id"
                      cols="12"
                      sm="12"
                      md="12"
                    >
                      <v-chip
                        v-if="location.show"
                        class="ma-2"
                        close
                        @click:close="location.show = false"
                      >
                        {{ location.name }}
                      </v-chip>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <!-- <v-text-field
                        label="Location"
                        placeholder="Placeholder"
                        outlined
                        v-model="editItem.pointLocation"
                      ></v-text-field> -->
                      <GmapAutocomplete @place_changed="setPlace" />
                    </v-col>
                  </v-row>
                </v-container>
                <small>*indicates required field</small>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialog = false">
                  Close
                </v-btn>
                <v-btn color="blue darken-1" text @click="submitForm()">
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text>Cancel</v-btn>
                <v-btn color="blue darken-1" text>OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2"> mdi-pencil </v-icon>
        <v-icon small> mdi-delete </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize"> Reset </v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import { mapActions, mapState, mapGetters } from "vuex";

export default {
  data: () => ({
    search: "",
    dialog: false,
    dialogDelete: false,
    name: "",
    lineString: "",
    stationId: "",
    cableId: "",
    locations: [],
    headers: [
      {
        text: "Cable name",
        align: "start",
        filterable: true,
        value: "name",
      },

      { text: "Location Point", filterable: true, value: "lineString" },

      { text: "Station", filterable: true, value: "stationName" },

      { text: "Actions", value: "actions", sortable: false },
    ],
    animals: ["Harare", "Mutorashanga"],
  }),

  computed: {
    ...mapGetters({
      user: "app/getUser",
      loading: "app/getLoading",
      stations: "app/getStations",
      cables: "app/getCables",
      snackbar: "app/getSnackBar",
      message: "app/getMessage",
      error: "app/getError",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
    selectStations() {
      return this.stations.map((station) => {
        return {
          value: station.id,
          text: station.name,
        };
      });
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    ...mapActions({
      getCables: "app/getCables",
      getStations: "app/getStations",
      saveStation: "app/saveStation",
      saveCable: "app/saveCable",
    }),
    initialize() {
      this.getCables().then((data) => {
        this.getStations();
      });
    },
    setPlace(place) {
      var currentPlace = place;
      var pointLocation = `${currentPlace.geometry.location.lat()} ${currentPlace.geometry.location.lng()}`;
      this.locations.push({
        show: true,
        pointLocation: pointLocation,
        name: `POINT( ${currentPlace.geometry.location.lng()}, ${currentPlace.geometry.location.lat()})`,
      });
    },
    addMarker() {
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng(),
        };
        this.markers.push({ position: marker });
        this.center = marker;
        this.currentPlace = null;
      }
    },
    submitForm() {
      var formData = new FormData();
      formData.append("name", this.name);
      formData.append("stationId", this.stationId);
      formData.append("cableId", this.stationId);
      formData.append("lineString", this.getLineString());

      this.saveCable(formData).then((result) => {
        this.dialog = false;
        this.initialize();
      });
    },

    close() {
      this.dialog = false;
    },

    closeDelete() {},

    save() {},

    getLineString() {
      var lineString = "LINESTRING(";
      this.locations.forEach((location) => {
        lineString += `${location.pointLocation},`;
      });
      lineString = lineString.substring(0, lineString.length - 1);
      return `${lineString})`;
    },
  },
};
</script>
