<template>
	<a class="treeview-animated-items-header" 
		v-on:mouseover.prevent="_showAction" 
		v-on:mouseleave.prevent="_hideAction">
    <i v-if="isFolder" class="fas fa-plus"></i>
    <span>{{ name }}</span>
    <div v-show="active" class="float-sm-right">
	    <button type="button" class="btn btn-default mb-3" >
	    	<font-awesome-icon icon="plus"  size="xs" />
	    </button>
	    <button type="button" class="btn btn-default mb-3">
	    	<font-awesome-icon icon="edit"  size="xs" />
	    </button>
    	<button type="button" class="btn btn-default mb-3">
    		<font-awesome-layers class="fa-1x" style="background:MistyRose">
				  <font-awesome-icon icon="circle" style="color:Tomato" />
				  <font-awesome-icon icon="times" class="fa-inverse" transform="shrink-6" />
				</font-awesome-layers>
    	</button>
  	</div>
  </a>
</template>

<script>

export default {
  name: 'TheItem',
  props: {
  	id: Number,
    name: String,
    isFolder : Number
  },
  data: function() {
    return {
      isOpen: false,
      active: false
    };
  },
  computed: {
  },
  methods: {
  	_showAction() {
  		this.active = true;
  	},

    _hideAction() {
    	this.active = false;
    }
  },
  txtMsg: { }
};
</script>
