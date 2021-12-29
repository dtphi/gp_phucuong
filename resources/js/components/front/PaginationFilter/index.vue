<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item" v-if="pagination.current_page > 1">
        <!-- Previous -->
        <a
          class="page-link"
          aria-label="Previous"
          v-on:click.prevent="changePage(pagination.current_page - 1)"
        >
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <li
        v-if="this.pagination.current_page - this.offset > 0"
        class="page-item"
      >
        <a class="page-link" v-on:click.prevent="changePage(1)">1</a>
      </li>
      <li
        v-if="this.pagination.current_page - this.offset > 0"
        class="page-item disabled"
      >
        <a href="javascript:void(0)" class="page-link"><span>...</span></a>
      </li>
      <li
        v-for="page in pagesNumber"
        :key="page"
        class="page-item"
        :class="{ active: page == pagination.current_page }"
      >
        <a class="page-link" v-on:click.prevent="changePage(page)">{{
          page
        }}</a>
      </li>
      <li
        v-if="
          this.pagination.current_page + this.offset < this.pagination.last_page
        "
        class="page-item disabled"
      >
        <a href="javascript:void(0)" class="page-link"><span>...</span></a>
      </li>
      <li
        v-if="
          this.pagination.current_page + this.offset < this.pagination.last_page
        "
        class="page-item"
      >
        <a
          class="page-link"
          v-on:click.prevent="changePage(pagination.last_page)"
          >{{ pagination.last_page }}</a
        >
      </li>
      <li
        class="page-item"
        v-if="pagination.current_page < pagination.last_page"
      >
        <!-- Next -->
        <a
          class="page-link"
          aria-label="Next"
          v-on:click.prevent="changePage(pagination.current_page + 1)"
        >
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'PaginationFilter',
  props: ['pagination', 'offset'],
  watch: {
    pagination() {},
  },
  computed: {
    pagesNumber: function() {
      if (!this.pagination.to) {
        return []
      }
      var start =
        this.pagination.current_page - this.offset > 0
          ? this.pagination.current_page - this.offset
          : 1
      var end =
        this.pagination.current_page + this.offset < this.pagination.last_page
          ? this.pagination.current_page + this.offset
          : this.pagination.last_page
      var pagesArray = []
      for (start; start <= end; start++) {
        pagesArray.push(start)
      }

      return pagesArray
    },
  },
  methods: {
    changePage: function(page) {
      this.pagination.current_page = page
    },
  },
}
</script>
<style scoped>
.disabled {
  pointer-events: none;
  opacity: 0.6;
}
.page-link {
  cursor: pointer;
}
</style>
