<template>
  <main id="news" class="py-2">
    <div class="container">
      <main-menu></main-menu>
      <div
        style="background-color: #80808008"
        :style="{ backgroundColor: contentBgColor }"
      >
        <content-top v-if="_isContentTop">
          <template v-if="loading">
            <loading-over-lay
              :active.sync="loading"
              :is-full-page="fullPage"
            ></loading-over-lay>
          </template>
          <template #column_right>
            <social-network></social-network>
            <div class="box-social">
              <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
            </div>
          </template>
        </content-top>
        <main-content v-if="_isContentMain">
          <template #before>
            <!-- Html linh mục detail -->
            <div class="col-mobile col-12">
              <div class="detail-linh-muc w-100">
                <div class="box-grandpa row">
                  <div class="col-mobile col-4" ref="leftColumn">
                    <div class="bi-tich p-3 mt-3">
                      <div
                        class="d-block avatar-img mt-3"
                        style="margin-bottom: 15px"
                      >
                        <img
                          class="img"
                          :src="`${pageLists.image}`"
                          :alt="pageLists.ten"
                        />
                      </div>
                      <p class="col-4 text-uppercase">Linh mục</p>
                      <div class="col-8">
                        <p
                          style="font-size: 20px; margin-bottom: 0.1rem"
                          class="text-uppercase"
                        >
                          {{ pageLists.ten_thanh }}
                        </p>
                        <p
                          style="
                            font-weight: bold;
                            font-size: 16px;
                            margin-bottom: 0.1rem;
                          "
                          class="text-uppercase"
                        >
                          {{ pageLists.ten }}
                        </p>
                        <p v-if="pageLists.ngay_rip">RIP: {{pageLists.ngay_rip}}</p>
                        <p v-else>{{ pageLists.cv_hien_tai }}</p>
                      </div>
                      <h4 class="text-uppercase text-center mb-3">Bí tích</h4>
                      <a
                        style="font-size: 25px"
                        class="d-block"
                        href="javascript:void(0);"
                        >Bí tích Rửa Tội</a
                      >
                      <p
                        style="margin-bottom: 2rem; font-size: 20px"
                        class="d-block"
                      >
                        {{pageLists.noi_rua_toi}}<br>
                        {{ pageLists.ngay_rua_toi }}
                      </p>
                      <a
                        style="font-size: 25px"
                        class="d-block"
                        href="javascript:void(0);"
                        >Bí tích Thêm sức
                      </a>
                      <p
                        style="margin-bottom: 2rem; font-size: 20px"
                        class="d-block"
                      >
                        {{pageLists.noi_them_suc}}<br>
                        {{ pageLists.ngay_them_suc }}
                      </p>
                      <a
                        style="font-size: 25px"
                        class="d-block"
                        href="javascript:void(0);"
                        >Bí tích Truyền Chức
                      </a>
                      <p
                        style="margin-bottom: 2rem; font-size: 20px"
                        v-for="(value, idx) in pageLists.ds_chuc_thanh"
                        :key="idx + 'B'"
                        class="d-block"
                      >
                        {{ idx + 1 + ". " + chucThanh[value.chuc_thanh_id]
                        }}<br />
                        <span style="font-size: 14px"
                          >Thụ phong bởi Đức Cha:<br />
                          {{ _ngThuPhong(value.nguoi_thu_phong) }}</span
                        ><br />
                        <span style="font-size: 14px"
                          >Tại: {{ value.noi_thu_phong }}</span
                        ><br />
                        <span style="font-size: 14px"
                          >Ngày :
                          {{ value.label_ngay_thang_nam_chuc_thanh }}</span
                        ><br />
                      </p>
                      <h5 v-if="pageLists.ngay_rip">RIP: {{pageLists.ngay_rip}}</h5>
                    <button type="button" class="btn btn-primary" @click="exportFileLinhMuc(pageLists.id, pageLists.ten)">Xuất file</button>
                    <b-button variant="primary" v-b-modal.modal-1 hidden>Quản Lý Hồ Sơ</b-button>
                    <b-modal id="modal-1" title="Files management">
                      <b-breadcrumb :items="items"></b-breadcrumb>
                      <p class="my-4">All files</p>
                    </b-modal>
                  </div>
                  <!-- <div class="bi-tich p-3 mt-3">
                          <table class="table mb-0 tbl-server-info">
                    
                            <tbody>
                              <tr v-for="(item,index) in root">
                              
                                <td @click="showReview(item)" role="button">
                                    <b-icon :icon="item.type == 'file' ? IconShow(item.name) : 'folder-fill'" class="mr-1"></b-icon>  {{item.name}}
                                </td>
                              
                              </tr>
                            </tbody>
                          </table>
                        
                  </div> -->
                  <!-- <div class="bi-tich p-3 mt-3">
                  <div v-if="isImg==='img'">
                    <a :href="'http://'+itemselect" target="_blank">
                    <img :src="'http://'+itemselect" width="100%" />
                  </a>
                  </div>
                  <div v-else-if="isImg==='file'">
                    <a :href="'http://'+itemselect" target="_blank">
                    <img :src="'http://'+downloadimg" width="100%" alt="Click để tải tài liệu." />
                  </a>
                  </div>
                  <div v-else>
                    
                    <img :src="'http://'+defaultimg" width="100%" alt="Click để tải tài liệu." />
                 
                  </div>
                  </div> -->
                  </div>
                  <div class="col-mobile col-8" ref="rightColumn">
                    <div class="info-personal mt-5" style="font-size: 0.87rem">
                      <h4 class="text-uppercase">Thông tin cá nhân</h4>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-5">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 97px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >..................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 97px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...............................................</label
                          >
                          Ngày sinh:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{pageLists.nam_sinh}}</label
                          ></span
                        >
                        <span class="col-mobile col-6">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 39px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...............................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 41px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >............................................................</label
                          >
                          tại:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.dia_chi }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-5">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >......................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................................</label
                          >
                          Giáo xứ:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.sinh_giao_xu }}</label
                          >
                        </span>
                        <span class="col-mobile col-6">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 100px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >.................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 99px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...............................................</label
                          >
                          Giáo phận:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.giao_phan }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-11">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 82px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >..........................................................................................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 82px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................................</label
                          >
                          Tên cha:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.ho_ten_cha }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-11">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 78px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...........................................................................................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 78px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >....................................................</label
                          >
                          Tên mẹ:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.ho_ten_me }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-11">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 71px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >.............................................................................................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 71px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >.....................................................</label
                          >
                          CMND:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.so_cmnd }}</label
                          >
                        </span>
                      </p>
                      <p style="margin-bottom: 0.3rem" class="row">
                        <span class="col-mobile col-5">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 94px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 93px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >................................................</label
                          >
                          Ngày cấp:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ $helper.fn_format_dd_mm_yyyy(pageLists.ngay_cap_cmnd) }}</label
                          >
                        </span>
                        <span class="col-mobile col-6">
                          <label
                            class="doted-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >......................................</label
                          >
                          <label
                            class="doted-xs-bottom"
                            style="
                              position: absolute;
                              left: 80px;
                              top: 0px;
                              font-weight: 400;
                            "
                            >...................................................</label
                          >
                          Nơi cấp:
                          <label
                            style="
                              position: absolute;
                              top: -3px;
                              padding-left: 10px;
                              font-style: italic;
                            "
                            >{{ pageLists.noi_cap_cmnd }}</label
                          >
                        </span>
                      </p>
                    </div>
                    <div class="maxim text-center">
                      <h4
                        class="tit-maxim"
                        :style="`border: 4px solid ${logoBgColor}`"
                      >
                        Châm ngôn đời linh mục
                      </h4>
											<div class="text-center">
												<h3>{{pageLists.cham_ngon}}</h3>
											</div>
                    </div>
                    <div>
                      <h3>HOẠT ĐỘNG SỨ VỤ</h3>
                      <a
                        :href="`/linhmucadmin/dashboard?linhmucId=${pageLists.id}`"
                        >Đến trang quản trị</a
                      >
                      <vue-timeline-update
                        v-for="item in pageLists.ds_chuc_vu"
                        :key="item.id + 'A'"
                        :date="new Date()"
                        :dateString="item.label_from_date"
                        :category="`Chức vụ: ${item.chucvuName}`"
                        :title="`- <a href='/giao-xu/chi-tiet/${item.giao_xu_id}'>${diadiem(item)}</a>`"
                        :description="_des(item)"
                        icon="history"
                      />
                    </div>
                    <div v-if="compareColumn()" v-bind:style="spaceDiv"></div>
                    <b-alert v-model="showFolderSuccessAlert" variant="success" dismissible>
                      Đã tạo thư mục thành công!
                      </b-alert>
                    <b-alert v-model="showFileSuccessAlert" variant="success" dismissible>
                      Đã thêm tệp mới thành công!
                      </b-alert>
                      <b-alert v-model="delFileFailedAlert" variant="danger" dismissible>
                      Xóa thất bại, xin thử lại!
                      </b-alert>
                      <b-alert v-model="showFileFailedAlert" variant="danger" dismissible>
                      Thêm thất bại, xin thử lại!
                      </b-alert>
                    <div class="bi-tich p-3 mt-3" :class="compareColumn()?'box-ho-so':''" ref="tableBox" style="min-height:500px;">

                      <h3>QUẢN LÝ HỒ SƠ</h3>

                      <!-- <b-breadcrumb-item v-for="item in lstlink" v-on:click.prevent="test(item)">{{item}}</b-breadcrumb-item> -->
                    
                      <b-row >
                        <b-col cols="auto" class="mr-auto p-3"><b-link v-for="item,index in lstlink" v-on:click.prevent="breadCum(item)" v-bind:key="item.id" :disabled="index==lstlink.length-1?true:false">{{item}} > </b-link></b-col>
                        <b-col cols="auto" class="p-3"><b-dropdown variant="primary" id="dropdown-1" size="sm"  no-caret >
                          <template slot="button-content">
                                        <b-icon icon="plus-lg">
                                        </b-icon>
                            </template>
                          <b-dropdown-item v-b-modal.newFolder>Thư mục mới</b-dropdown-item>
                          <b-dropdown-item @click="upFileEvent()">Tải lên tệp</b-dropdown-item>
                          <b-dropdown-item>Tải lên thư mục</b-dropdown-item>
                        </b-dropdown></b-col>
                      </b-row>
                    
                    <form id="uploadBox" class="mb-2 mt-2 d-none hide" action="upload.php" method="post" enctype="multipart/form-data">
                      <input type="file" name="fileToUpload" id="fileToUpload" @change="submitUpload()">
                      <input type="button" value="Upload" name="Upload" @click="Upload()">
                      
                    </form>
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                          <table class="table mb-0 tbl-server-info">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên File</th>
                                <th scope="col">Kích thước</th>
                                <th scope="col">Ngày cập nhật</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(item,index) in listfile">
                                <td>
                                  {{index+1}}
                                </td>
                                <td @click="showReview(item)" role="button">
                                    <b-icon :icon="item.type == 'file' ? IconShow(item.name) : 'folder-fill'" class="mr-1"></b-icon>  {{item.name}}
                                </td>
                                <td>{{item.type == 'file' ? formatBytes(item.size) : ''}}</td>
                                <td>{{item.type == 'file' ? timestampToDateVn(item.date) : ''}}</td>
                                <td>
                                    <b-dropdown size="sm" no-caret id="dropdown-2" variant="link" toggle-class="text-decoration-none">
                                      <template slot="button-content">
                                        <b-icon icon="three-dots">
                                        </b-icon>
                                      </template>
                                      <b-dropdown-item v-if="item.type==='file'" @click="showReview(item)"><b-icon icon="eye-fill"></b-icon> Mở File</b-dropdown-item>
                                      <b-dropdown-item @click='delFile(item.name)'><b-icon icon="trash-fill"></b-icon> Xóa</b-dropdown-item>
                                      <b-dropdown-item><b-icon icon="pencil-fill"></b-icon> Chỉnh sửa</b-dropdown-item>
                                      <b-dropdown-item v-if="item.type==='file'"><b-icon icon="printer-fill"></b-icon> In</b-dropdown-item>
                                      <b-dropdown-item @click='downFile(item)'><b-icon icon="cloud-download-fill"></b-icon> Tải Xuống</b-dropdown-item>
                                    </b-dropdown>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                        <!-- Modal -->
                      <b-modal id="newFolder" @shown="focusMyElement" hide-footer title="Nhập tên thư mục" >
                        <div class="modal-body">
                          <b-alert v-model="showFolderErrorAlert" variant="danger" dismissible>
                        không thể tạo!
                        </b-alert>
                              <div class="input-group"> <input id="nameFolder" ref="focusThis" type="text" class="form-control" v-model="nameNewFolder">
                                <div class="input-group-append"> <button class="btn btn-primary" type="button" @click="newFolderEvent()"> Tạo thư mục </button> </div>
                              </div>
                            </div>
                          
                      </b-modal>
                      <b-modal id="showReview" :size="isImg=='file'?'sm':''" hide-footer hide-header centered >

                        <div class="modal-body">
                          <b-button variant="transparent" size="sm" @click="$bvModal.hide('showReview')" style="position:absolute;right:0px;top:0px;z-index:1;"><b-icon icon="x-lg"></b-icon></b-button>
                          <div>
                            <div  v-if="isImg ==='img'">
                            <a :href="+itemselect" target="_blank">
                            <img :src="https_protocol+itemselect" width="100%" />
                          </a>
                          </div>
                          <div v-else-if="isImg ==='file'">
                            <a :href="https_protocol+itemselect" target="_blank">
                            <img :src="https_protocol+downloadimg" alt="Click để tải tài liệu." />
                          </a>
                          </div>
                          <div v-else>
                    
                            <img :src="https_protocol+defaultimg" width="100%" alt="Click để tải tài liệu." />
                 
                          </div>
                          </div>
                        </div>

                      </b-modal>

                    </div>
                    
                    <div class="mt-3" v-if="pageLists.rip_ghi_chu">
                      <span v-html="pageLists.rip_ghi_chu"></span>
                    </div>
                  </div>
                  
                </div>  
              </div>       
            </div>   
          </template>
        </main-content>

        <content-bottom v-if="_isContentBottom"> 
        </content-bottom>
      </div>
    </div>
  </main>
