<template>
  <b-col
    id="tin-giao-hoi-viet-nam"
    cols="6"
    class="col-mobile"
    v-if="pageLists.length"
  >
    <div class="new mt-3">
      <div>
        <h4 class="tit-common mb-3">📒 Tin giáo hội việt nam</h4>
        <p class="info-post mb-2">
          👤
          <span class="name font-weight-bold mr-1">Admin</span>
          <b-icon class="alarm" icon="alarm"></b-icon>
          <span>{{ _getLastedModuleInfo.date_available }}</span>
        </p>
        <h4 class="tit-bg-common">
          <span><i class="bg-green">live</i></span>
          <a :href="_getHref(_getLastedModuleInfo)"
            >{{ _getLastedModuleInfo.sort_name }} ...</a
          >
        </h4>
        <p class="name-post font-weight-bold mb-2">Posted by Admin</p>
        <a class="d-block" :href="_getHref(_getLastedModuleInfo)">
          <img
            class="img"
            :src="_getLastedModuleInfo.imgThumMediumImg"
            alt=""
          />
        </a>
        <p class="mt-2 fs-16">
          <em>{{ _getLastedModuleInfo.sort_description }}</em>
          <a class="font-weight-bold" :href="_getHref(_getLastedModuleInfo)"
            >Xem thêm</a
          >
        </p>
        <hr />
      </div>
      <a
        :href="_getHref(item)"
        class="row-item-3 d-block mb-2 pb-2"
        v-for="(item, index) in _getInfoListModule"
        :key="index"
      >
        <span>
          <i class="status bg-red">hot</i>
        </span>
        <span
          >📃
          <i>{{ item.name }}</i>
        </span>
        <span
          >👤
          <i>Admin</i>
        </span>
      </a>
    </div>
  </b-col>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_TIN_GIAO_HOI_VIET_NAM, } from 'store@front/types/module-types'
import { ACTION_GET_SETTING, } from 'store@front/types/action-types'
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'

export default {
  name: 'ModuleTinGiaoHoiVietNam',
  components: {},
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState({
      settingCategorys: state => state.cfApp.setting.modules.module_tin_giao_hoi_viet_nam,
    }),
    ...mapGetters(MODULE_MODULE_TIN_GIAO_HOI_VIET_NAM, [
      'settingCategory',
      'pageLists'
    ]),
    _getInfoListModule() {
      let lists = []
      _.forEach(this.pageLists, (item, index) => {
        if (index) {
          lists.push(item)
        }
      })
      
      return lists
    },
    _getLastedModuleInfo() {
      return this.pageLists[0]
    },
  },
  mounted() {
    let moduleData = null
    const moduleName = 'module_tin_giao_hoi_viet_nam_categories'
    const isModule = (String(this.settingCategorys[moduleName]) !== 'undefined')
    if (isModule) {
      moduleData = this.settingCategorys.module_tin_giao_hoi_viet_nam_categories
    }
    this.getSetting(moduleData)
  },
  methods: {
    ...mapActions(MODULE_MODULE_TIN_GIAO_HOI_VIET_NAM, {
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
