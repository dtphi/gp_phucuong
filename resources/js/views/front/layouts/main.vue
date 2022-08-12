<template>
  <div class="wrapper-container">
    <!--<template v-if="pageLoading">
            <loading-over-lay
                :active.sync="pageLoading"
                :is-full-page="pageFullPage"></loading-over-lay>
        </template>-->
    <default-header></default-header>
    <slot></slot>
    <default-footer></default-footer>
    <croll-to-top-767
      v-if="_innerScreen767"
      key="croll-to-top-screen-767"
    ></croll-to-top-767>
    <croll-to-top v-else key="croll-to-top-screen"></croll-to-top>
  </div>
</template>

<script>
import { mapGetters, } from 'vuex'
import DefaultHeader from 'com@front/Header/Default'
import DefaultFooter from 'com@front/Footers'
import { mapState, mapActions, } from 'vuex'
import CrollToTop from 'com@front/Common/CrollToTop'
import CrollToTop767 from 'com@front/Common/CrollToTop767'

export default {
  name: 'MainLayout',
  components: {
    DefaultHeader,
    DefaultFooter,
    CrollToTop,
    CrollToTop767,
  },
  data() {
    return {
      pageFullPage: true,
      pageLoading: true,
    }
  },
  computed: {
    ...mapState({
      screenWidth: (state) => state.clientsTestimonialsPage,
    }),
    ...mapGetters(['isScreen767']),
    _innerScreen767() {
      return this.isScreen767
    },
  },
  methods: {
    ...mapActions(['winWidth']),
  },
  mounted() {
    this.pageLoading = false
  },
  created() {
    this.winWidth()
    window.addEventListener('resize', () => {
      this.winWidth()
    })
  },
  destroyed() {
    window.removeEventListener('resize', () => {
      this.winWidth()
    })
  },
}
</script>

<style lang="scss">
@import url("//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css");
@import url("https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,vietnamese");
.wrapper-container {
  font-size: 14px;
  font-family: "Roboto", sans-serif;

  // Text overflow ellipsis on two lines
  .ellipsis-three-lines {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .ellipsis-two-lines {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  word-break: break-word;

  .bg-blue {
    background-color: #00d9ff;
  }
  .bg-sliver {
    background-color: #cdcdcd;
  }
  .bg-red {
    background-color: #ed1c24;
  }
  .bg-green {
    background-color: #1ced38;
  }
  .bg-orange {
    background-color: #ff9900;
  }
  .bg-pink {
    background-color: #ed1c96;
  }
  .bg-grow {
    background-color: #57070793;
  }

  .clr-blue {
    color: #00d9ff;
  }
  .clr-orange {
    color: #ff9900;
  }

  .tit-common {
    border-bottom: 2px solid #000000;
    font-size: 14px;
    padding-bottom: 4px;
    text-transform: uppercase;

    &.color {
      color: #1bd7f0;
    }

    img {
      width: 16px;
      vertical-align: top;
    }

    .view-all {
      float: right;
      text-transform: capitalize;
    }
  }
  .fanpage {
    overflow: auto;
  }

  .tit-bg-common {
    font-size: 0;

    span {
      width: 20%;
      display: inline-block;
      margin-top: 4px;
      vertical-align: top;

      i {
        color: #ffffff;
        text-transform: uppercase;
        font-size: 10px;
        font-style: normal;
        font-weight: 700;
        padding: 2px 6px;
      }
    }

    a {
      font-size: 16px;
      color: #000000;
      width: 80%;
      display: inline-block;
      padding-left: 6px;
    }
  }

  .row-item-3 {
    color: #000000;
    font-size: 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding-bottom: 4px;

    span {
      font-size: 13px;
      display: inline-block;
      vertical-align: middle;

      &:first-child {
        width: 15%;
      }

      &:nth-child(2n) {
        width: 50%;
        padding: 0 5px;

        img {
          width: 11%;
        }
      }

      &:last-child {
        width: 35%;
        text-align: right;

        i {
          background-color: #f4f4f4;
          padding: 2px 10px;
          border-radius: 6px;
          font-size: 12px;
        }
      }

      i {
        font-style: normal;
      }

      img {
        width: 16%;
      }

      .status {
        color: #ffffff;
        padding: 2px 6px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
      }
    }
  }

  .row-item-2 {
    color: #000000;
    display: block;
    font-size: 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding: 5px 0;

    span {
      font-size: 13px;
      display: inline-block;
      vertical-align: middle;

      &:first-child {
        width: 65%;
      }

      &:last-child {
        width: 35%;
        text-align: right;

        i {
          background-color: #f4f4f4;
          padding: 2px 10px;
          border-radius: 6px;
          font-size: 12px;
          font-style: normal;
        }

        img {
          width: 16%;
        }
      }
    }

    &:hover {
      background-color: rgba(0, 0, 0, 0.03);
    }
  }

  .box-social {
    .list-icon {
      font-size: 0;

      a {
        display: inline-block;
        width: calc(100% / 5);
      }

      .nav-tabs {
        .nav-link {
          color: #000;
        }
      }
    }

    .tabs {
      .tab-content {
        max-height: 250px;
        overflow-y: scroll;
      }
    }
  }

  .box-care {
    #email {
      background-color: #cccccc;
      padding: 6px;
      border-radius: 4px;
      width: 100%;
      outline: 0;
    }

    .btn {
      background-color: #ed1c24;
      color: #ffffff;
      padding: 4px 14px;
      font-weight: bold;
    }

    .text-download {
      color: #ff0000;
      font-weight: 700;
      text-transform: uppercase;
      text-align: center;
      vertical-align: middle;
    }
  }

  .new-care {
    .list-new {
      a {
        color: #000 !important;

        &:hover {
          text-decoration: none;
          color: #00d9ff !important;
        }
      }
    }
  }

  @media screen and (max-width: 767px) {
    .row {
      .col-mobile {
        max-width: 100%;
        flex: unset;
      }
    }
  }
}
</style>