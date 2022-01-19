<template>
    <div class="tab-content">
        <div class="form-group">
            <div class="col-sm-12">
              <table
                class="table table-striped table-bordered table-hover"
              >
                <thead>
                  <tr>
                    <td
                    v-for="(item, idx) in groupData.giao_phan_hats"
                    :key="idx"><a :href="`#link-giao-hat-${item.id}`">#{{ item.hatName }}</a></td>
                  </tr>
                </thead>
              </table>
              <info-list :lists="groupData.giao_phan_hats"></info-list>
            </div>
        </div>
    </div>
</template>

<script>
import InfoList from './HatXuGiaoPhans/InfoList'

export default {
  name: 'TabHatXuGiaoPhan',
  components: {
    InfoList,
  },
  props: {
    groupData: {
      type: Object,
    },
  },
  data() {
    return {
      giao_phan_hat_xus: [],
    }
  },
}
</script>
