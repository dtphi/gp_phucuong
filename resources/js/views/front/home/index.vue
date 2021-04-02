<template>
    <main id="homepage" class="py-2">
        <div class="container">
            <Navigation />
            <div class="list-home mt-4 mb-3">
                <figure class="figure" v-for="item in 8" :key="item">
                    <img src="../assets/img/banner_image.jpg" class="rounded img" alt="Giáo Phận Phú Cường">
                    <figcaption class="figure-caption">>>>> Xem tin tức</figcaption>
                </figure>
            </div>
        </div>
    </main>
</template>

<script>
    import Navigation from 'com@front/Navigation';

    export default {
        name: 'Home',
        components: {
            Navigation,
        },
        data() {
            return {

            }
        },
    }
</script>

<style lang="scss" scoped>
    #homepage {
        background-color: #E6E6E6;
        
        .list-home {
            .figure {
                width: calc((100% - 60px)/4);
                height: 160px;
                margin-right: 20px;
                margin-bottom: 20px;
                position: relative;
                cursor: pointer;
                overflow: hidden;

                &:hover {
                    img {
                        transform: scale(1.2);
                        transition: all 1s;
                    }
                }

                &:nth-child(4n) {
                    margin-right: 0;
                }

                .figure-caption {
                    background: rgba(255, 255, 255, 0.7);
                    color: #ED1C24;
                    font-size: 14px;
                    font-weight: bold;
                    padding: 2px;
                    text-transform: uppercase;
                    text-align: center;
                    width: 100%;
                    position: absolute;
                    bottom: 10px;
                }
            }
        }
    }

    @media screen and (max-width: 767px) {
        #homepage {
            .list-home {
                .figure {
                    width: calc((100% - 10px)/2);
                    height: 120px;
                    margin-right: 10px;
                    margin-bottom: 5px;

                    &:nth-child(2n),
                    &:nth-child(4n) {
                        margin-right: 0;
                    }

                    .figure-caption {
                        font-size: 12px;
                    }
                }
            }
        }
    }
    
</style>