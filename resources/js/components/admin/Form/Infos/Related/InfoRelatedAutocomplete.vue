<template>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="input-info-related">
      <span
        data-toggle="tooltip"
        title=""
        data-original-title="(Tự động hoàn toàn)"
        >{{ $options.setting.paren_category_txt }}</span
      >
    </label>
    <div class="col-sm-10">
      <input
        autocomplete="off"
        v-on:focus="_focusRelatedInfo"
        v-on:keyup.enter="_searchProducts()"
        v-model="query"
        type="text"
        name="informations"
        :placeholder="$options.setting.paren_category_txt"
        id="input-info-related"
        class="form-control"
      />
      <ul class="dropdown-menu cms-ul-cate-dropdown" :style="dropdownStyle">
        <li>
          <span
            class="btn btn-default cms-btn-dropdown"
            @click="_closeDropdown"
          >
            <font-awesome-layers size="2x" style="background: MistyRose">
              <font-awesome-icon icon="circle" style="color: Tomato" />
              <font-awesome-icon
                icon="times"
                class="fa-inverse"
                transform="shrink-4"
              />
            </font-awesome-layers>
          </span>
        </li>
        <the-dropdown-related
          :key="-1"
          :information="itemNone"
        ></the-dropdown-related>

        <the-dropdown-related
          v-for="(item, idx) in dropdowns"
          :key="idx"
          :information="item"
        ></the-dropdown-related>
      </ul>

      <div
        v-if="relateds.length"
        key="related-category-result-list"
        class="well well-sm"
        style="height: 150px; overflow: auto"
      >
        <related-item
          v-for="(item, idx) in relateds"
          :key="idx"
          :info-to-related="item"
        ></related-item>
      </div>
      <div
        v-else
        key="related-category-result-empty"
        class="well well-sm"
        style="height: 150px; overflow: auto"
      ></div>
    </div>
  </div>
</template>
e
<script>
import { mapState, mapActions, } from 'vuex'
import TheDropdownRelated from './DropdownToInfoRelatedAutocomplete'
import { MODULE_INFO_ADD, } from 'store@admin/types/module-types'
import {
  ACTION_GET_DROPDOWN_RELATED_LIST,
  ACTION_ADD_INFO_TO_RELATED_LIST,
} from 'store@admin/types/action-types'
import RelatedItem from './RelatedItem'

export default {
  name: 'InfoRelatedAutocomplete',
  components: {
    TheDropdownRelated,
    RelatedItem,
  },
  props: {
    categoryId: {
      default: 0,
    },
  },
  data() {
    return {
      dropdownStyle: this.$options.setting.cssDisplayNone,
      itemNone: {
        information_id: 0,
        name: ' --- Chọn --- ',
      },
      query: '',
    }
  },
  computed: {
    ...mapState(MODULE_INFO_ADD, {
      relateds: (state) => state.listRelatedsDisplay,
      dropdowns: (state) => state.dropdownsRelateds,
      infoRelated: (state) => state.infoRelated,
    }),
  },
  watch: {
    query: {
      handler: _.debounce(() => {
        this._searchRelateds()
      }, 100),
    },
    infoRelated: {
      handler: function(val) {
        this._addInfoToRelated(val)
      },
    },
  },
  methods: {
    ...mapActions(MODULE_INFO_ADD, [
      ACTION_GET_DROPDOWN_RELATED_LIST,
      ACTION_ADD_INFO_TO_RELATED_LIST
    ]),
    _searchRelateds() {
      const query = this.query?.length
      if (query && (parseInt(query) > 0)) {
        this[ACTION_GET_DROPDOWN_RELATED_LIST](query)
      }
    },
    _focusRelatedInfo() {
      const query = this.query
      this[ACTION_GET_DROPDOWN_RELATED_LIST](query)
      this.$data.dropdownStyle = this.$options.setting.cssDisplay
    },
    _closeDropdown() {
      this.$data.dropdownStyle = this.$options.setting.cssDisplayNone
    },
    _addInfoToRelated(info) {
      info = this.$deep(info)
      this[ACTION_ADD_INFO_TO_RELATED_LIST](info)
    },
  },
  setting: {
    cssDisplay: 'display:block;',
    cssDisplayNone: 'display:none;',
    paren_category_txt: 'Tin tức liên hệ',
  },
}
</script>

<style type="text/css" lang="css" scoped>
.cms-ul-cate-dropdown {
  top: 35px;
  left: 15px;
}
.cms-ul-cate-dropdown > li > a:hover,
.cms-dropdown-menu > li > a:focus {
  background-color: green !important;
}
.cms-btn-dropdown {
  position: absolute;
  right: 0px;
  top: 0px;
  font-size: 0.5em;
}
</style>
