<template>
  <transition name="modal-tab-general">
    <div class="card-body">
      <div class="form-group row" style="height:350px;overflow-y: scroll;">
        <div class="treeview-animated mx-4 my-4">
          <ul class="treeview-animated-list">
            <TreeItem
              :is-root="rootKey"
              class="treeview-animated-items"
              :item="_lists.root" />
          </ul>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
	import { mapState, mapGetters, mapActions } from 'vuex';
	import TreeItem from './NewsGroup/TreeItem';
	import {
    MODULE_NEWS_GROUP,
    MODULE_NEWS_GROUP_MODAL
  } from 'store@admin/types/module-types';
  import {
    ACTION_GET_NEWS_GROUP_LIST,
  } from 'store@admin/types/action-types';

    export default {
        name: 'TabGeneralForm',

        beforeCreate() {
          this.$store.dispatch(MODULE_NEWS_GROUP+'/'+ ACTION_GET_NEWS_GROUP_LIST);
        },

        components: {TreeItem},

        computed: {
          ...mapState(MODULE_NEWS_GROUP,
          [
            'newsGroups'
          ]),
          ...mapGetters(MODULE_NEWS_GROUP, ['loading']),
          ...mapGetters(MODULE_NEWS_GROUP_MODAL, ['isOpen']),
          _lists () {
            let rootTree = {...this.newsGroups};

            return {
              root: rootTree
            }
          }
        },
        
        props: {
          settingData: {
            type: Object
          }
        },

        data() {
            return {
              rootKey: 1
            };
        },

        methods: {
        },

        setting: {
        }
    };
</script>