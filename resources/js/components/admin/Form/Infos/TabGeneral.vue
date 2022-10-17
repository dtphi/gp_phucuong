<template>
  <div class="tab-content">
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label">{{
        $options.setting.name_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_name"
          rules="required|max:200"
          v-slot="{ errors }"
        >
          <input
            v-model="name"
            type="text"
            id="input-info-name"
            class="form-control"
            :placeholder="$options.setting.name_txt"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-sort-description" class="col-sm-2 control-label">{{
        $options.setting.info_sort_description_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_sort_description"
          rules="required|max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-sort-description"
            v-model="sort_description"
            class="form-control"
            :placeholder="$options.setting.info_sort_description_txt"
          ></textarea>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-description" class="col-sm-2 control-label">{{
        $options.setting.info_description_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_sort_description"
          rules="required"
          v-slot="{ errors }"
        >
          <tinymce
            id="input-info-description"
            :other_options="options"
            v-model="description"
          ></tinymce>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-meta-title" class="col-sm-2 control-label">{{
        $options.setting.info_meta_title_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_title"
          rules="required|max:255"
          v-slot="{ errors }"
        >
          <input
            id="input-info-meta-title"
            v-model="meta_title"
            class="form-control"
            :placeholder="$options.setting.info_meta_title_txt"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-meta-description" class="col-sm-2 control-label">{{
        $options.setting.info_meta_description_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_description"
          rules="max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-meta-description"
            v-model="meta_description"
            class="form-control"
            :placeholder="$options.setting.info_meta_description_txt"
          ></textarea>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-meta-keyword" class="col-sm-2 control-label">{{
        $options.setting.info_key_word_txt
      }}</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_meta_keyword"
          rules="max:500"
          v-slot="{ errors }"
        >
          <textarea
            id="input-info-meta-keyword"
            v-model="meta_keyword"
            class="form-control"
            :placeholder="$options.setting.info_key_word_txt"
          ></textarea>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group required">
      <label for="input-info-tac-gia" class="col-sm-2 control-label">
        {{ $options.setting.info_tac_gia_txt }}
      </label>
      <div class="col-sm-10 " >
        <validation-provider
          name="info_tac_gia"
          rules="required"
          v-slot="{ errors }"
        ><div class="col-sm-12" style="display: flex;padding-left: 0px;padding-right: 0px;">
        <select class="form-control" id="selecting-tac-gia" v-model="selected_tac_gia">
          <option value="" selected disabled hidden>Chọn tác giả</option>
          <option v-for="tacgia in tacgias" v-bind:value="tacgia.id"  >{{tacgia.name}}</option>
        </select>
        <button
              type="button"
              @click=""
              data-toggle="modal"
              :title="$options.setting.btn_them_tac_gia_txt"
              class="btn btn-primary"
              data-target="#tacgiaModal"
            >
              <i class="fa fa-plus"></i>
        </button>
        <div class="modal fade" id="tacgiaModal" tabindex="-1" >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">QUẢN LÝ TÁC GIẢ</h5>
                
              </div>
              <div class="modal-body">
                <div class="tabtable">
                  <ul class="nav nav-tabs">
                  <li role="presentation" class="active" id="listtacgiatab"><a data-toggle="tab" href="#listtacgia">Danh sách tác giả</a></li>
                  <li role="presentation" id="themtacgiatab"><a data-toggle="tab" href="#themtacgia">Thêm tác giả</a></li>
                </ul>
                <div class="tab-content" >
                  <div role="tabpanel" class="tab-pane fade in active" id="listtacgia">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th>Số thứ tự</th>
                            <th class="text-left">Tên tác giả</th>
                            <th style="width: 80px;">Sửa & Xóa</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="tacgia,index in tacgias">
                          <td style="width: 20%">{{index+1}}</td>
                          <td style="width: 65%" id="rowtacgia" v-if="tacgia.id !== edittedid">{{tacgia.name}}</td>
                          <td style="width: 65%" v-else>
                            <div class="col-md-12">
                              <form class="form-inline" >
                              <div class="form-group" style="padding-top:0px;padding-bottom:0px;">
                                <input type="text" class="form-control" v-model="edittedname" required>
                              </div>
                              <button type="button" @click="editTacgias()" class="btn btn-default">Sửa</button>
                              <button type="button" @click="edittedid=0" class="btn btn-default">Hủy</button>
                            </form>
                            </div>
                            </td>
                          <td class="text-center" style="width: 15%">
                            <i class="fa fa-pencil-square-o edit-item" title="Sửa" v-on:click="editFieldTacgias(tacgia.id,tacgia.name)" style="margin-right: 10px; cursor: pointer;"></i>
                            <i v-on:click="delTacgias(tacgia.id)" title="Xóa" class="fa fa-trash-o delete-item" style="cursor: pointer;"></i>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="themtacgia">
                    <div class="row form-horizontal">
                      <div class="col-md-12">
                          <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" style="border-radius: 0 !important;" class="form-control" id="newname" v-model="newname" placeholder="Nhập tên tác giả">
                                </div>
                                <div class="input-groups-btn col-md-12" style="margin-top: 5px;">
                                    <button type="button" class="btn btn-primary" style="border-radius: 0 3px 3px 0;" @click="addTacgias()"><i class="fa fa-save"></i>
                                        Lưu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                    
                </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <div class="form-group">
      <label for="input-info-tag" class="col-sm-2 control-label">
        <span
          data-toggle="tooltip"
          :data-original-title="$options.setting.info_tag_tooltip_txt"
          >{{ $options.setting.info_tag_txt }}</span
        >
      </label>
      <div class="col-sm-10">
        <validation-provider
          name="info_tag"
          rules="max:255"
          v-slot="{ errors }"
        >
          <input
            id="input-info-tag"
            v-model="tag"
            class="form-control"
            :placeholder="$options.setting.info_tag_txt"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
  </div>
