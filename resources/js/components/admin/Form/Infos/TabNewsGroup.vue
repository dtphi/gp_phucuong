<template>
    <div class="tab-content">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="input-category">
                <span data-toggle="tooltip" title="Tìm kiếm danh mục">Danh mục tin</span>
            </label>
            <div class="col-sm-10">
                <category-autocomplete></category-autocomplete>
              
              <ul class="dropdown-menu">
                  <li data-value="33"><a href="#"></a></li>
                  <li data-value="34"><a href="#"></a></li>
              </ul>
              <div id="product-category" class="well well-sm" style="height: 150px; overflow: auto;">
                <!-- <?php foreach ($product_categories as $product_category) { ?>
                <div id="product-category<?php echo $product_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_category['name']; ?>
                  <input type="hidden" name="product_category[]" value="<?php echo $product_category['category_id']; ?>" />
                </div>
                <?php } ?> -->
              </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        mapState, 
        mapGetters, 
        mapActions
    } from 'vuex';
    import {
        MODULE_NEWS_CATEGORY,
        MODULE_NEWS_CATEGORY_ADD
    } from 'store@admin/types/module-types';
    import {
        ACTION_GET_NEWS_GROUP_LIST,
    } from 'store@admin/types/action-types';
     import CategoryAutocomplete from 'com@admin/Search/CategoryAutocomplete';

    export default {
        name: 'TabNewsGroupForm',
        components: {
            CategoryAutocomplete
        },
        beforeCreate() {
            this.$store.dispatch(MODULE_NEWS_CATEGORY + '/' + ACTION_GET_NEWS_GROUP_LIST);
        },

        props: {
            groupData: {
                type: Object
            }
        },

        data() {
            return {
                rootKey: 1
            };
        },

        mounted() {
            console.log('mounted tab')
            /*$('input[name=\'category\']').autocomplete({
                'source': function(request, response) {
                    $.ajax({
                        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                        dataType: 'json',
                        success: function(json) {
                            response($.map(json, function(item) {
                                return {
                                    label: item['name'],
                                    value: item['category_id']
                                }
                            }));
                        }
                    });
                },
                'select': function(item) {
                    $('input[name=\'category\']').val('');

                    $('#product-category' + item['value']).remove();

                    $('#product-category').append('<div id="product-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_category[]" value="' + item['value'] + '" /></div>');
                }
            });

            $('#product-category').delegate('.fa-minus-circle', 'click', function() {
                $(this).parent().remove();
            });*/

            window.Echo.channel('search-user')
            .listen('.searchAllResults', (e) => {
                console.log(e);
            })
        },

        computed: {
            ...mapState(MODULE_NEWS_CATEGORY,
                [
                    'newsGroups'
                ]),
            ...mapGetters(MODULE_NEWS_CATEGORY, ['loading']),
            ...mapGetters(MODULE_NEWS_CATEGORY_ADD, ['isOpen']),
            _lists() {
                let rootTree = {...this.newsGroups.children};

                return rootTree;
            },
            _selectedGroup() {
                return this.groupData.newsgroup_id ? this.groupData.newsgroupname : 'Not select'
            }
        },

        methods: {},

        setting: {}
    };
</script>
