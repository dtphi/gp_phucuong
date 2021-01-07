<template>
    <div class="div-content bg-white shadow py-3" :style="'min-height: ' + height">
        <div class="row justify-content-md-center px-5 mt-4">
            <div class="col-12 col-lg-9">
                <p class="mb-4 text-center">各メーカーのオンラインカタログ（外部サイト）を表示します。</p>
                <ul class="brand-lst mb-5">
                    <li v-for="catalog in catalogList" :key="catalog.manufacturer_name">
                        <a class="py-3" :href="catalog.url" :title="catalog.manufacturer_name" target="_blank">
                            <img :src="getImagePath(catalog.manufacturer_image)" :alt="catalog.manufacturer_name">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Catalog',
        data() {
            return {
                catalogList: [],
                height: '0'
            };
        },
        mounted() {
            this.height = this.calculateHeight();
            this.fetchCatalogList();
        },
        methods: {
            ...mapActions('store.catalog', [ 'getCatalog' ]),
            async fetchCatalogList() {
                const response = await this.getCatalog();

                if (response.status === 200) {
                    this.catalogList = response.catalogList;
                }
            },
            getImagePath($imageName) {
                return '/img/' + $imageName;
            }
        }
    };
</script>