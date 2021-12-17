<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <style>
            body{
                font-family: 'ＭＳ Ｐ明朝', Meiryo, "ＭＳ Ｐ明朝", "MS PGothic", "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", Osaka, sans-serif;
            }
        </style>
        <style>
            td {
                font-family: 'ＭＳ ゴシック', "ＭＳ ゴシック";
                font-size: smaller;
                border-bottom: 1px dashed black;
            }
            td.col-content-1 {
                border-right: 1px solid black;
            }
            td.col-content-2 {
                border-right: 1px solid black;
            }
            td.col-content-first, td.td_is_no_1 {
                text-align: right;
            }
            table, th, td {
                width: -1%;
            }
            .paginationjs{line-height:1.6;font-size:14px;box-sizing:initial}.paginationjs:after{display:table;content:" ";clear:both}.paginationjs .paginationjs-pages{float:left}.paginationjs .paginationjs-pages ul{float:left;margin:0;padding:0}.paginationjs .paginationjs-go-button,.paginationjs .paginationjs-go-input,.paginationjs .paginationjs-nav{float:left;margin-left:10px;font-size:14px}.paginationjs .paginationjs-pages li{float:left;border:1px solid #aaa;border-right:none;list-style:none}.paginationjs .paginationjs-pages li>a{min-width:30px;height:28px;line-height:28px;display:block;background:#fff;font-size:14px;color:#333;text-decoration:none;text-align:center}.paginationjs .paginationjs-pages li>a:hover{background:#eee}.paginationjs .paginationjs-pages li.active{border:none}.paginationjs .paginationjs-pages li.active>a{height:30px;line-height:30px;background:#aaa;color:#fff}.paginationjs .paginationjs-pages li.disabled>a{opacity:.3}.paginationjs .paginationjs-pages li.disabled>a:hover{background:0 0}.paginationjs .paginationjs-pages li:first-child,.paginationjs .paginationjs-pages li:first-child>a{border-radius:3px 0 0 3px}.paginationjs .paginationjs-pages li:last-child{border-right:1px solid #aaa;border-radius:0 3px 3px 0}.paginationjs .paginationjs-pages li:last-child>a{border-radius:0 3px 3px 0}.paginationjs .paginationjs-go-input>input[type=text]{width:30px;height:28px;background:#fff;border-radius:3px;border:1px solid #aaa;padding:0;font-size:14px;text-align:center;vertical-align:baseline;outline:0;box-shadow:none;box-sizing:initial}.paginationjs .paginationjs-go-button>input[type=button]{min-width:40px;height:30px;line-height:28px;background:#fff;border-radius:3px;border:1px solid #aaa;text-align:center;padding:0 8px;font-size:14px;vertical-align:baseline;outline:0;box-shadow:none;color:#333;cursor:pointer;vertical-align:middle\9}.paginationjs.paginationjs-theme-blue .paginationjs-go-input>input[type=text],.paginationjs.paginationjs-theme-blue .paginationjs-pages li{border-color:#289de9}.paginationjs .paginationjs-go-button>input[type=button]:hover{background-color:#f8f8f8}.paginationjs .paginationjs-nav{height:30px;line-height:30px}.paginationjs .paginationjs-go-button,.paginationjs .paginationjs-go-input{margin-left:5px\9}.paginationjs.paginationjs-small{font-size:12px}.paginationjs.paginationjs-small .paginationjs-pages li>a{min-width:26px;height:24px;line-height:24px;font-size:12px}.paginationjs.paginationjs-small .paginationjs-pages li.active>a{height:26px;line-height:26px}.paginationjs.paginationjs-small .paginationjs-go-input{font-size:12px}.paginationjs.paginationjs-small .paginationjs-go-input>input[type=text]{width:26px;height:24px;font-size:12px}.paginationjs.paginationjs-small .paginationjs-go-button{font-size:12px}.paginationjs.paginationjs-small .paginationjs-go-button>input[type=button]{min-width:30px;height:26px;line-height:24px;padding:0 6px;font-size:12px}.paginationjs.paginationjs-small .paginationjs-nav{height:26px;line-height:26px;font-size:12px}.paginationjs.paginationjs-big{font-size:16px}.paginationjs.paginationjs-big .paginationjs-pages li>a{min-width:36px;height:34px;line-height:34px;font-size:16px}.paginationjs.paginationjs-big .paginationjs-pages li.active>a{height:36px;line-height:36px}.paginationjs.paginationjs-big .paginationjs-go-input{font-size:16px}.paginationjs.paginationjs-big .paginationjs-go-input>input[type=text]{width:36px;height:34px;font-size:16px}.paginationjs.paginationjs-big .paginationjs-go-button{font-size:16px}.paginationjs.paginationjs-big .paginationjs-go-button>input[type=button]{min-width:50px;height:36px;line-height:34px;padding:0 12px;font-size:16px}.paginationjs.paginationjs-big .paginationjs-nav{height:36px;line-height:36px;font-size:16px}.paginationjs.paginationjs-theme-blue .paginationjs-pages li>a{color:#289de9}.paginationjs.paginationjs-theme-blue .paginationjs-pages li>a:hover{background:#e9f4fc}.paginationjs.paginationjs-theme-blue .paginationjs-pages li.active>a{background:#289de9;color:#fff}.paginationjs.paginationjs-theme-blue .paginationjs-pages li.disabled>a:hover{background:0 0}.paginationjs.paginationjs-theme-blue .paginationjs-go-button>input[type=button]{background:#289de9;border-color:#289de9;color:#fff}.paginationjs.paginationjs-theme-green .paginationjs-go-input>input[type=text],.paginationjs.paginationjs-theme-green .paginationjs-pages li{border-color:#449d44}.paginationjs.paginationjs-theme-blue .paginationjs-go-button>input[type=button]:hover{background-color:#3ca5ea}.paginationjs.paginationjs-theme-green .paginationjs-pages li>a{color:#449d44}.paginationjs.paginationjs-theme-green .paginationjs-pages li>a:hover{background:#ebf4eb}.paginationjs.paginationjs-theme-green .paginationjs-pages li.active>a{background:#449d44;color:#fff}.paginationjs.paginationjs-theme-green .paginationjs-pages li.disabled>a:hover{background:0 0}.paginationjs.paginationjs-theme-green .paginationjs-go-button>input[type=button]{background:#449d44;border-color:#449d44;color:#fff}.paginationjs.paginationjs-theme-yellow .paginationjs-go-input>input[type=text],.paginationjs.paginationjs-theme-yellow .paginationjs-pages li{border-color:#ec971f}.paginationjs.paginationjs-theme-green .paginationjs-go-button>input[type=button]:hover{background-color:#55a555}.paginationjs.paginationjs-theme-yellow .paginationjs-pages li>a{color:#ec971f}.paginationjs.paginationjs-theme-yellow .paginationjs-pages li>a:hover{background:#fdf5e9}.paginationjs.paginationjs-theme-yellow .paginationjs-pages li.active>a{background:#ec971f;color:#fff}.paginationjs.paginationjs-theme-yellow .paginationjs-pages li.disabled>a:hover{background:0 0}.paginationjs.paginationjs-theme-yellow .paginationjs-go-button>input[type=button]{background:#ec971f;border-color:#ec971f;color:#fff}.paginationjs.paginationjs-theme-red .paginationjs-go-input>input[type=text],.paginationjs.paginationjs-theme-red .paginationjs-pages li{border-color:#c9302c}.paginationjs.paginationjs-theme-yellow .paginationjs-go-button>input[type=button]:hover{background-color:#eea135}.paginationjs.paginationjs-theme-red .paginationjs-pages li>a{color:#c9302c}.paginationjs.paginationjs-theme-red .paginationjs-pages li>a:hover{background:#faeaea}.paginationjs.paginationjs-theme-red .paginationjs-pages li.active>a{background:#c9302c;color:#fff}.paginationjs.paginationjs-theme-red .paginationjs-pages li.disabled>a:hover{background:0 0}.paginationjs.paginationjs-theme-red .paginationjs-go-button>input[type=button]{background:#c9302c;border-color:#c9302c;color:#fff}.paginationjs.paginationjs-theme-red .paginationjs-go-button>input[type=button]:hover{background-color:#ce4541}.paginationjs .paginationjs-pages li.paginationjs-next{border-right:1px solid #aaa\9}.paginationjs .paginationjs-go-input>input[type=text]{line-height:28px\9;vertical-align:middle\9}.paginationjs.paginationjs-big .paginationjs-pages li>a{line-height:36px\9}.paginationjs.paginationjs-big .paginationjs-go-input>input[type=text]{height:36px\9;line-height:36px\9}
        </style>
    </head>
    <body>
        <table style="border: 1px solid black">
            <thead>
                <tr>
                    <style>
                        td.td-head {
                            color: white;padding: 0px;line-height: 5px;
                        }
                    </style>
                    <td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td>
                    <td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td>
                    <td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td>

                    <td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td>
                    <td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td>
                    <td class="td-head">...</td><td class="td-head">...</td><td class="td-head">...</td><td class="td-head">.................................</td>
                </tr>
                <tr style="line-height: 4;width: 60%; background: #0000008a;color: white; font-size: 14px;">
                    <th colspan="20" style="width: 60%; border-right: 1px solid black;">ケース(手順・操作など）</th>        
                    <th colspan="10" style="width: 40%;">確認内容</th>
                </tr>
            </thead>
            
            <tbody id="data-container">
            <!-- star -->
            <!-- end -->
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="30" style="width: 100%;">
                        <div id="pagination-container"></div>
                    </th
                ></tr>
            </thead>
        </table>
        
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="/administrator/javascript/pagination.js"></script>

        <script>
            window.tableResult = '<?php echo $css->cssSetting['jsonLog']; ?>'
            tableResult = tableResult.replace(/\\/g, '\\\\')
            const tdColOneNum = 20
            const tdNum = 30

            function simpleTemplating(arrTables) {
                var html = ''
                arrTables.forEach (function (row, key) {
                    html += '<tr>'
                    const config = Object.assign({}, row.config)
                    //delete row.config

                    var tmpRow = Object.values(row)
                    var colSpan = ''

                    tmpRow.forEach (function(value, key) {
                        var classTd = 'td_empty '

                        if (key == 0) {
                            classTd = 'td_empty col-content-first'
                        }

                        var lastContentIndex = config.lastContentIndex;
                        if (key == lastContentIndex) {
                            classTd = 'td_content'

                            if (lastContentIndex < tdColOneNum) {
                                colSpan = (tdColOneNum - parseInt(config.lastContentIndex))
                            } else {
                                colSpan = 10
                            }
                        }

                        if (config.isNo && (config.isNo == key)) {
                            classTd = 'td_is_no_' + config.isNo
                        }

                        var colColumClass = ''
                        if (key == 19) {
                            colColumClass = ' col-content-' + config.colContent
                        }
                        
                        if (key <= lastContentIndex) {
                            var txtColSpan = 'colspan="' + colSpan + '"'
                            if (colSpan > 10) {
                                colColumClass = ' col-content-' + config.colContent
                            }
                            if (classTd === 'td_empty') {
                                classTd += ' ' + classTd + '_' + key
                            }
                            if (key != 20) {
                                html += '<td class="' + classTd + colColumClass + '" ' + txtColSpan + '>' + value + '</td>';
                            }
                        } else {
                            if ((config.colContent == 1) && (key < (tdNum - colSpan))) {
                                html += '<td class="td_empty ' + colColumClass + '"></td>'
                            }
                        }
                    })

                    html += '</tr>';
                })

                return html;
            }
            $('#pagination-container').pagination({
                dataSource: JSON.parse(tableResult),
                pageSize: 25,
                callback: function(data, pagination) {
                    var html = simpleTemplating(data);
                    $('#data-container').html(html);
                }
            });
        </script>
    </body>
</html>
