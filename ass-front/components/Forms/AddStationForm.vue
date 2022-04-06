<template>
  <v-card>
    <v-card-title>
      <span class="text-h5">{{formName}}</span>
    </v-card-title>
    <v-card-text>
      <v-container>
        <v-row>
          <v-col cols="12" sm="6" md="6" >
            <v-text-field
            label="Name"
            placeholder="Placeholder"
            outlined
            v-bind="form.name"
          ></v-text-field>
          </v-col>
           <v-col cols="12" sm="6" md="6" >
            <v-text-field
            label="Location"
            placeholder="Placeholder"
            outlined
            v-bind="form.pointLocation"
          ></v-text-field>
          </v-col>

          <v-col cols="12">
            <v-textarea
              v-model="form.address"
              color="teal"
              outlined
            >
              <template v-slot:label>
                <div>
                  Address <small>(optional)</small>
                </div>
              </template>
            </v-textarea>
          </v-col>
        </v-row>
      </v-container>
      <small>*indicates required field</small>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" text @click="closeDialog()"> Close </v-btn>
      <v-btn color="blue darken-1" text @click="dialog = false"> Save </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props:['form', 'formName'],
  methods:{
    closeDialog(){
      this.$emit('close-dialog');
    },
    saveData(){

    }
  }
};
</script>

<style>
</style>
