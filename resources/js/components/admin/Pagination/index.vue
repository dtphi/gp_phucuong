<template>
  <div class="row admin-cusstom-paging">
    <template 
      v-if="_isResource"
    >
      <div class="col-sm-6 text-left">
        <div class="dataTables_info">
          {{ _getTextPagination() }}
        </div>
      </div>
      <div class="col-sm-6 text-right">
        <div class="dataTables_paginate paging_simple_numbers">
          <resource-pagination
            :data="_resourceData"
            @pagination-change-page="_getResourceResults"
            :limit="_resourceData.meta.per_page"
            :show-disabled="showDisabled"
            :size="size"
            :align="align"
          ></resource-pagination>
        </div>
      </div>
    </template>
    <template 
      v-else
    >
      <div class="col-sm-6 text-left">
        <div class="dataTables_info">
          {{ _getTextPaginationCollection() }}
        </div>
      </div>
      <div class="col-sm-6 text-right">
        <div
          class="dataTables_paginate paging_simple_numbers"
          v-if="Object.keys(_collectionData).length"
        >
          <collection-pagination
            class="mb-0"
            :data="_collectionData"
            @pagination-change-page="_getCollectionResults"
            :limit="limit"
            :show-disabled="showDisabled"
            :size="size"
            :align="align"
          ></collection-pagination>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ResourcePagination from "./ResourcePagination";
import CollectionPagination from "./CollectionPagination";

export default {
  name: "Pagination",
  props: {
    isResource: {
      type: Boolean,
      default: true,
    },
  },
  components: {
    ResourcePagination,
    CollectionPagination,
  },
  data() {
    return {
      limit: 5,
      showDisabled: true,
      size: "default",
      align: "right",
    };
  },
  computed: {
    _isResource() {
      return this.isResource;
    },
    ...mapGetters([
      "collectionPaginationData",
      "resourcePaginationData",
      "moduleNameActive",
      "moduleActionListActive",
    ]),
    _resourceData() {
      return this.resourcePaginationData;
    },
    _collectionData() {
      return this.collectionPaginationData;
    },
  },
  methods: {
    _paginationMsg(from, to, total) {
      var textShow = "Hiển thị 0 đến 0 của 0";
      if (typeof from !== "undefined" && typeof from !== null) {
        textShow = `Hiển thị ${from} đến ${to} của ${total}`;
      }
      return textShow;
    },
    _getTextPaginationCollection() {
      const from = this.collectionPaginationData.from;
      const to = this.collectionPaginationData.to;
      const total = this.collectionPaginationData.total;
      return this._paginationMsg(from, to, total);
    },
    _getCollectionResults(page) {
      const _self = this;
      if (!page) {
        page = 1;
      }
      const actionName =
        _self.moduleNameActive + "/" + _self.moduleActionListActive;
      _self.$store.dispatch(actionName, {
        perPage: _self.collectionPaginationData.per_page,
        page: page,
      });
    },
    _getTextPagination() {
      //console.log(`I ${'>:D<'} C#`)
      const from = this.resourcePaginationData.meta.from;
      const to = this.resourcePaginationData.meta.to;
      const total = this.resourcePaginationData.meta.total;
      return this._paginationMsg(from, to, total);
    },
    _getResourceResults(page) {
      const _self = this;
      if (!page) {
        page = 1;
      }
      const actionName =
        _self.moduleNameActive + "/" + _self.moduleActionListActive;
      _self.$store.dispatch(actionName, {
        perPage: _self.resourcePaginationData.meta.per_page,
        page: page,
      });
    },
  },
  watch: {
    limit(newVal) {
      this.limit = parseInt(newVal);
      if (this.limit < 0) {
        this.limit = 0;
      }
    },
  },
};
</script>
