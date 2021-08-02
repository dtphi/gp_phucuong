<template>
  <div class="tab-content">
    <!-- Tên dòng -->
    <div class="form-group required">
      <label for="input-info-name" class="col-sm-2 control-label"
        >Tên dòng</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_name_dong"
          rules="required|max:100"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.name"
            type="text"
            id="input-info-name"
            class="form-control"
            placeholder="Tên dòng"
          />

          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Giáo xứ thuộc giáo phận -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-giaophan"
        >Thuộc giáo phận</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_giaophan"
          rules="max:50"
          v-slot="{ errors }"
        >
          <select v-model="groupData.giaophan_id" class="form-control">
            <option
              v-for="item in isGiaoPhan"
              v-bind:value="item.id"
              :key="item.id"
            >
              {{ item.name }}
            </option>
          </select>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Địa chỉ-->
    <div class="form-group">
      <label for="input-info-dia-chi" class="col-sm-2 control-label"
        >Địa chỉ</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_dia_chi"
          rules="max:500"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.dia_chi"
            type="text"
            id="input-info-diachi"
            class="form-control"
            placeholder="Địa chỉ"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Điện thoại -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-dien-thoai"
        >Điện thoại</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_dien_thoai"
          rules="max:50"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.dien_thoai"
            type="text"
            id="input-info-dien-thoai"
            class="form-control"
            placeholder="Điện thoại"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Email -->
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-info-email">Email</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_email"
          rules="max:50|email"
          v-slot="{ errors }"
        >
          <input
            v-model="groupData.email"
            type="email"
            id="input-info-email"
            class="form-control"
            placeholder="Email"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Active -->
    <div class="form-group">
      <label for="input-info-active" class="col-sm-2 control-label"
        >Trạng thái</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_active"
          rules="max:255"
          v-slot="{ errors }"
        >
          <select
            v-model="groupData.active"
            id="input-info-active"
            class="form-control"
          >
            <option value="1" selected="selected">Xảy ra</option>
            <option value="0">Ẩn</option>
          </select>
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Viet -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-viet">Việt</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_viet"
          rules="required|max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.viet"
            placeholder="Việt"
            id="input-info-viet"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Latin -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-latin">Latin</label>
      <div class="col-sm-10">
        <validation-provider
          name="info_latin"
          rules="required|max:191"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.latin"
            placeholder="Latin"
            id="input-info-latin"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
    <!-- Nội dung -->
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-info-noidung"
        >Nội dung</label
      >
      <div class="col-sm-10">
        <validation-provider
          name="info_noi_dung"
          rules="required|max:255"
          v-slot="{ errors }"
        >
          <input
            type="text"
            v-model="groupData.noi_dung"
            placeholder="Nội dung"
            id="input-info-noidung"
            class="form-control"
          />
          <span class="cms-text-red">{{ errors[0] }}</span>
        </validation-provider>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { config } from "@app/common/config";
import { fn_get_tinymce_langs_url } from "@app/api/utils/fn-helper";
import { MODULE_MODULE_DONG_EDIT } from "store@admin/types/module-types";
import tinymce from "vue-tinymce-editor";

export default {
  name: "TabGeneralFormAddDong",
  components: {
    tinymce,
  },
  data() {
    const _self = this;
    return {
      editor: null,
      fn: null,
      mm: new MM({
        el: "#modal-general-info-manager",
        api: {
          baseUrl: window.origin + "/api/mmedia",
          listUrl: "list",
          uploadUrl: "upload",
        },
        onSelect: function (fi) {
          if (typeof fi === "object") {
            if (fi.hasOwnProperty("selected") && fi.selected) {
              if (fi.selected.hasOwnProperty("path")) {
                if (_self.fn) {
                  _self.fn("Image/NewPicture/" + fi.selected.path, fi.selected);
                }
                document.getElementById("media-file-manager-content").style =
                  "display:none";
              }
            }
          }
        },
      }),
      options: {
        language_url: fn_get_tinymce_langs_url("vi_VN"),
        height: "200",
        image_prepend_url: window.origin + "/",
        referrer_policy: "strict-origin-when-cross-origin",
        file_picker_callback: function (callback, value, meta) {
          if (meta.filetype === "file") {
            _self.fn = callback;
            document.getElementById("media-file-manager-content").style =
              "display:block";
          }

          if (meta.filetype === "image") {
            if (_self.mm == null) {
              _self.mm = new MM({
                el: "#modal-general-info-manager",
                api: {
                  baseUrl: window.origin + "/api/mmedia",
                  listUrl: "list",
                  uploadUrl: "upload",
                },
                onSelect: function (fi) {
                  if (typeof fi === "object") {
                    if (fi.hasOwnProperty("selected") && fi.selected) {
                      if (fi.selected.hasOwnProperty("path")) {
                        if (_self.fn) {
                          _self.fn(
                            "Image/NewPicture/" + fi.selected.path,
                            fi.selected
                          );
                        }
                        document.getElementById(
                          "media-file-manager-content"
                        ).style = "display:none";
                      }
                    }
                  }
                },
              });

              document.getElementById("media-file-manager-content").style =
                "display:block";
            } else {
              _self.fn = callback;
              document.getElementById("media-file-manager-content").style =
                "display:block";
            }
          }

          if (meta.filetype === "media") {
            _self.fn = callback;
            document.getElementById("media-file-manager-content").style =
              "display:block";
          }
        },
        toolbar2:
          "undo redo | styleselect | fontsizeselect | fontselect | image ",
        font_formats:
          "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
      },
    };
  },
  computed: {
    ...mapState(MODULE_MODULE_DONG_EDIT, {
      groupData: (state) => {
        console.log(state.info);
        return state.info || {};
      },
      isGiaoPhan: (state) => {
        return state.listGiaoPhan;
      },
    }),
    _errors() {
      return this.errors.length;
    },
  },
  watch: {
    groupData: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
        if (Object.keys(newValue).length) {
          return (newValue.khuvuc =
            newValue.khuvuc === null ? "" : newValue.khuvuc);
        }
      },
    },
  },
  setting: {
    cf: config,
  },
};
</script>
