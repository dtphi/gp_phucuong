import { 
  LAYOUT_TOGGLE_SIDEBAR, 
  LAYOUT_SWITCH_SIDEBAR, 
  LAYOUT_HANDLE_SWIPE,
  LAYOUT_CHANGE_SIDEBAR_ACTIVE 
} from './types/mutation-types';

export default {
    namespaced: true,
    state: {
      sidebarClose: false,
      sidebarStatic: false,
      sidebarActiveElement: null,
      chatOpen: false,
      chatNotificationIcon: false,
      chatNotificationPopover: false,
  },
  mutations: {
    [LAYOUT_TOGGLE_SIDEBAR](state) {
      const nextState = !state.sidebarStatic;

      localStorage.sidebarStatic = nextState;
      state.sidebarStatic = nextState;

      if (!nextState && (isScreen('lg') || isScreen('xl'))) {
        state.sidebarClose = true;
      }
    },
    [LAYOUT_SWITCH_SIDEBAR](state, value) {
      if (value) {
        state.sidebarClose = value;
      } else {
        state.sidebarClose = !state.sidebarClose;
      }
    },
    [LAYOUT_HANDLE_SWIPE](state, e) {
      if ('ontouchstart' in window) {
        if (e.direction === 4) {
          state.sidebarClose = false;
        }

        if (e.direction === 2 && !state.sidebarClose) {
          state.sidebarClose = true;
        }
      }
    },
    [LAYOUT_CHANGE_SIDEBAR_ACTIVE](state, index) {
      state.sidebarActiveElement = index;
    },
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('LAYOUT_TOGGLE_SIDEBAR');
    },
    switchSidebar({ commit }, value) {
      commit('LAYOUT_SWITCH_SIDEBAR', value);
    },
    handleSwipe({ commit }, e) {
      commit('LAYOUT_HANDLE_SWIPE', e);
    },
    changeSidebarActive({ commit }, index) {
      commit('LAYOUT_CHANGE_SIDEBAR_ACTIVE', index);
    },
  }
}
