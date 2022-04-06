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
      :items="stations"
      :search="search"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>My Sations</v-toolbar-title>
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
                New Station
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
                      <!-- <v-text-field
                        label="Location"
                        placeholder="Placeholder"
                        outlined
                        v-model="editItem.pointLocation"
                      ></v-text-field> -->
                      <GmapAutocomplete @place_changed="setPlace" />
                    </v-col>

                    <v-col cols="12">
                      <v-textarea v-model="address" color="teal" outlined>
                        <template v-slot:label>
                          <div>Address <small>(optional)</small></div>
                        </template>
                      </v-textarea>
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
    <v-snackbar v-model="snackbar" :timeout="2000">
      {{ message }}

      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs"> Close </v-btn>
      </template>
    </v-snackbar>
  </v-card>
</template>

<script>
import AddDataForm from "../components/Forms/AddStationForm.vue";
import SnackBar from "../components/SnackBar.vue";
import Loader from "../components/Loader.vue";
import { mapActions, mapState, mapGetters } from "vuex";

export default {
  data() {
    return {
      search: "",
      dialog: false,
      dialogDelete: false,
      name: "",
      pointLocation: "",
      address: "",
      editedItem: {
        name: "",
        pointLocation: "",
        address: "",
      },
      markers: [],
      headers: [
        {
          text: "Station name",
          align: "start",
          filterable: true,
          value: "name",
        },
        { text: "Location Point", filterable: true, value: "pointLocation" },
        { text: "Address", filterable: true, value: "address" },
        { text: "Actions", value: "actions", sortable: false },
      ],
    };
  },
  computed: {
    ...mapGetters({
      user: "app/getUser",
      loading: "app/getLoading",
      stations: "app/getStations",
      snackbar: "app/getSnackBar",
      message: "app/getMessage",
      error: "app/getError",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
  },
  mounted() {
    this.initialize();
  },
  methods: {
    ...mapActions({
      getStations: "app/getStations",
      getCables: "app/getCables",
      saveStation: "app/saveStation",
    }),
    initialize() {
      this.getStations();
    },
    submitForm() {
      var formData = new FormData();
      formData.append("name", this.name);
      formData.append("address", this.address);
      formData.append("pointLocation", this.pointLocation);
      this.saveStation(formData).then((result) => {
        this.dialog = false;
        this.initialize();
      });
    },
    setPlace(place) {
      this.currentPlace = place;
      console.log(this.currentPlace);
      this.pointLocation = `POINT( ${this.currentPlace.geometry.location.lng()}, ${this.currentPlace.geometry.location.lat()})`;
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
    close() {
      this.dialog = false;
    },
  },
  components: { SnackBar, Loader },
};
</script>
