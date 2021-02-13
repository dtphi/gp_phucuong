<template>
  <tr>
    <td>{{info.id}}</td>
    <td>{{info.news_name}}</td>
    <td>{{info.description}}</td>
    <td>{{info.createdAt}}</td>
    <td>
      <div class="icheck-primary">
        <input type="checkbox" :id="`info_id_${info.id}`" :value="info.id">
        <label :for="`info_id_${info.id}`"></label>
      </div>
    </td>
    <td>
      <BtnEdit :info-id="info.id"/>
      <BtnDelete :info-id="info.id"/>
    </td>
  </tr>
</template>

<script>
    import { mapActions } from 'vuex';
    import BtnEdit from './TheBtnEdit';
    import BtnDelete from './TheBtnDelete';

    export default {
        name: 'TheItemInfo',
        components: {
            BtnEdit, 
            BtnDelete
        },
        props: {
            info: {
                type: Object,
                default: {},
                validator: function(value) {
                    var id = (value.id && Number.isInteger(value.id));
                    var name = (value.news_name && value.news_name.length);

                    return (id && name)
                }
            }
        },
        data() {
            return {
            };
        },
        methods: {
        }
    };
</script>