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
              <input type="number" class="dt form-control" max="9999" v-model="fromyear">
            </td>
            <td>
              <button type="button" value="Tìm" class="dt btn btn-primary" @click="searchCalendar()">
                <i class="fa fa-search" aria-hidden="true"></i>
              </button>
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
                <div class="lstLe" v-if="itemSelect == null || itemSelect.uuid != item.uuid">
                  <div class="lebox itemLe" v-for="itemle in item.le">
                    <p class="leboxname" v-html="itemle.name"></p>
                    <p class="leboxpam" v-if="itemle.phucam != null">
                      <span :class="item.match(regexPam) != null ? 'pamhover' : ''" @click="showPAM(item)"
                        v-for="item in PhucAmHover(itemle.phucam)">
                        {{ item }}
                      </span>
                    </p>
                  </div>
                </div>
                <div class="bgDayDetail" v-if="itemSelect != null && itemSelect.uuid == item.uuid">
                  <div
                    :title="itemSelect.l + ' ngày ' + itemSelect.day + ' tháng ' + itemSelect.month + ' năm ' + itemSelect.year">
                    <div class="itemLeDetail mb2" v-for="itemle in itemSelect.le">
                      <div class="input-group inputww">
                        <input type="text" class="form-control leboxname" v-model="itemle.name" placeholder="Tên lễ">
                        <div class="input-group-btn">
                          <button class="btn btn-danger" type="submit" @click="DelItemLeClick(itemSelect, itemle.uuid)">
                            <i class="glyphicon glyphicon-remove"></i>
                          </button>
                        </div>
                      </div>
                      <textarea class="form-control mt1 leboxpam" rows="3" v-model="itemle.phucam"
                        placeholder="Thánh vịnh, phúc âm..."></textarea>
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <small class="text-muted" v-if="item.leDateUpdate!=undefined || item.leDateUpdate!=null">
                      <i class="fa fa-database text-success" aria-hidden="true"></i>
                      Chỉnh sửa: {{date2datevn(item.leDateUpdate)}}
                    </small>
                    <small class="text-muted" v-else>
                      <i class="fa fa-connectdevelop text-secondary" aria-hidden="true"></i>
                      Công thức
                    </small>
                  </div>
                  <div class="col-md-6">
                    <div class="text-right">
                      <button value="Sửa" v-if="itemSelect == null || itemSelect.uuid != item.uuid" type="button" class="dt btn btn-info"
                        @click="editClick(item)">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                      </button>
                      <div v-else class="savett">
                        <button data-toggle="tooltip" data-placement="bottom" title="Thêm dòng" type="button" class="dt btn btn-secondary text-right" @click="AddClick(itemSelect)">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>

                        <button data-toggle="tooltip" data-placement="bottom" title="Quay Lại" type="button" class="dt btn btn-success text-right" @click="BackClick(itemSelect)">
                          <i class="fa fa-reply" aria-hidden="true"></i>
                        </button>

                        <button v-if="item.leDateUpdate!=undefined || item.leDateUpdate!=null" data-toggle="tooltip" data-placement="bottom" title="Reset" type="button" value="Reset" class="dt btn btn-danger text-right" @click="ResetClick(itemSelect)">
                          <i class="fa fa-reply-all" aria-hidden="true"></i>
                        </button>

                        <button data-toggle="tooltip" data-placement="bottom" title="Lưu" value="Lưu" type="button" class="dt btn btn-primary" @click="saveItemLe()">
                          <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>



    </div>
  </div>
</template>

<script>
var now = (new Date())
var urlapi = window.location.origin + '/api/app/calendar/';
var filterPhucAm = /[1-9a-zA-ZĐđ]+ \d+,?(\d+)?.?(\d+)?(\w+)?-?(\d+)?,?(\d+)?.?(\d+)?(\w+)?-?(\d+),?(\d+)?.?(\d+)(\w)?(-\d+)?/g;

export default {
  name: 'LichCongGiaoPage',
  data() {
    return {
      overight: true,
      frommonth: now.getMonth() + 1,
      fromyear: now.getFullYear(),
      tomonth: 12,
      toyear: 2022,
      lstCal: [],
      itemSelect: null,
      itemRoot: null,
      regexPam: filterPhucAm,
    }
  },
  methods: {
    searchCalendar() {
      var self = this
      self.frommonth = self.frommonth > 12 ||  self.frommonth < 1 ? now.getMonth()+1 : self.frommonth
      self.fromyear = self.fromyear < 1 || self.fromyear > 9999 ? now.getFullYear() : self.fromyear;
      var lstCal = []
      var url = urlapi + 'getlist' + '?month=' + self.frommonth + '&year=' + self.fromyear + '&onlyMonth=true';
      jQuery.ajax({
        url: url,
        async: false,
        success: function (json) {
          var lstCal = json;
          for (var i = 0; i < lstCal.length; i++) {
            var im = lstCal[i]
            im.uuid = self.uuid()
          }
          self.lstCal = lstCal;
        }
      });

    },
    strvn2Date(strvn) {
      sp = strvn.split('/');
      return new Date(sp[2] + '-' + sp[1] + '-' + sp[0])
    },
    date2datevn(str){
      var s1 = str.split(' ');
      var strdate = s1[0]
      var strtime = s1[1]
      var sdate = strdate.split('-');
      return sdate[2] + '/' + sdate[1] + '/' + sdate[0] + ' '+strtime;
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
      if(item.le == null) item.le = [];
      self.itemRoot = item
      var itemSelect = JSON.parse(JSON.stringify(item))
      itemSelect.le = self.obserToArray(itemSelect.le)
      if (Array.isArray(itemSelect.le)) {
        for (var i = 0; i < itemSelect.le.length; i++) {
          var m = itemSelect.le[i]
          m.phucam = m.phucam == null ? '' : self.strip(m.phucam)
          m.uuid = self.uuid();
        }
      }
      self.itemSelect = itemSelect
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
      if (confirm('Bạn có chắc chắn muốn lưu dữ liệu vừa chỉnh sửa?')) {
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

        var url = urlapi + 'saveCalendar';
        var self = this
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          async:false,
          success: function (res) {
            if (res > 0) {
              alert('Đã lưu thành công')
              self.itemRoot.le = self.itemSelect.le
              var now = new Date()
              self.itemRoot.leDateUpdate = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDay() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
            }
            else{
              alert('Lưu thất bại')
            }
            self.itemSelect = null;
          }
        })
      }
    },
    BackClick() {
      if (confirm('Bạn có chắc chắn muốn quay lại, sẽ không lưu dữ liệu vừa chỉnh sửa')) {
        var self = this
        self.itemSelect = null;
      }
    },
    ResetClick() { 
      if (confirm('Bạn có chắc chắn muốn reset lại ngày lễ này, xóa dữ liệu đã lưu và quay lại mặc định tự tính bằng công thức?')) {
        var self = this
        var lstCal = []
        var date = self.itemSelect.year + '-' + self.itemSelect.month + '-' + self.itemSelect.day;
        var url = urlapi + 'deleteCalendar' + '?date=' + date;
        jQuery.ajax({
          url: url,
          async: false,
          success: function (json) {
            if(json > 0){
              self.searchCalendar();
            }
            self.itemSelect = null;
          }
        });
      }
    },
  }
}
</script>

<style lang="scss">
@import '~bootstrap/scss/bootstrap';
@import "./styles.scss";
</style>