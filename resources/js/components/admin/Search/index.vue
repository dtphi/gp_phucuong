<template>
    <ul class="cms-breadcrumb">
        <li>
            <input
                v-model="query"
                type="text"
                class="form-control"
                placeholder="Search"
                aria-describedby="basic-addon2"
            />
        </li>
        <li>
            <button
                class="btn btn-primary btn-search"
                @click="getResults"
                @keyup.enter="getResults"
                type="button"
            >
                Search
            </button>
        </li>
    </ul>
</template>

<script>
import { mapMutations, } from 'vuex'
import { MODULE_MODULE_RESTRICT_IP, } from 'store@admin/types/module-types'
import {
  INFOS_SET_INFO_LIST,
} from 'store@admin/types/mutation-types'
export default {
  name: 'ListSearch',
  data() {
    return {
      query: '',
    }
  },
  watch: {
    query: {
      handler: _.debounce(function() {
        this.getResults()
      }, 500),
    },
  },
  methods: {
    ...mapMutations(MODULE_MODULE_RESTRICT_IP, {
      'setResIp': INFOS_SET_INFO_LIST,
    }),
    getResults() {
      axios.get('/api/search-ips', { params: { query: this.query, }, })
        .then(res => { console.log(res.data.data.results, 'res')
          console.log(this)
          this.setResIp(res.data.data.results)  })
        .catch(error => { console.log(error) })
    },
  },
}
</script>
<style scoped>
  .btn-search {
    margin-left: 0.7rem;
  }
</style>
