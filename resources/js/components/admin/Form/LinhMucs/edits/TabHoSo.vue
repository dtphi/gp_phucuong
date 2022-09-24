<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <ul class="breadcrumb" v-html="breadbrum">
        </ul>
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
  </div>
</template>

<script>
  import {
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
  import axios from 'axios'

  export default {
    name: 'TabHoSo',
    data() {
      return {
        breadbrum: '',
        allFiles: []
      }
    },
    mounted() {
      const lmId = this.$route.params.linhmucId
      const dirQuery = (this.$route.query?._dir === undefined) ? 'AllFiles': this.$route.query._dir;

        // axios
        axios.get(fn_get_base_api_detail_url('/api/linh-mucs', lmId + '?_type=hoso&_dir=' + dirQuery))
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
  }
  </script>
