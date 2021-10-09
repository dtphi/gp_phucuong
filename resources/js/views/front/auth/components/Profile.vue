<template>
    <div>
        <h1>PROFILE USER</h1>
        <button @click.prevent="_logout">Logout</button>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
            errorMessage: null,
            formData: {
                email: "",
                password: ""
            },
            isSubmit: false
        };
    },
    computed: {
        ...mapGetters("authUser", {
            authenticated: "authenticated",
            isError: "isError",
            errors: "errors"
        })
    },
    methods: {
        ...mapActions("authUser", {
            logout: "logout",          
        }),
        async _submit() {
            this.logout(); // sent action => store(front/auth/index)
        },
        _logout() {
            this._submit();
        }
    },
};
</script>
<style></style>
