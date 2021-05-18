<template>
    <div class="box-social">
        <h4 class="tit-common clr-blue">Mạng xã hội</h4>
        <div class="list-icon">
            <share-it url="http://haydesachnoipodcast.com/" 
                :shareConfig="share"
                :targets="['twitter', 'facebook', 'linkedin', 'whatsapp', 'reddit']"></share-it>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import shareIt from 'vue-share-it';
    Vue.use(shareIt);

    export default {
        name: 'TheSocialNetwork',
        data() {
            return {
                share: {
                    twitter: {
                        label: ' ',
                        size: "xs",
                        dense: true,
                    },
                    linkedin: {
                        label: ' ',
                        size: "xs",
                        color: "#fff",
                        backgroundColor: "black",
                        dense: true,
                    },
                    facebook: {
                        label: ' ',
                        size: "xs",
                        dense: true,
                    },
                    whatsapp: {
                        label: ' ', 
                        size: "xs",
                        dense: true
                    },
                    reddit: {
                        label: ' ', 
                        size: "xs",
                        dense: true
                    },
                }
            }
        },
    }
</script>
