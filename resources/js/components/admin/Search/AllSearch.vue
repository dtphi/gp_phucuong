<template>
  <div class="input-group input-group-sm">
    <input
      v-model="query"
      class="form-control form-control-navbar"
      type="search"
      placeholder="Search"
      aria-label="Search"
    />
    <div class="input-group-append">
      <button
        class="btn btn-navbar"
        type="button"
        @click="searchProducts"
        @keyup.enter="searchProducts"
      >
        <font-awesome-icon icon="search" />
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { ACTION_SEARCH_ALL } from "store@admin/types/action-types";

export default {
  name: "AllSearch",
  components: {},
  data() {
    return {
      query: "",
    };
  },
  computed: {
    ...mapGetters(["moduleNameActive", "moduleActionListActive"]),
  },
  watch: {
    /*query: {
      handler: _.debounce(function () {
        this.searchProducts();
      }, 100),
    },*/
  },
  methods: {
    searchProducts() {
      if (this.query && this.query.length) {
        this.$store.dispatch(
          this.moduleNameActive + "/" + ACTION_SEARCH_ALL,
          this.query
        );
      } else {
        this.$store.dispatch(
          this.moduleNameActive + "/" + this.moduleActionListActive
        );
      }
    },
  },
};
</script>
