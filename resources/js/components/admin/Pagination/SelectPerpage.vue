<template>
  <select @change="_getResourceResults" class="form-control">
    <option
      :selected="_isSelectedCurrent(item)"
      v-for="(item, idx) in $options.setting.perPageList"
      :value="item"
      :key="idx"
    >
      {{ item }}
    </option>
  </select>
</template>

<script>
import { mapState, mapGetters, } from 'vuex'
import AppConfig from '@app/api/admin/constants/app-config'

export default {
  name: 'SelectPerpage',
  computed: {
    ...mapState({
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapGetters(['moduleNameActive', 'moduleActionListActive']),
  },
  methods: {
    _getResourceResults(event) {
      const _self = this
      var perPage = event.target.value
      const actionName =
        _self.moduleNameActive + '/' + _self.moduleActionListActive
      _self.$store.dispatch(actionName, {
        perPage: parseInt(perPage),
      })
    },
    _isSelectedCurrent(item) {
      if (this.perPage && item) {
        if (parseInt(this.perPage) === parseInt(item)) {
          return 'selected'
        }
      }

      return ''
    },
  },
  setting: {
    perPageList: AppConfig.perPageValues,
  },
}
</script>
