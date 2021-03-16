<template>
  <div class="tabs-menu mt-3 mb-3">
    <b-tabs>
      <b-tab title="Giáo Phận" disabled></b-tab>
      <b-tab :title="tab.tabName" :active="false" v-for="tab in listTabs" :key="tab.tabName">
        <div class="content" v-for="content in tab.tabContent" :key="content.titContent">
          <h4 class="tit">{{ content.titContent }}</h4>
          <a class="link" href="#" v-for="(link, index) in content.arrContent" :key="link.txt + index">
            <b-icon icon="arrow-right" aria-hidden="true"></b-icon>
            {{ link.txt }}
          </a>
        </div>
      </b-tab>
    </b-tabs>
  </div>
</template>

<script>
  export default {
    name: 'TabHome',
    data() {
      return {
        listTabs: [
          {
            tabName: 'Giới thiệu',
            tabContent: [
              {
                titContent: 'Giới thiệu',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              },
              {
                titContent: 'Linh Mục Đoàn',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              }
            ]
          },
          {
            tabName: 'GIÁO HẠT – GIÁO XỨ',
            tabContent: [
              {
                titContent: 'GIÁO HẠT – GIÁO XỨ',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              }
            ]
          },
          {
            tabName: 'Nhà Thờ Chánh Tòa',
            tabContent: [
              {
                titContent: 'Nhà Thờ Chánh Tòa',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              }
            ]
          },
          {
            tabName: 'Năm Thánh',
            tabContent: [
              {
                titContent: 'Năm Thánh',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              }
            ]
          },
          {
            tabName: 'Giám Mục',
            tabContent: [
              {
                titContent: 'Giám Mục',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              }
            ]
          },
          {
            tabName: 'Linh Mục Đoàn',
            tabContent: [
              {
                titContent: 'Linh Mục Đoàn',
                arrContent: [
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' },
                  { txt: 'Suy Niệm Tĩnh Tâm Linh Mục - Tháng 2/2017' }
                ]
              }
            ]
          }
        ]
      }
    },
    methods: {
      
    }
  }
</script>

<style lang="scss">
  .tabs-menu {
    .tabs {
      .nav-tabs {
        border: 0;
        font-size: 14px;
        li {
          &:not(:first-child) {
            a {
              border: 0;
              font-size: 12px;
              font-weight: 700;
              text-transform: uppercase;
            }
          }
          a {
            color: #000;
            &.active {
              border-bottom: 3px solid #ffa204;
            }
            &:hover {
              border-bottom: 3px solid #ffa204;
            }
          }
        }
      }
      .tab-content {
        background-color: #f7fff7;
        border: 1px solid #e2e8f0;
        margin-top: -2px;
        padding: 15px 20px;
        font-size: 0;
        .content {
          width: calc(100% / 3);
          display: inline-block;
          padding: 0 10px;
          .tit {
            font-size: 16px;
          }
          .link {
            color: #000;
            display: block;
            font-size: 14px;
            text-decoration: none;
            margin-bottom: 5px;
            &:hover {
              color: #FFA204;
              font-weight: 600;
            }
          }
        }
      }
    }
  }
</style>