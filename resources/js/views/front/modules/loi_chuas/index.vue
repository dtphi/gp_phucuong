<template>
  <div class="say-gods" v-if="pageLists.length">
    <h4 class="tit-common mb-3">📖 Lời chúa</h4>
    <b-row>
      <b-col cols="5" class="col-mobile">
        <a class="d-block" :href="_getHref(_getLastedModuleInfo)">
          <img
            class="img"
            :src="_getLastedModuleInfo.imgThumMediumImg"
            alt=""
          />
        </a>
        <h4 class="tit-bg-common mt-2">
          <span><i class="bg-red">Nổi bật</i></span>
          <a :href="_getHref(_getLastedModuleInfo)">{{
            _getLastedModuleInfo.name
          }}</a>
        </h4>
        <p class="fs-16">
          <em>{{ _getLastedModuleInfo.sort_description }} </em>
        </p>
        <p class="info-post text-right">
          📖
          <span class="name font-weight-bold mr-1">Admin</span>
          <b-icon class="alarm" icon="alarm"></b-icon>
          <span>{{ _getLastedModuleInfo.date_available }}</span>
        </p>
      </b-col>
      <b-col cols="7" class="col-mobile">
        <div v-if="_getSecondInfoModuleList">
          <p class="info-post">
            <span>{{ _getSecondInfoModuleList.date_available }}</span>
            <span class="name font-weight-bold ml-1">Admin</span>
          </p>
          <h4 class="tit-bg-common">
            <span><i class="bg-green">Mới</i></span>
            <a :href="_getHref(_getSecondInfoModuleList)">{{
              _getSecondInfoModuleList.name
            }}</a>
          </h4>
          <p class="name-post font-weight-bold mb-2">Posted by Admin</p>
          <p class="mb-2 fs-16">
            <em>{{ _getSecondInfoModuleList.sort_description }} </em>
          </p>
          <a class="font-weight-bold" :href="_getHref(_getSecondInfoModuleList)"
            >Xem thêm</a
          >
          <hr />
        </div>
        <a
          :href="_getHref(item)"
          class="row-item-3 d-block mb-2 pb-2"
          v-for="(item, index) in _getInfoListModule"
          :key="index"
        >
          <span>
            <i class="status bg-orange">Nổi bật</i>
          </span>
          <span>
            {{ item.name }}
          </span>
          <span class="text-right">
            {{ item.date_available }}
          </span>
        </a>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_LOI_CHUA, } from 'store@front/types/module-types'
import { ACTION_GET_SETTING, } from 'store@front/types/action-types'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'

export default {
  name: 'ModuleLoiChua',
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState({
      settingCategorys: state => state.cfApp.setting.modules.module_loi_chua,
    }),
    _settingCategory() {
      return this.settingCategorys.module_loi_chua_categories
    },
    ...mapGetters(MODULE_MODULE_LOI_CHUA, ['pageLists']),
    _getInfoListModule() {
      let lists = []
      _.forEach(this.pageLists, (item, index) => {
        if (index >= 2) {
          lists.push(item)
        }
      })
      
      return lists
    },
    _getLastedModuleInfo() {
      return this.pageLists[0]
    },
    _getSecondInfoModuleList() {
      if (this.pageLists.length >= 2) {
        return this.pageLists[1]
      }
      
      return null
    },
  },
  mounted() {
    let moduleData = null
    const moduleName = 'module_loi_chua_categories'
    const isModule = (String(this.settingCategorys[moduleName]) !== 'undefined')
    if (isModule) {
      moduleData = this.settingCategorys.module_loi_chua_categories
    }
    this.getSetting(moduleData)
  },
  methods: {
    ...mapActions(MODULE_MODULE_LOI_CHUA, {
      getSetting: ACTION_GET_SETTING,
    }),
    _getHref(info) {
      if ((String(info['name_slug']) !== 'undefined') && (String(info['name_slug']).length > 5)) {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${info.name_slug}`)
      } else {
        return fn_get_href_base_url(`tin-tuc/chi-tiet/${fn_change_to_slug(info.name)}`)
      }
    },
    _getHrefCate() {
      return fn_get_href_base_url(`danh-muc-tin/${this.settingCategory[0].link}`)
    },
  },
  setting: {},
}
</script>
