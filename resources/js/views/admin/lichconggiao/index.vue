<template>
  <div id="content">
    <div class="hgencalendar">
      <div class="searchbox">
        <table>
          <tr>
            <td>
              Tháng
            </td>
            <td>
              <input type="number" min="1" max="12" class="dt form-control" v-model="frommonth">
            </td>
            <td>
              năm
            </td>
            <td>
              <input type="number" class="dt form-control" v-model="fromyear">
            </td>
            <td>
              <input type="button" value="Tìm" class="dt btn btn-info" @click="searchCalendar()" />

            </td>
          </tr>
        </table>
      </div>

      <div class="hcalendarshow" id="hcalendarshow">
        <table class="table table-striped table-bordered mt1">
          <thead>
            <tr>
              <th scope="col">Ngày</th>
              <th scope="col">Tên lễ</th>
              <th scope="col">Trạng thái</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in lstCal">
              <td>
                <p class="dlline" v-html="item.l + '&lt;br/&gt;' + item.day + '/' + item.month + '/' + item.year">
                </p>
                <p class="alline" v-html="item.amlich.day + '/' + item.amlich.month + '&lt;br/&gt;' + item.amlich.year">
                </p>
              </td>
              <td>
                <div class="lebox itemLe" v-for="itemle in item.le">
                  <p class="leboxname" v-html="itemle.name"></p>
                  <p class="leboxpam" v-if="itemle.phucam != null">
                    <span :class="item.match(regexPam) != null ? 'pamhover' : ''" @click="showPAM(item)"
                      v-for="item in PhucAmHover(itemle.phucam)">
                      {{ item }}
                    </span>
                  </p>
                </div>
              </td>
              <td>

              </td>
              <td>
                <input type="button" value="Sửa" class="dt btn btn-info" @click="editClick(item)" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>


      <div>
  <!-- Using modifiers -->
  <b-button v-b-modal.my-modal>Show Modal</b-button>

  <!-- Using value -->
  <b-button v-b-modal="'my-modal'">Show Modal</b-button>

  <!-- The modal -->
  <b-modal id="my-modal">Hello From My Modal!</b-modal>
</div>

      

      <b-modal ref="DayDetailModal">
        
        <div class="bgDayDetail">
        <div  hide-footer v-if="itemSelect != null"
          :title="itemSelect.l + ' ngày ' + itemSelect.day + ' tháng ' + itemSelect.month + ' năm ' + itemSelect.year">
          <div class="itemLeDetail mb2" v-for="itemle in itemSelect.le">
            <div class="input-group">
              <input type="text" class="form-control" v-model="itemle.name" placeholder="Tên lễ">
              <div class="input-group-btn">
                <button class="btn btn-danger" type="submit" @click="DelItemLeClick(itemSelect, itemle.uuid)">
                  <i class="glyphicon glyphicon-remove"></i>
                </button>
              </div>
            </div>
            <textarea class="form-control mt1" rows="3" v-model="itemle.phucam"
              placeholder="Thánh vịnh, phúc âm..."></textarea>
          </div>
          <div class="text-right">
            <input type="button" value="Thêm" class="dt btn btn-primary text-right" @click="AddClick(itemSelect)" />
          </div>

          <button type="button" class="btn btn-primary" @click="saveItemLe()">Lưu lại</button>
        </div>
      </div>
      </b-modal>


    </div>
  </div>
</template>

