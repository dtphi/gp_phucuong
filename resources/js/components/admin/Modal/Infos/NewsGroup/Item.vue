<template>
	<a class="treeview-animated-items-header" 
		v-on:mouseover.prevent="_showAction" 
		v-on:mouseleave.prevent="_hideAction">
    <i v-if="isFolder" class="fas fa-plus"></i>
    <span>{{ group.newsgroupname }}</span>

  </a>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
  import {
    MODULE_NEWS_GROUP_MODAL
  } from 'store@admin/types/module-types';

export default {
  name: 'NewsGroupItem',
  components: {},
  props: {
    isItemRoot: 0,
  	group: [Object, Array],
    isFolder : Number
  },
  data: function() {
    return {
      active: false
    };
  },
  computed: {
  	...mapGetters(MODULE_NEWS_GROUP_MODAL, [
  		'isOpen'
  	]),

  	activeStyle: (app) => {
  		if (app.isOpen && app.active) {
  			return app.$options.setting.activeStyle
  		}

  		return '';
  	}
  },
  methods: {
  	_showAction() {
  		this.active = true;
  	},

    _hideAction() {
    	this.active = false;
    }
  },
  setting: { 
  	activeStyle: 'background-color:#93d3a2'
  }
};
</script>
