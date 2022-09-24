<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <div id="elfinder"></div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <ul>
          <li>All Files</li>
        </ul>
        <table>
          <tbody>
            <tr v-for="(item, idx) in allFiles" :key="idx">
              <td v-if="item.type==='file'">{{item.name}}</td>
              <td v-else><a href="javascript:void(0)">{{item.name}}</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  import {
    fn_get_news_file_connector_url,
    fn_get_news_file_sound_url,
  } from '@app/api/utils/fn-helper'
  import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
  import axios from 'axios'

  export default {
    name: 'TabHoSo',
    data() {
      return {
        allFiles: []
      }
    },
    mounted() {
      const lmId = this.$route.params.linhmucId
        $((function() {
          $('#elfinder').elfinder({
            lang: 'vi',
            customData: {
              _token: $('meta[name="csrf-token"]').attr('content'),
            },
            url: fn_get_news_file_connector_url() + '?lmId=' + lmId,
            soundPath: fn_get_news_file_sound_url(),
          })
        }))
        // axios
        axios.get(fn_get_base_api_detail_url('/api/linh-mucs', lmId + '?_type=hoso&_dir=root'))
        .then((response) => {
          if (response.status === 200) {
            this.$data.allFiles = response.data.linhmuc.ho_sos
            console.log(response)
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

  <style lang="css" type="text/css" scoped>
  @import "../../../../../tools/barryvdh/jqueryui-1.10.4/jquery-ui.css";
  @import "../../../../../tools/barryvdh/css/elfinder.min.css";
  @import "../../../../../tools/barryvdh/css/theme.css";
  </style>