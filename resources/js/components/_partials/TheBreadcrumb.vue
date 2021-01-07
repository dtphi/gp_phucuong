<template>
    <b-breadcrumb v-if="items.length > 0" :items="items"></b-breadcrumb>
</template>

<script>
    export default {
        name: 'TheBreadcrumb',
        computed: {
            items() {
                const breadcrumbs = this.$route.meta.breadcrumbs || [];

                return breadcrumbs.reduce((array, breadcrumb) => {
                    let temp = { text: breadcrumb.name };

                    if (breadcrumb.link) {
                        temp.to = { name: breadcrumb.link };
                    } else {
                        temp.active = true;
                    }
                    array.push(temp);

                    return array;
                }, []);
            }
        }
    };
</script>

<style scoped>

</style>