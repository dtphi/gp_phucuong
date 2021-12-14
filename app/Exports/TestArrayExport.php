<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Log;

class TestArrayExport implements FromArray, WithStyles, WithEvents
{
    private $fileRead = 'logs/test.log';
    /**
     * Num increment.
     */
    private $incrementNum = [
        'A_#' => 1,
        'B_#' => 1,
        'C_#' => 1,
        'D_#' => 1
    ];

    private $mapColKeys = ['A_#' => '', 'B_#' => 1, 'C_#' => 2, 'D_#' => 3, 'E_#' => 4, 'U_#' => 20, 'V_#' => 21];

    public function array(): array
    {
        //$content = $this->__readLogFile();
        //$this->getTableHtmlVs1($content);
        //$this->getTableHtml();

        return $this->__readLogFile();
        /*$testCol = [];
        for ($i = 1; $i <= 16384; $i ++) {
            $testCol[] = $i;
        }*/
        return [
            [],
            //$testCol,
            ['a', 'c'],
            ['d', 'e'],
            ['', '', '', '', '', '', 'abc']
        ];
    }

    public function getTableHtmlVs1(array $content = array()): string
    {
        $arrTables = [];
        $tdNum = 30;
        $tdColOneNum = 20;

        $items = [];
        for ($i = 0; $i <= $tdNum; $i++) {
            $items[] = '';
        }

        if (!empty($content)) {
            foreach ($content as $rows) {
                $tmpItems = $items;
                $tmpRows = $rows;
                $tmpItems['config'] = $rows['__config__'];

                foreach ($tmpRows as $key => $value) {
                    if (str_starts_with($key, '__empty')) { 
                        $index = (int) preg_replace('/\D/', '', $key);
                        $tmpItems[$index ? $index : 0] = $value;
                    }
                    
                    unset($tmpRows[$key]);
                }

                $arrTables[] = $tmpItems;
            }
        }

        $html = '';
        foreach ($arrTables as $key => $row) {
            $html .= '<tr>';
            $config = $row['config'];
            unset($row['config']);
            $tmpRow = $row;
            $colSpan = '';

            foreach ($tmpRow as $key => $value) {

                $classTd = 'td_empty';
                $lastContentIndex = $config['lastContentIndex'];
                if ($key == $lastContentIndex) {
                    $classTd = 'td_content';
                    if ($lastContentIndex < $tdColOneNum) {
                        $colSpan = ($tdColOneNum - (int)$config['lastContentIndex']);
                    } else {
                        $colSpan = 10;
                    }
                }
                if ($config['isNo'] && $config['isNo'] == $key) {
                    $classTd = 'td_is_no_' . $config['isNo'];
                }

                if ($key <= $lastContentIndex) {
                    $txtColSpan = 'colspan="' . $colSpan . '"';
                    $html .= '<td class="' . $classTd . '" ' . $txtColSpan . '>' . $value . '</td>';
                } else {
                    if (($config['colContent'] == 1) && ($key < ($tdNum - $colSpan))) {
                        $html .= '<td class="td_empty"></td>';
                    }
                }
            }
            $html .= '</tr>';
        }
        Log::info($html);
        return $html;
    }

