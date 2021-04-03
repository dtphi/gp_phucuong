<template>
	<tr>
  	<td class="text-center">                    
  		<input type="checkbox" name="selected[]" :id="`cate_select_id_${categoryItem.category_id}`" :value="categoryItem.category_id">
    </td>
  	<td class="text-left">{{categoryItem.category_name}}</td>
  	<td class="text-right">{{categoryItem.sort_order}}</td>
  	<td class="text-right">
  		<the-btn-edit
          :category-id="categoryItem.category_id"></the-btn-edit>
      <the-btn-delete-confirm
          :category-id="categoryItem.category_id"></the-btn-delete-confirm>
    </td>
	</tr>
</template>

<script>
    import {
        mapState
    } from 'vuex';
    import TheBtnEdit from './TheBtnEdit';
    import TheBtnDeleteConfirm from './TheBtnDeleteConfirm';
    import {
        fn_get_base_url_image,
        fn_format_dd_mm_yyyy
    } from '@app/api/utils/fn-helper';

    export default {
        name: 'TheCategoryItem',
        components: {
            TheBtnEdit,
            TheBtnDeleteConfirm
        },
        props: {
            categoryItem: {
                type: Object,
                validator: function (value) {
                    var id = (value.category_id && Number.isInteger(value.category_id));
                    var name = (value.category_name && value.category_name.length);

                    return (id && name)
                }
            },
            no : {
                default: 1
            }
        },
        computed: {
            ...mapState({
                meta: state => state.cfApp.meta
            })
        },
        data() {
            return {};
        },
        methods: {
            _getImgUrl() {
                return fn_get_base_url_image(this.categoryItem.image);
            },

            _getNo() {
                return (this.no + this.meta.from);
            },

            _formatDate(date) {
                return fn_format_dd_mm_yyyy(date);
            }
        }
    };
</script>
