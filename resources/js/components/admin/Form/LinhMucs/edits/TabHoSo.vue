<template>
  <div class="tab-content">
    <div class="form-group">
      <div class="col-sm-12">
        <div>
          <button class="btn btn-primary" type="button" @click="_showModalAdd">Thêm thư mục +</button>
          <form
                    method="post"
                    enctype="multipart/form-data"
                    v-on:submit.prevent="_onSubmit"
                >
                <label v-bind:for="fileInputId"><strong>Tải tập tin lên.</strong></label>
          <input v-on:change="_onSubmit" v-bind:id="fileInputId" ref="fileInput" type="file" name="fileHoSos[]" multiple/>
          </form>
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
      dirQuery: 'AllFiles',
      loading: false,
      errors: [],
    }
  },
  computed: {
    fileInputId() {
      return 'ho-so-file-input'
    },
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
    _onSubmit() {
      if (this.$refs.fileInput.files) {
        this.files = this.$refs.fileInput.files
        console.log(this.files)
        this._submit()
      }
    },
    _submit() {
      if (this.loading) return
      this.loading = true
      this.errors = []

      let requests = []
      for (let i=0;i<this.files.length;i++) {
        let file = this.files[i]
        file.index = i
        let upload = { name: file.name, type: file.type, loaded: 0, total: Math.max(100, file.size), success: false, error: false, }
        if (file.type) {
          requests.push(this._buildRequest(file))
        } else {
          upload.loaded = upload.total
          upload.error = 'Invalid file.'
        }
      }

      if (requests.length) {
        axios.all(requests).then(axios.spread(() => {
          if (this.errors.length == 0) {
            this.$emit('upload-success')
          } else {
            this.$emit('upload-error', this.errors)
          }
          this.loading = false
        }))
      } else {
        this.loading = false
      }
    },
    _buildRequest(file) {
      let formData = new FormData()
      formData.append('path', this.dirQuery)
      formData.append('fileHoSos', file)
      formData.append('linhmucId', this.linhmucId)

      let postUrl = '/api/linh-mucs?_type=hoso&_dir=' + this.dirQuery
      let headers = { "Content-Type": "multipart/form-data" }
      return axios.post(postUrl, formData, headers).then(response => {
        this._loadHoSo()
      }, error => {
        if (error.response && error.response.data && Array.isArray(error.response.data)) {
          let errors = error.response.data, message = ''
          for (let i=0;i<errors.length;i++) {
            this.errors.push(errors[i])
            if (errors[i].message)
              message+= errors[i].message
          }
        } else {
          this.errors.push({ message: error, })
        }
      })
    },
  }
}
</script>

<style lang="scss">

    label {
        display: block;
        cursor: pointer;
        font-size: 1.5em;
        font-weight: bold;
        span {
            font-weight: normal;
        }
    }

    input[type="file"] {
        display: none;
    }
</style>
