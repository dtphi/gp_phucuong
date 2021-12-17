<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <div style="background-color: #80808008;" :style="{backgroundColor:contentBgColor}">
                <content-top v-if="_isContentTop">
                    <!-- Loading -->
					<!-- <template v-if="loading">
                        <loading-over-lay
                            :active.sync="loading"
                            :is-full-page="fullPage"></loading-over-lay>
                    </template> -->
                    <template v-slot:column_right>
                        <social-network></social-network>
                        <div class="box-social">
                            <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
                        </div>
                    </template>
                </content-top>
                <main-content v-if="_isContentMain">
                    <!--<template v-slot:before_column_both>
                        <div class="col-mobile col-12">
                            <module-page-banner-list></module-page-banner-list>
                        </div>
                    </template>-->
                    <template v-slot:bottom>
                        <div class="list-danh-muc w-100">
                            <h2 class="title-linh-muc text-center">Danh sách giáo xứ giáo phận phú cường <hr class="line-linh-muc"></h2>
                            <div class="tab-linh-muc w-100">
                                <b-tabs content-class="mt-3" fill>
                                    <b-tab title="Tất cả" active>
                                        <div class="list-giao-xu">
                                            <div v-for="(info,idx) in infoList" :key="idx" class="row row-linh-muc">
                                                <div class="col-mobile col-2">
                                                    <a class="avatar" :href="info.hrefDetail">
                                                        <img class="img" v-lazy="info.image" :alt="info.name">
                                                    </a>
                                                </div>
                                                <div class="col-mobile col-10 content">
                                                    <h4 class="tit">
                                                       <a :href="info.hrefDetail"> Giáo Xứ {{info.name}}</a>
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Giờ lễ: <span v-html="info.gio_le"></span></span>
                                                            <span>Địa chỉ: {{info.dia_chi}}</span>
                                                            <span>Email: {{info.email}}</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span>Điện thoại: {{info.dien_thoai}}</span>
                                                            <span>Dân số: {{info.dan_so}}</span>
                                                            <span>Số tín hữu: {{info.so_tin_huu}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <paginate :is-resource="isResource" v-if="infoList"></paginate>
                                    </b-tab>
                                    <b-tab title="Lọc theo Giáo phận / Giáo hạt">
