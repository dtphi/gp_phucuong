import CategoryLeftSideBar from './category_left_side_bar';
import CategoryIconSideBar from './category_icon_side_bar';
import ThongBao from './thong_bao';
import VanKien from './van_kien';
import TinGiaoPhan from './tin_giao_phan';
import LoiChua from './loi_chua';

export default {
  namespaced: true,
  actions: {},
  modules: {
    category_left_side_bar: CategoryLeftSideBar,
    category_icon_side_bar: CategoryIconSideBar,
    thong_bao: ThongBao,
    van_kien: VanKien,
    tin_giao_phan: TinGiaoPhan,
    loi_chua: LoiChua
  }
}