</template>

<script>
import tinymce from 'vue-tinymce-editor'
import { MODULE_INFO_ADD, } from 'store@admin/types/module-types'
import { createHelpers, } from 'vuex-map-fields'
import { MAP_PC_INFORMATIONS, } from 'store@admin/types/model-map-fields'
const { mapFields, } = createHelpers({
  getterType: `${MODULE_INFO_ADD}/getInfoField`,
  mutationType: `${MODULE_INFO_ADD}/updateInfoField`,
})

export default {
  name: 'TabGeneralForm',
  components: {
    tinymce,
  },
  props: {
    media: {
      type: Object,
    },
    mmSelected: {
      default() {
        return {}
      },
    },
    mmPath: {
      type: String,
      default() {
        return ''
      },
    },
  },
  data() {
    const elFileContent = document.getElementById('media-file-manager-content')
    const options = this.$cmsCfg.tinymce.options((callback) => {
      this.fn = callback
      elFileContent.style = this.$options.setting.cssDisplay
    })
    
    return {
      fn: null,
      options: options,
      tacgias:[],
      newname:'',
      edittedname:'',
      edittedid:0,
    }
  },
  computed: {
    ...mapFields(MAP_PC_INFORMATIONS), 
  },
  mounted() {
      this.getTacgiasList()
    },
  watch: {
    mmPath(val) {
      this._updateImageField(val)
    },
  },
  methods: {
    _updateImageField(path) {
      if (typeof this.fn === 'function') {
        this.fn(path, this.mmSelected)
      }
      
    },
    getTacgiasList(){
      var self = this
      var url = 'http://127.0.0.1/api/informations/getlisttacgias';
      $.getJSON(url, function(json) {
       self.tacgias = json
      //console.log(self.tacgias)
      });
    },
    delTacgias(id){
      var self = this
      var url = 'http://127.0.0.1/api/informations/deltacgias?id='+id;
      $.getJSON(url, function(json) {
       if(json==true)
        self.getTacgiasList()
        else alert("Xoa That Bai")
      });
    },
    addTacgias(){
      var self = this
      var name = self.newname
      var url = 'http://127.0.0.1/api/informations/addtacgias?name='+name;
      $.getJSON(url, function(json) {
       if(json==true){
        self.getTacgiasList()
        $('.nav-tabs a[href="#listtacgia"]').tab('show');
        self.newname=""
       }
       else alert("them that bai")
        
      });
    },
    editFieldTacgias(id,name){
      var self = this
      self.edittedid=id
      self.edittedname=name
    },
    editTacgias(){
      var self = this
      var name=self.edittedname
      var id=self.edittedid
      var url = 'http://127.0.0.1/api/informations/edittacgias?id='+id+'&name='+name;
      $.getJSON(url, function(json) {
       if (json){
        self.edittedname=''
        self.edittedid=0
        self.getTacgiasList()
       }
       else alert("Sua that bai")
      
      });
    },
  },
  setting: {
    cssDisplay: 'display:block',
    cssDisplayNone: 'display:none',
    name_txt: 'Tên',
    info_sort_description_txt: 'Mô tả',
    info_description_txt: 'Nội dung',
    info_key_word_txt: 'Từ khóa mô tả',
    info_meta_title_txt: 'Thẻ meta tiêu đề',
    info_meta_description_txt: 'Thẻ meta mô tả',
    info_tag_txt: 'Tags',
    info_tag_tooltip_txt: 'Ngăn cách bởi dấu phẩy',
    info_tac_gia_txt: 'Tác giả',
    btn_them_tac_gia_txt:"Thêm tác giả"
  },
}
</script>
