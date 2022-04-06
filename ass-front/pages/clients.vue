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
    <v-data-table
      :headers="headers"
      :items="clients"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Our Clients</v-toolbar-title>
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
                New Client
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
                        v-model="editItem.name"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        label="Location"
                        placeholder="Placeholder"
                        outlined
                        v-model="editItem.pointLocation"
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12">
                      <v-select
                        v-model="editItem.stationId"
                        :items="animals"
                        color="pink"
                        outlined
                        label="Station animal"
                        required
                      ></v-select>
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
                <v-btn color="blue darken-1" text @click="dialog = false">
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
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize"> Reset </v-btn>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    search: "",
    dialog: false,
    dialogDelete: false,
    editedItem: {
      name: "",
      pointLocation: "",
      stationId: "",
      cableId: "",
    },
    defaultItem: {
      name: "",
      pointLocation: "",
      address: "",
    },
    search: "",
    clients: [],
    headers: [
      {
        text: "Full name",
        align: "start",
        filterable: true,
        value: "name",
      },

      { text: "Location Point", filterable: true, value: "pointLocation" },

      { text: "Station", filterable: true, value: "station" },
      { text: "Address", filterable: true, value: "address" },

      { text: "Actions", value: "actions", sortable: false },
    ],

    animals: ["Harare", "Mutorashanga"],
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
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
    initialize() {
      this.clients = [
        {
          name: "Blessing Mwale",
          pointLocation: "POINT(29.858271, -18.293795)",
          station: "Harare CBD Station",
          address: "7 wingate road rhodesville harare",
        },
        {
          name: "Blessing Mwale",
          pointLocation: "POINT(29.858271, -18.293795)",
          station: "Harare CBD Station",
          address: "7 wingate road rhodesville harare",
        },{
          name: "Blessing Mwale",
          pointLocation: "POINT(29.858271, -18.293795)",
          station: "Harare CBD Station",
          address: "7 wingate road rhodesville harare",
        },{
          name: "Blessing Mwale",
          pointLocation: "POINT(29.858271, -18.293795)",
          station: "Harare CBD Station",
          address: "7 wingate road rhodesville harare",
        },{
          name: "Blessing Mwale",
          pointLocation: "POINT(29.858271, -18.293795)",
          station: "Harare CBD Station",
          address: "7 wingate road rhodesville harare",
        },{
          name: "Blessing Mwale",
          pointLocation: "POINT(29.858271, -18.293795)",
          station: "Harare CBD Station",
          address: "7 wingate road rhodesville harare",
        },
      ];
    },

    editItem(item) {
      console.log(item.address);
      this.editedItem.name = item.name;
      this.editedItem.pointLocation = item.pointLocation;
      this.editedItem.address = item.address;
      this.dialog = true;
    },

    deleteItem(item) {},

    deleteItemConfirm() {},

    close() {
      this.dialog = false;
    },

    closeDelete() {},

    save() {},
  },
};
</script>
