<template>
    <main id="homepage" class="py-2">
        <div class="container">
            <Navigation />
            <div class="list-home mt-4 mb-3">
                <figure-item-page v-for="item in 8" :key="item"></figure-item-page>
            </div>
        </div>
    </main>
</template>

<script>
    import Navigation from 'com@front/Navigation/Main';
    import FigureItemPage from './components/TheItemPage';

    export default {
        name: 'HomePage',
        components: {
            Navigation,
            FigureItemPage,
        },
        data() {
            return {

            }
        },
    }
</script>

<style lang="scss">
    @import './home-style.scss'
</style>