</template>

<script>
  
import { mapState, mapActions, } from 'vuex'
import { MODULE_LINH_MUC_DETAIL_PAGE, } from '@app/stores/front/types/module-types'
import { GET_DETAIL_LINH_MUC, } from '@app/stores/front/types/action-types'
import MainMenu from 'com@front/Common/MainMenu'
import ContentTop from 'com@front/Common/ContentTop'
import ContentBottom from 'com@front/Common/ContentBottom'
import SocialNetwork from 'com@front/Common/SocialNetwork'
import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular'
import MainContent from 'com@front/Common/MainContent'
import Vue from 'vue'
import vuetimeline from '@growthbunker/vuetimeline'
Vue.use(vuetimeline)

var GLOBAL_URL=window.location.href.replace(/https?:\/\//,'')
var SP = GLOBAL_URL.split('/')
var DOMAIN = SP[0]
var DOMAIN_ID = SP[SP.length-1]

export default {
  name: 'InfoPage',
  components: {
    MainMenu,
    TabInfoViewedAndPopular,
    ContentTop,
    ContentBottom,
    SocialNetwork,
    MainContent,
  },
  data() {
    return {
      isContentBottom: true,
      fullPage: false,
      isTopBottomBoth: false,
      imgCarousel: 'https://picsum.photos/1024/480/?image=58',
      chucThanh: ['', 'Phó Tế', 'Linh Mục', 'Giám Mục'],
      chucVus: [],
      lstlink:[
          'All files'
      ],
      items: [
          {
            text: 'All files',
            href: '#',
          },
          {
            text: 'Huy',
            href: '#'
          },
          {
            text: 'Grandchildren',
            active: true
          }
        ],
        isImg:'none',
        filedeleted:'',
        targetdir:'',
        listfile: [],
        itemselect: '',
        defaultimg:DOMAIN + '/front/img/image-svgrepo-com.svg',
        downloadimg:DOMAIN + '/front/img/download-svgrepo-com.svg',
        LstFileIcon: [],
        nameNewFolder: '',
        dirFolder: '',
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  
        showFolderErrorAlert: false,
        showFolderSuccessAlert: false,
        showFileSuccessAlert:false,
        delFileFailedAlert:false,
        showFileFailedAlert:false,
        root:[],
        spaceDiv:{},
        table_box:0,
        right_height:0,
        left_heihgt:0,
        https_protocol:window.location.protocol+'//'
    }
  },
  computed: {
    ...mapState({
      contentBgColor: state => state.cfApp.setting.contentBgColor,
      logoBgColor: state => state.cfApp.setting.logoBgColor,
    }),
    ...mapState(MODULE_LINH_MUC_DETAIL_PAGE, {
      pageLists: state => {
        return state.pageLists
      },
      loading: state => state.loading,
    }),
    _isContentTop() {
      return this.$route.meta.layout_content.content_top
    },
    _isContentBottom() {
      return this.$route.meta.layout_content.content_bottom
    },
    _isContentMain() {
      return this.$route.meta.layout_content.content_main
    },
  },
  mounted() {
    this.getDetail(this.$route.params)
    this.LoadData()
    this.table_box=(this.$refs.tableBox.clientHeight+20)+'px';
    this.right_height=this.$refs.rightColumn.clientHeight
    this.left_heihgt=this.$refs.leftColumn.clientHeight
    
  },

  methods: {
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, {
      getDetail: GET_DETAIL_LINH_MUC,
    }),
    ...mapActions(MODULE_LINH_MUC_DETAIL_PAGE, [
      'ACTION_EXPORT_FILE_LINHMUC'
    ]),
    exportFileLinhMuc(id, name) {
      this.ACTION_EXPORT_FILE_LINHMUC({id: id, name: name});
    },
    focusMyElement() {
      this.$refs.focusThis.focus()
    },
   breadCum(dir){
    
    if (dir=='All files'){
      dir=null
      this.lstlink=['All files']
    }
    else if (dir!=='All files')
    {
      var lstlink=this.lstlink
      lstlink.forEach(function(link,index){
       if (dir==link){
         
        lstlink=lstlink.slice(0,index+1)
        dir=lstlink.slice(1).join('/')
       }
     })
     //console.log(dir)
     this.lstlink=lstlink
    }
    // console.log(this.lstlink)
    this.LoadData(dir)
   },
   getCurrentDir(dirname){

   },
   delFile(item){
      var self = this;
      var targetfile=self.lstlink.slice(1).join('/')+'/'+item
      var url = this.https_protocol+DOMAIN+'/api/explorer/delFile?id='+DOMAIN_ID+'&name=' + targetfile
      if(confirm('Bạn muốn xóa '+item+' không ?'))
        $.get(url, function(data, status) {
          if (data == true)
            self.isImg='none'
            self.LoadData(self.lstlink.slice(1).join('/'));
            });
          else self.delFileFailedAlert=true
   },
   downFile(item){
    if(item.type=='file'){
      //this.$router.go(DOMAIN+item.pathreal)
      window.open(this.https_protocol+DOMAIN+item.pathreal)
    }
    else alert("Thư mục hiện chưa có tính năng download")
   },
    newFolderEvent() {
          var self = this;
          var currdir= self.lstlink.slice(1).join('/')
          var nameNewFolder = self.nameNewFolder
          var url = this.https_protocol+DOMAIN+'/api/explorer/newFolder?id='+DOMAIN_ID+'&name=' + currdir+'/'+ nameNewFolder
          $.get(url, function(data, status) {
            if (data == true) {
              //alert("Đã tạo thư mục thành công! " + nameNewFolder);
              // $('#newFolder').modal('hide');
              // $bvModal.hide('#newFolder');
              self.showFolderSuccessAlert=true
              self.$bvModal.hide("newFolder")
              self.LoadData(currdir);
              self.nameNewFolder = ''
            } else {
              self.showFolderErrorAlert=true
              self.nameNewFolder = ''
            }
          });

        },
        upFileEvent() {
          $('#fileToUpload').trigger('click');
        },
        formatBytes(bytes, decimals = 2) {
          if (bytes == '') return '';
          if (!+bytes) return '0 Bytes'
          const k = 1024
          const dm = decimals < 0 ? 0 : decimals
          const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
          const i = Math.floor(Math.log(bytes) / Math.log(k))
          return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
        },
        timestampToDateVn(time) {
          if (time == '') return '';
          var date = new Date(time * 1000)
          var day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
          var month = (date.getMonth()+1) < 10 ? "0" + (date.getMonth()+1) + "" : (date.getMonth()+1);
          return day + "/" + month + "/" + date.getUTCFullYear() + " " + date.getHours() + ":" + date.getMinutes()
        },
        showReview(item) {
          var currdir=this.LinkPathProcess(item.pathreal)
          if (item.type == 'folder') {
            
           // newlinkpath=newlinkpath.filter(n => n)
           //console.log(currdir)
            
            this.lstlink.push(currdir.at(-1))
            this.LoadData(currdir.join('/'))
          } 
          else 
          {
            this.$bvModal.show("showReview")
            var imgType=['png','jpg','bmp','gif']
            var ext=item.name.split('.')
            if (imgType.includes(ext.at(-1))){
              this.itemselect = DOMAIN +item.pathreal
            this.isImg='img'
            }
            
            else {
              this.itemselect = DOMAIN +item.pathreal
            this.isImg='file'}

          }
        },
        LinkPathProcess(linkpath){
           linkpath=linkpath.split('/').filter(n => n)
           var newlinkpath=[]
           linkpath.forEach(function(item,index){
         
            if (item=='AllFiles')
             newlinkpath = linkpath.slice(index+1)
           })
           return newlinkpath 
        },
        IconShow(namefile) {
          var icon = 'file-earmark-fill'
          var sp = namefile.split('.')
          if (sp.length > 1) {
            var ext = sp[sp.length - 1]
            var iext = this.LstFileIcon.filter(item => item.ext == ext)
            if (iext.length > 0) {
              icon = iext[0].icon
            }
          }
          return icon;
        },
        submitUpload() {
          var self = this
          var targetdir=self.lstlink.slice(1).join('/')
          //console.log(self.targetdir)
          var frm = $('#uploadBox');
          var formData = new FormData(frm[0]);
          formData.append('targetdir', targetdir);
          //console.log(formData)
          $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
          $.ajax({
            url: this.https_protocol+DOMAIN+'/api/explorer/upload?id='+DOMAIN_ID,
            type: 'POST',
            data: formData,
            success: function(data) {
              //console.log(data)
              if (data==false|data==null){
                self.showFileFailedAlert=true
              }
             else {
                self.LoadData(targetdir);
                self.showFileSuccessAlert=true
                frm[0].reset()
              }  
            },
            cache: false,
            contentType: false,
            processData: false
          });
        },
        LoadData(dir1 = null) {
          var self = this

          var url = this.https_protocol+DOMAIN+'/api/explorer/getlistdir?id='+DOMAIN_ID;
          if (dir1 != null) url += '&dir=' + dir1;
          $.getJSON(url, function(json) {
            self.listfile = json
            //console.log(json)
            
            self.listfile = self.listfile.sort((a, b) => b.type.localeCompare(a.type));
            if(self.root.length==0)
            self.root=self.listfile.filter(item=>item.type=='folder')
            
          });
        },

    diadiem(item) {
       if(item.giaoxuName !== '') {
          return item.giaoxuName
       }else if (item.cosogpName !== '') {
         return item.cosogpName
       }else if (item.dongName !== '') {
         return item.dongName
       }else {
         return item.banchuyentrachName
       }
    },
    _des(item) {
      const ghi_chu = (item.ghi_chu !== null) ? item.ghi_chu : ''
      var fromDate = this._checkTypeofDate(item.label_from_date)
      var toDate = item.label_to_date ? ' đến' + this._checkTypeofDate(item.label_to_date) : ''
      var des = 'Từ ' + fromDate + toDate + ' ' + ghi_chu
      return des
    },
    _checkTypeofDate(date){
      var arrDate=date.split('-')
      if (arrDate.length===3){
        return ' ngày ' + date
      }else if (arrDate.length===2){
        return ' tháng ' + date
      }else if (arrDate.length===1){
        return ' năm ' + date
      } else return ''
    },
    _ngThuPhong(nguoi_thu_phong) {
      return (nguoi_thu_phong !== null) ? nguoi_thu_phong : 'Chưa cập nhật'
    },
    _itemChucVus(chucVus) {
      const self = this
      if (self.chucVus.length) {
        return self.chucVus
      }
      if (chucVus && chucVus.length) {
        chucVus.forEach((item, idx) => {
          var fromDate = item.label_from_date
          var toDate = item.label_to_date ? ` đến ngày ${item.label_to_date}` : ''
          var title = `${item.chucvuName} - Giáo xứ: ${item.giaoxuName}`
          var des = `Từ ngày ${fromDate} ${toDate} ${item.ghi_chu}`
          self.chucVus.push(
            new Item(
              idx,
              'edit',
              Status.INFO,
              title,
              [],
              item.from_date ? new Date(item.from_date) : '',
              des
            )
          )
        })
      }

      return self.chucVus
    },
    edit(e) {
      //console.log('edit ' + e['eventId'])
    },
    reset() {
      this.item = {}
    },
    selectFromParentComponent1() {
      // select option from parent component
      this.item = this.options[0]
    },
    reset2() {
      this.item2 = ''
    },
    selectFromParentComponent2() {
      // select option from parent component
      this.item2 = this.options2[0].value
    },
    compareColumn(){
          // var left_heihgt=this.$refs.leftColumn.clientHeight
          // var right_height=this.$refs.rightColumn.clientHeight
          if(this.right_height>this.left_heihgt){
          //var heightString = this.$refs.tableBox.clientHeight + 'px';
          Vue.set(this.spaceDiv,'height',this.table_box)
          return true
          }
          else return false
        },
  },
}
</script>



<style lang="scss" >
@import "./styles.scss";
</style>