    public function getTableHtml(): string
    {
        $arrTables = [];
        $tdNum = 30;
        $tdColOneNum = 20;

        $items = [];
        for ($i = 0; $i <= $tdNum; $i++) {
            $items[] = '';
        }

        $content = $this->__readLogFile();
        if (!empty($content)) {
            foreach ($content as $rows) {
                $tmpItems = $items;
                $tmpRows = $rows;
                $tmpItems['config'] = $rows['__config__'];

                foreach ($tmpRows as $key => $value) {
                    if (str_starts_with($key, '__empty')) { 
                        $index = (int) preg_replace('/\D/', '', $key);
                        $tmpItems[$index ? $index : 0] = $value;
                    }
                    if ($key == '__empty') {
                        $tmpItems[0] = $value;
                    }
                    if ($key == '__empty_1') {
                        $tmpItems[1] = $value;
                    }
                    if ($key == '__empty_2') {
                        $tmpItems[2] = $value;
                    }
                    if ($key == '__empty_3') {
                        $tmpItems[3] = $value;
                    }
                    if ($key == '__empty_4') {
                        $tmpItems[4] = $value;
                    }
                    if ($key == '__empty_5') {
                        $tmpItems[5] = $value;
                    }
                    if ($key == '__empty_6') {
                        $tmpItems[6] = $value;
                    }

                    if ($key == '__empty_21') {
                        $tmpItems[21] = $value;
                    }
                    if ($key == '__empty_22') {
                        $tmpItems[22] = $value;
                    }

                    unset($tmpRows[$key]);
                }

                $arrTables[] = $tmpItems;
            }
        }

        $html = '';
        foreach ($arrTables as $key => $row) {
            $html .= '<tbody><tr>';
            $config = $row['config'];
            unset($row['config']);
            $tmpRow = $row;
            $colSpan = '';

            foreach ($tmpRow as $key => $value) {

                $classTd = 'td_empty';
                $lastContentIndex = $config['lastContentIndex'];
                if ($key == $lastContentIndex) {
                    $classTd = 'td_content';
                    if ($lastContentIndex < $tdColOneNum) {
                        $colSpan = ($tdColOneNum - (int)$config['lastContentIndex']);
                    } else {
                        $colSpan = 10;
                    }
                }
                if ($config['isNo'] && $config['isNo'] == $key) {
                    $classTd = 'td_is_no_' . $config['isNo'];
                }

                if ($key <= $lastContentIndex) {
                    $txtColSpan = 'colspan="' . $colSpan . '"';
                    $html .= '<td class="' . $classTd . '" ' . $txtColSpan . '>' . $value . '</td>';
                } else {
                    if (($config['colContent'] == 1) && ($key < ($tdNum - $colSpan))) {
                        $html .= '<td class="td_empty"></td>';
                    }
                }
            }
            $html .= '</tr></tbody>';
        }

        return $html;

        // Display on the template blade.
        /*
            <style>
                td.td_empty { width: -1%;}
                table, th, td {
                    width: -1%;
                    border: 1px solid black;
                    border-collapse: collapse;
                }
            </style>
            <table>
                <thead>
                    <tr>
                        <th colspan="21" style="width: 60%;">ケース(手順・操作など）</th>        
                        <th colspan="10" style="width: 40%;">確認内容</th>
                    </tr>
                </thead>
                <!-- star -->
                {!! nl2br($htmlTable) !!}
                <!-- end -->
            </table>
        */
    }

    private function __readLogFile(): array
    {
        $pathFile = storage_path($this->fileRead);

        if (!is_file($pathFile)) {
            \File::put(storage_path($this->fileRead), '');
        }

        $content = \File::get(storage_path($this->fileRead));

        $fileObject = new \SplFileObject('php://memory', 'r+');
        $fileObject->fwrite($content);
        $fileObject->rewind();

        $arrExportContent = [];

        while ($fileObject->valid()) {
            $line = $fileObject->current();
            $this->__setExportStructureVs1($arrExportContent, $line);
            $fileObject->next();
        }

        return $arrExportContent;
    }

