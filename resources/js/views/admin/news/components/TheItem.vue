<template>
  <tr>
    <td>{{info.id}}</td>
    <td>{{info.newsname}}</td>
    <td>{{info.description}}</td>
    <td></td>
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
        name: 'TheItem',
        components: {
            BtnEdit, 
            BtnDelete
        },
        props: {
            info: {
                type: Object,
                validator: function(value) {
                    var id = (value.id && Number.isInteger(value.id));
                    var name = (value.newsname && value.newsname.length);

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