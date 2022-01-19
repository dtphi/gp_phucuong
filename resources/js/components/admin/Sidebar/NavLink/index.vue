<template>
  <li class="nav-item has-treeview menu-open">
    <a
      :href="link"
      class="nav-link"
      :class="{ active: isActive }"
      :title="label"
    >
      <font-awesome-icon :icon="fullIconName" size="xs" />
      <p>{{ label }} <i class="right fas fa-angle-left"></i></p>
    </a>
  </li>
</template>

<script>
import { mapActions, } from 'vuex'

export default {
  name: 'NavLink',
  components: {},
  props: {
    badge: { type: String, dafault: '', },
    header: { type: String, default: '', },
    iconName: { type: String, default: '', },
    headerLink: { type: String, default: '', },
    link: { type: String, default: '', },
    childrenLinks: { type: Array, default: null, },
    className: { type: String, default: '', },
    isHeader: { type: Boolean, default: false, },
    deep: { type: Number, default: 0, },
    activeItem: { type: String, default: '', },
    label: { type: String, },
    labelColor: { type: String, default: 'warning', },
    index: { type: String, },
  },
  data() {
    return {
      headerLinkWasClicked: true,
    }
  },
  methods: {
    ...mapActions('layout', ['changeSidebarActive']),
    togglePanelCollapse(link) {
      this.changeSidebarActive(link)
      this.headerLinkWasClicked =
        !this.headerLinkWasClicked || !this.activeItem.includes(this.index)
    },
  },
  computed: {
    fullIconName() {
      return `${this.iconName}`
    },
    isActive() {
      return (
        this.activeItem &&
        this.activeItem.includes(this.index) &&
        this.headerLinkWasClicked
      )
    },
  },
}
</script>
