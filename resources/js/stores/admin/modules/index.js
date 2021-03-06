import CategoryIconSideBar from './category_icon_side_bars';
import CategoryLeftSideBar from './category_left_side_bars';
import HomeBanner from './home_banners';
import ThongBao from './thong_baos';
import LoiChua from './loi_chuas';
import TinGiaoHoi from './tin_giao_hois';
import TinGiaoHoiVietNam from './tin_giao_hoi_viet_nams';
import TinGiaoPhan from './tin_giao_phans';
import VanKien from './van_kiens';
import NoiBat from './noi_bats';
import SpecialInfoCarousel from './special_info_carousels';

export default {
  namespaced: true,
  actions: {},
  modules: {
    category_icon_side_bar: CategoryIconSideBar,
    category_left_side_bar: CategoryLeftSideBar,
    home_banner: HomeBanner,
    thong_bao: ThongBao,
    loi_chua: LoiChua,
    tin_giao_hoi: TinGiaoHoi,
    tin_giao_hoi_viet_nam: TinGiaoHoiVietNam,
    tin_giao_phan: TinGiaoPhan,
    van_kien: VanKien,
    noi_bat: NoiBat,
    special_info_carousel: SpecialInfoCarousel,
  }
}