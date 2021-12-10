<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card>
        <v-card-title class="headline">
          Welcome to Linh Mục!
        </v-card-title>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>

export default {
  layout: 'adminPrivate',
  middleware: 'auth'
}
</script>
