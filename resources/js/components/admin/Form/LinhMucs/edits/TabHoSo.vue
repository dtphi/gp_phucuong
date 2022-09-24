<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <div>
          <button type="button" @click="_showModalAdd">Thêm thư mục +</button>
          <button type="button">Tải file </button>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <ul class="breadcrumb" v-html="breadbrum">
        </ul>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <table>
          <tbody>
            <tr v-for="(item, idx) in allFiles" :key="idx">
              <td v-if="item.type==='file'"><a :href="item.url" target="_blank">{{item.name}}</a></td>
              <td v-else><a :href="item._dir">{{item.name}}</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <the-modal-add :linhmuc-id="linhmucId" :dir-query="dirQuery" @update-success="_loadHoSo"></the-modal-add>
  </div>
</template>

<script>
import {
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
import axios from 'axios'
import TheModalAdd from './TheModalAdd'

export default {
  name: 'TabHoSo',
  components: { TheModalAdd },
  data() {
    return {
      breadbrum: '',
      allFiles: [],
      linhmucId: null,
      dirQuery: 'AllFiles'
    }
  },
  mounted() {
    this.linhmucId = this.$route.params.linhmucId
    this.$data.dirQuery = (this.$route.query?._dir === undefined) ? 'AllFiles' : this.$route.query._dir

    this._loadHoSo()
  },
  methods: {
    _loadHoSo() {
      let loadUrl = fn_get_base_api_detail_url('/api/linh-mucs', this.linhmucId + '?_type=hoso&_dir=' + this.dirQuery)
      axios.get(loadUrl)
        .then((response) => {
          if (response.status === 200) {
            this.$data.breadbrum = response.data.linhmuc.breadbrum
            this.$data.allFiles = response.data.linhmuc.ho_sos
          }
        })
        .catch(errors => {
          if (errors.response) {
            console.log(errors)
          }
        })
    },
    _showModalAdd() {
      this.$modal.show('modal-ho-so-add')
    },
  }
}
</script>