    private function __setExportStructureVs1(array &$arrExportContent = array(), string $row = ''): array
    {
        $arrRow = explode(' ', $row);
        $arrTmpRow = [];
        $rowNum = count($arrExportContent) + 2;

        if (!empty($arrRow)) {
            if (isset($arrRow[0])) {
                $numberAdd = $arrRow[0];
                unset($arrRow[0]);
                $contentAdd = $arrRow;
                if ($numberAdd == '#') {
                    $this->__setRowStructure($arrTmpRow, ['A_#',  $contentAdd, $rowNum]);
                    $this->incrementNum['A_#'] += 1;
                    $this->incrementNum['B_#'] = 1;
                    $this->incrementNum['C_#'] = 1;
                    $this->incrementNum['D_#'] = 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if ($numberAdd == '##') {
                    $this->__setRowStructure($arrTmpRow, ['B_#',  $contentAdd, $rowNum]);
                    $this->incrementNum['B_#'] += 1;
                    $this->incrementNum['C_#'] = 1;
                    $this->incrementNum['D_#'] = 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if ($numberAdd === '###') {
                    $this->__setRowStructure($arrTmpRow, ['C_#',  $contentAdd, $rowNum]);
                    $this->incrementNum['C_#'] += 1;
                    $this->incrementNum['D_#'] = 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if ($numberAdd === '####') {
                    $this->__setRowStructure($arrTmpRow, ['D_#',  $contentAdd, $rowNum]);
                    $this->incrementNum['D_#'] += 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if (in_array($numberAdd, ['-', '='])) {
                    $this->__setRowStructure($arrTmpRow, ['E_#',  $contentAdd, $rowNum]);

                    return $arrExportContent[] = $arrTmpRow;
                }
                if (in_array($numberAdd, ['+'])) {
                    $this->__setRowStructure($arrTmpRow, ['V_#',  $contentAdd, $rowNum]);

                    return $arrExportContent[] = $arrTmpRow;
                }
            }
        }

        return [];
    }

    private function __setRowStructure(array &$row = array(), array $content = array()): void 
    {
        if (array_key_exists($content[0], $this->mapColKeys)) {
            $isNo = -1;
            $indexContent = $this->mapColKeys[$content[0]];
            $lastContentIndex = (int)$indexContent;
            if (isset($this->incrementNum[$content[0]])) {
                $isNo = (int)$indexContent;
                $lastContentIndex += 1;
                
                $row['__empty' . $indexContent] = $this->incrementNum[$content[0]];
                $row['__empty_' . ((int)$indexContent + 1)] = implode(' ', $content[1]);
            } else {
                $row['__empty_' . (int)$indexContent] = implode(' ', $content[1]);
            }
            
            $row['__rowNum__'] = $content[2];
            $row['__config__'] = [
                'isNo' => $isNo,
                'colContent' => ($lastContentIndex < 21) ? 1 : 2,
                'lastContentIndex' => $lastContentIndex
            ];
        }
    }

    private function __setExportStructure(array &$arrExportContent = array(), string $row = ''): array
    {
        $arrRow = explode(' ', $row);
        $arrTmpRow = [];
        $rowNum = count($arrExportContent) + 2;

        if (!empty($arrRow)) {
            if (isset($arrRow[0])) {
                $numberAdd = $arrRow[0];
                unset($arrRow[0]);
                $contentAdd = $arrRow;
                if ($numberAdd == '#') {
                    $arrTmpRow['__empty'] = $this->incrementNum['A_#'];
                    $arrTmpRow['__empty_1'] = implode(' ', $contentAdd);
                    $arrTmpRow['__rowNum__'] = $rowNum;
                    $arrTmpRow['__config__'] = [
                        'isNo' => 0,
                        'colContent' => 1,
                        'lastContentIndex' => 1
                    ];
                    $this->incrementNum['A_#'] += 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if ($numberAdd == '##') {
                    $arrTmpRow['__empty_1'] = $this->incrementNum['B_#'];
                    $arrTmpRow['__empty_2'] = implode(' ', $contentAdd);
                    $arrTmpRow['__rowNum__'] = $rowNum;
                    $arrTmpRow['__config__'] = [
                        'isNo' => 1,
                        'colContent' => 1,
                        'lastContentIndex' => 2
                    ];
                    $this->incrementNum['B_#'] += 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if ($numberAdd === '###') {
                    $arrTmpRow['__empty_2'] = $this->incrementNum['C_#'];
                    $arrTmpRow['__empty_3'] = implode(' ', $contentAdd);
                    $arrTmpRow['__rowNum__'] = $rowNum;
                    $arrTmpRow['__config__'] = [
                        'isNo' => 2,
                        'colContent' => 1,
                        'lastContentIndex' => 3
                    ];
                    $this->incrementNum['C_#'] += 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if ($numberAdd === '####') {
                    $arrTmpRow['__empty_3'] = $this->incrementNum['D_#'];
                    $arrTmpRow['__empty_4'] = implode(' ', $contentAdd);
                    $arrTmpRow['__rowNum__'] = $rowNum;
                    $arrTmpRow['__config__'] = [
                        'isNo' => 3,
                        'colContent' => 1,
                        'lastContentIndex' => 4
                    ];
                    $this->incrementNum['D_#'] += 1;

                    return $arrExportContent[] = $arrTmpRow;
                }
                if (in_array($numberAdd, ['-', '='])) {
                    $arrTmpRow['__empty_4'] = implode(' ', $contentAdd);
                    $arrTmpRow['__rowNum__'] = $rowNum;
                    $arrTmpRow['__config__'] = [
                        'isNo' => 0,
                        'colContent' => 1,
                        'lastContentIndex' => 4
                    ];

                    return $arrExportContent[] = $arrTmpRow;
                }
                if (in_array($numberAdd, ['+'])) {
                    $arrTmpRow['__empty_21'] = implode(' ', $contentAdd);
                    $arrTmpRow['__rowNum__'] = $rowNum;
                    $arrTmpRow['__config__'] = [
                        'isNo' => 0,
                        'colContent' => 2,
                        'lastContentIndex' => 21
                    ];

                    return $arrExportContent[] = $arrTmpRow;
                }
            }
        }

        return [];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        //XFD
        return [
            BeforeExport::class  => function (BeforeExport $event) {
                $event->writer->setCreator('DangThanhPhi');
            },
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                /*$event->sheet->styleCells(
                    'A1:BT1000',
                    [
                        'borderStyle' =>  Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_WHITE]
                    ]
                );*/

                $event->sheet->styleCells(
                    'A2:AN28',
                    [
                        'font' => [
                            'name' => 'ＭＳ ゴシック',
                            'size' => 9
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' =>  Border::BORDER_THIN,
                                'color' => ['argb' => Color::COLOR_BLACK],
                            ],
                            'horizontal' => [
                                'borderStyle' =>  Border::BORDER_DOTTED,
                                'color' => ['argb' => Color::COLOR_BLACK]
                            ],
                            'vertical' =>  [
                                'borderStyle' =>  Border::BORDER_DOTTED,
                                'color' => ['argb' => Color::COLOR_WHITE]
                            ],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'U2:U28',
                    [
                        'borders' => [
                            'right' =>  [
                                'borderStyle' =>  Border::BORDER_THIN,
                                'color' => ['argb' => Color::COLOR_BLACK]
                            ],
                        ]
                    ]
                );
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('ＭＳ Ｐ明朝');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
        //dd(get_class_methods());
    }

    /* array:140 [
        0 => "__construct"
        1 => "disconnectCells"
        2 => "__destruct"
        3 => "getCellCollection"
        4 => "getInvalidCharacters"
        5 => "getCoordinates"
        6 => "getRowDimensions"
        7 => "getDefaultRowDimension"
        8 => "getColumnDimensions"
        9 => "getDefaultColumnDimension"
        10 => "getDrawingCollection"
        11 => "getChartCollection"
        12 => "addChart"
        13 => "getChartCount"
        14 => "getChartByIndex"
        15 => "getChartNames"
        16 => "getChartByName"
        17 => "refreshColumnDimensions"
        18 => "refreshRowDimensions"
        19 => "calculateWorksheetDimension"
        20 => "calculateWorksheetDataDimension"
        21 => "calculateColumnWidths"
        22 => "getParent"
        23 => "rebindParent"
        24 => "getTitle"
        25 => "setTitle"
        26 => "getSheetState"
        27 => "setSheetState"
        28 => "getPageSetup"
        29 => "setPageSetup"
        30 => "getPageMargins"
        31 => "setPageMargins"
        32 => "getHeaderFooter"
        33 => "setHeaderFooter"
        34 => "getSheetView"
        35 => "setSheetView"
        36 => "getProtection"
        37 => "setProtection"
        38 => "getHighestColumn"
        39 => "getHighestDataColumn"
        40 => "getHighestRow"
        41 => "getHighestDataRow"
        42 => "getHighestRowAndColumn"
        43 => "setCellValue"
        44 => "setCellValueByColumnAndRow"
        45 => "setCellValueExplicit"
        46 => "setCellValueExplicitByColumnAndRow"
        47 => "getCell"
        48 => "getCellByColumnAndRow"
        49 => "cellExists"
        50 => "cellExistsByColumnAndRow"
        51 => "getRowDimension"
        52 => "getColumnDimension"
        53 => "getColumnDimensionByColumn"
        54 => "getStyles"
        55 => "getStyle"
        56 => "getConditionalStyles"
        57 => "conditionalStylesExists"
        58 => "removeConditionalStyles"
        59 => "getConditionalStylesCollection"
        60 => "setConditionalStyles"
        61 => "getStyleByColumnAndRow"
        62 => "duplicateStyle"
        63 => "duplicateConditionalStyle"
        64 => "setBreak"
        65 => "setBreakByColumnAndRow"
        66 => "getBreaks"
        67 => "mergeCells"
        68 => "mergeCellsByColumnAndRow"
        69 => "unmergeCells"
        70 => "unmergeCellsByColumnAndRow"
        71 => "getMergeCells"
        72 => "setMergeCells"
        73 => "protectCells"
        74 => "protectCellsByColumnAndRow"
        75 => "unprotectCells"
        76 => "unprotectCellsByColumnAndRow"
        77 => "getProtectedCells"
        78 => "getAutoFilter"
        79 => "setAutoFilter"
        80 => "setAutoFilterByColumnAndRow"
        81 => "removeAutoFilter"
        82 => "getFreezePane"
        83 => "freezePane"
        84 => "freezePaneByColumnAndRow"
        85 => "unfreezePane"
        86 => "getTopLeftCell"
        87 => "insertNewRowBefore"
        88 => "insertNewColumnBefore"
        89 => "insertNewColumnBeforeByIndex"
        90 => "removeRow"
        91 => "removeColumn"
        92 => "removeColumnByIndex"
        93 => "getShowGridlines"
        94 => "setShowGridlines"
        95 => "getPrintGridlines"
        96 => "setPrintGridlines"
        97 => "getShowRowColHeaders"
        98 => "setShowRowColHeaders"
        99 => "getShowSummaryBelow"
        100 => "setShowSummaryBelow"
        101 => "getShowSummaryRight"
        102 => "setShowSummaryRight"
        103 => "getComments"
        104 => "setComments"
        105 => "getComment"
        106 => "getCommentByColumnAndRow"
        107 => "getActiveCell"
        108 => "getSelectedCells"
        109 => "setSelectedCell"
        110 => "setSelectedCells"
        111 => "setSelectedCellByColumnAndRow"
        112 => "getRightToLeft"
        113 => "setRightToLeft"
        114 => "fromArray"
        115 => "rangeToArray"
        116 => "namedRangeToArray"
        117 => "toArray"
        118 => "getRowIterator"
        119 => "getColumnIterator"
        120 => "garbageCollect"
        121 => "getHashCode"
        122 => "extractSheetTitle"
        123 => "getHyperlink"
        124 => "setHyperlink"
        125 => "hyperlinkExists"
        126 => "getHyperlinkCollection"
        127 => "getDataValidation"
        128 => "setDataValidation"
        129 => "dataValidationExists"
        130 => "getDataValidationCollection"
        131 => "shrinkRangeToFit"
        132 => "getTabColor"
        133 => "resetTabColor"
        134 => "isTabColorSet"
        135 => "copy"
        136 => "__clone"
        137 => "setCodeName"
        138 => "getCodeName"
        139 => "hasCodeName"
      ]
    */
}
