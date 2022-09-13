<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <div id="elfinder"></div>
      </div>
    </div>
  </div>
</template>

<script>
  import {
    fn_get_news_file_connector_url,
    fn_get_news_file_sound_url,
  } from '@app/api/utils/fn-helper'

  export default {
    name: 'TabHoSo',
    data() {
      return {
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
    },
  }
  </script>

  <style lang="css" type="text/css" scoped>
  @import "../../../../../tools/barryvdh/jqueryui-1.10.4/jquery-ui.css";
  @import "../../../../../tools/barryvdh/css/elfinder.min.css";
  @import "../../../../../tools/barryvdh/css/theme.css";
  </style>

