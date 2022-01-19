<template>
  <div id="special-module" v-if="_isExist">
    <h4 class="tit-highlights"><span>Nổi bật</span></h4>
    <b-row>
      <b-col cols="4" class="mb-3 col-mobile">
        <h4 class="tit-common">Sách nói</h4>
        <a
          :href="item.url_title"
          target="_blank"
          class="row-item-2"
          v-for="(item, index) in _getSachNoiList"
          :key="index"
        >
          <span>{{ item.title }}</span>
          <span v-if="item.author"
            ><i>🎙 {{ item.author }}</i></span
          >
        </a>
      </b-col>
      <b-col cols="4" class="mb-3 col-mobile">
        <h4 class="tit-common">Youtube</h4>
        <a
          :href="item.url_title"
          target="_blank"
          class="row-item-2"
          v-for="(item, index) in _getYoutubeList"
          :key="index"
        >
          <span>{{ item.title }}</span>
          <span v-if="item.author">
            <i>🎵{{ item.author }}</i>
          </span>
        </a>
      </b-col>
      <b-col cols="4" class="mb-3 col-mobile">
        <h4 class="tit-common">Hát thanh vịnh</h4>
        <a
          :href="item.url_title"
          target="_blank"
          class="row-item-2"
          v-for="(item, index) in _getHanhCacThanhList"
          :key="index"
        >
          <span>{{ item.title }}</span>
          <span v-if="item.author">
            <i>🎼{{ item.author }}</i>
          </span>
        </a>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import { MODULE_MODULE_NOI_BAT, } from 'store@front/types/module-types'
import { ACTION_GET_SETTING, } from 'store@front/types/action-types'

export default {
  name: 'ModuleNoiBat',
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState({
      settingCategorys: state => state.cfApp.setting.modules.module_noi_bat,
    }),
    ...mapGetters(MODULE_MODULE_NOI_BAT, [
      'settingSachNoi',
      'settingYoutube',
      'settingHanhCacThanh'
    ]),
    _isExist() {
      return (
        this.settingSachNoi.length ||
        this.settingYoutube.length ||
        this.settingHanhCacThanh.length
      )
    },
    _getSachNoiList() {
      const lists = _.remove(this.settingSachNoi, (item) => {
        return parseInt(item.status)
      })
      if (lists && lists.length) {
        return lists
      }
      
      return []
    },
    _getYoutubeList() {
      const lists = _.remove(this.settingYoutube, (item) => {
        return parseInt(item.status)
      })
      if (lists && lists.length) {
        return lists
      }
      
      return []
    },
    _getHanhCacThanhList() {
      const lists = _.remove(this.settingHanhCacThanh, (item) => {
        return parseInt(item.status)
      })
      if (lists && lists.length) {
        return lists
      }
      
      return []
    },
  },
  mounted() {
    let moduleData = null
    if (Object.keys(this.settingCategorys).length) {
      moduleData = this.settingCategorys
    }
    this.getSetting(moduleData)
  },
  methods: {
    ...mapActions(MODULE_MODULE_NOI_BAT, {
      getSetting: ACTION_GET_SETTING,
    }),
  },
  setting: {
    panel_title: 'Module Danh Mục Icon',
    frm_title: 'Thêm danh mục Icon',
    btn_save_txt: 'Lưu',
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>