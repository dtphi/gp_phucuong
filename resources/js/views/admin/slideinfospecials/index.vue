<template>
  <div id="content">
    <the-header-page></the-header-page>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <i class="fa fa-list"></i> {{ $options.setting.list_title }}
          </h3>
        </div>
        <div class="panel-body">
          <div id="form-category">
            <div class="table-responsive">
              <template v-if="loading">
                <loading-over-lay
                  :active.sync="loading"
                  :is-full-page="fullPage"
                ></loading-over-lay>
              </template>
              <template v-if="_infoList">
                <div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr role="row">
                        <th style="width: 5%" class="text-left">No</th>
                        <th style="width: 5%" class="text-center">
                          <input
                            type="checkbox"
                            onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"
                          />
                        </th>
                        <th style="width: 50%" class="text-left">Tên</th>
                        <th style="width: 5%" class="text-left">Hình ảnh</th>
                        <th style="width: 12%" class="text-center">
                          Ngày hoạt động
                        </th>
                        <th style="width: 13%" class="text-center">Ngày tạo</th>
                        <th class="text-center">Trạng thái</th>
                        <th style="width: 10%" class="text-center">
                          <select @change="_submitAction" class="form-control">
                            <option>Thêm</option>
                            <option value="module_special_info_ids">
                              Tiêu điểm
                            </option>
                          </select>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <item
                        v-for="(item, index) in _infoList"
                        :info="item"
                        :no="index"
                        :key="item.id"
                      ></item>
                    </tbody>
                  </table>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import Item from './components/TheItem'
import TheHeaderPage from './components/TheHeaderPage'
import { MODULE_INFO, } from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'

export default {
  name: 'InformationList',
  components: {
    TheHeaderPage,
    Item,
  },
  data() {
    return {
      fullPage: false,
      isResource: false,
    }
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  computed: {
    ...mapState({
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapGetters(['isNotEmptyList']),
    ...mapState(MODULE_INFO, ['infos', 'loading', 'updateSuccess']),
    _infoList() {
      return this.infos
    },
    _notEmpty() {
      return this.isNotEmptyList
    },
  },
  methods: {
    ...mapActions(MODULE_INFO, {
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
      module_special_info_ids: 'module_special_info_ids',
      get_module_special_info_and_info_ids: 'get_module_special_info_and_info_ids',
    }),
    _submitAction(event) {
      this[event.target.value]({
        action: event.target.value,
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification()
    },
  },
  mounted() {
    this.get_module_special_info_and_info_ids()
  },
  setting: {
    list_title: 'Danh sách tin tức',
  },
}
</script>
