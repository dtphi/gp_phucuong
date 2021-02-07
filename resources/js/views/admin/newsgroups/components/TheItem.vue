<template>
	<a class="treeview-animated-items-header" 
		v-on:mouseover.prevent="_showAction" 
		v-on:mouseleave.prevent="_hideAction">
    <i v-if="isFolder" class="fas fa-plus"></i>
    <span>{{ group.name }}</span>
    <BtnGroupAction 
      :current-group="group" 
      v-show="active" 
    	class="float-sm-right center" 
    	style="margin-top:0px"/>
  </a>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex';
  import {
    MODULE_NEWS_GROUP_MODAL
  } from 'store@admin/types/module-types';
  import BtnGroupAction from './TheActionGroup';

export default {
  name: 'TheItem',
  components: {BtnGroupAction},
  props: {
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