<script>
var now = (new Date())
import {
  fn_get_href_base_url,
  fn_change_to_slug,
} from '@app/api/utils/fn-helper'
export default {
  name: 'LichCongGiaoPage',
  components: { },
  data() {
    return {
      overight: true,
      frommonth: now.getMonth() + 1,
      fromyear: now.getFullYear(),
      tomonth: 12,
      toyear: 2022,
      lstCal: [],
      itemSelect: null,
      regexPam: /[1-9a-zA-ZĐđ]+ \d+,?(\d+)?.?(\d+)?(\w+)?-?(\d+)?,?(\d+)?.?(\d+)?(\w+)?-?(\d+),?(\d+)?.?(\d+)(\w)?(-\d+)?/g,
    }
  },
  watch: {

  },
  computed: {

  },
  methods: {
    searchCalendar() {
      var self = this
      // check = (self.frommonth < 1 || self.tomonth < 1) ||
      //   (self.toyear < self.frommonth) ||
      //   (self.toyear < 1 || self.frommonth < 1)

      // if (check) {
      //   alert('Ngày tháng không đúng')
      //   return 0;
      // }
      //self.showLoading = true;
      // var lst = self.getListMonth(self.frommonth, self.fromyear, self.tomonth, self.toyear)
      var lstCal = []
      //for (i = 0; i < lst.length; i++) {
      // item = lst[i]
      // console.log([month,year])
      var url = window.location.origin + '/api/app/calendar/getlist' + '?month=' + self.frommonth + '&year=' + self.fromyear + '&onlyMonth=true';
      // $.getJSON(url, function (json) {
      //   console.log(json)
      //   self.lstCal.push(json);
      // });

      jQuery.ajax({
        url: url,
        async: true,
        success: function (json) {
          self.lstCal = json;
        }
      });

    },
    strvn2Date(strvn) {
      sp = strvn.split('/');
      return new Date(sp[2] + '-' + sp[1] + '-' + sp[0])
    },
    getListMonth(startmonth, startyear, endmonth, endyear) {
      var lst = []
      if (startyear == endyear && startmonth <= endmonth) {
        for (i = startmonth; i <= endmonth; i++) {
          lst.push({
            month: i,
            year: startyear
          })
        }
      } else if (startyear < endyear) {
        var y = startyear
        for (i = startmonth; i <= 12; i++) {
          lst.push({
            month: i,
            year: y
          })
          if (i >= endmonth && y >= endyear) break;
          if (i == 12) {
            y++;
            i = 0;
            if (y > endyear) break;
          }
        }
      }
      return lst;
    },
    obserToArray(lst) {
      var arr = []
      let keys = Object.keys(lst);
      keys.forEach(key => {
        arr.push(lst[key])
      })
      return arr;
    },
    editClick(item) {
      var self = this
      var itemSelect = JSON.parse(JSON.stringify(item))
      itemSelect.le = this.obserToArray(itemSelect.le)
      if (Array.isArray(itemSelect.le)) {
        for (var i = 0; i < itemSelect.le.length; i++) {
          var m = itemSelect.le[i]
          m.phucam = m.phucam == null ? '' : this.strip(m.phucam)
          m.uuid = this.uuid();
        }
      }
      this.itemSelect = itemSelect
      self.$refs['DayDetailModal'].show()
    },
    AddClick() {
      this.itemSelect.le.push({
        name: '',
        phucam: '',
        uuid: this.uuid()
      })
    },
    strip(html) {
      let doc = new DOMParser().parseFromString(html, 'text/html');
      return doc.body.textContent || "";
    },
    PhucAmHover(str) {
      var str = this.strip(str)
      if (str == undefined || str == null || str == '') return '';
      var res = str.replace(this.regexPam, "|$&|")
      return res.replace(/#/gi, '').split('|');
    },
    showPAM(str) {
      if (str.match(this.regexPam) == null) return false;
      alert(str)
    },
    DelItemLeClick(item, uuid) {
      if (confirm('Bạn có chắc chắn muốn xóa ngày lễ này')) {
        item.le = item.le.filter(itemle => itemle.uuid != uuid)
        console.log(item.le)
      }
    },
    uuid() {
      return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
      );
    },
    saveItemLe() {
      var lstle = []
      this.itemSelect.le.forEach(item => {
        lstle.push({
          name: item.name,
          phucam: item.phucam
        })
      });

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var data = {
        date: this.itemSelect.year + '-' + this.itemSelect.month + '-' + this.itemSelect.day,
        lstle: lstle,
      }

      var url = window.location.origin + '/api/app/calendar/saveCalendar';

      $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (res) {
          if (res == true) {
            alert('Đã lưu thành công')
          }
        }
      })


    }
  },
  mounted() {

  },
  setting: {
    panel_title: 'Module Danh Mục Icon',
    frm_title: 'Thêm danh mục Icon',
    btn_save_txt: 'Lưu',
  },
}
</script>

<style lang="scss">
@import "./styles.scss";
</style>