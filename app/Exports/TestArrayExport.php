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

class TestArrayExport implements FromArray, WithStyles, WithEvents
{ 
   
    public function array():array
    {
        /*$testCol = [];
        for ($i = 1; $i <= 16384; $i ++) {
            $testCol[] = $i;
        }*/
        return [
            [],
            //$testCol,
            ['a','c'],
            ['d','e'],
            ['','','','','','', 'abc']
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        //XFD
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('DangThanhPhi');
            },
            AfterSheet::class    => function(AfterSheet $event) {
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
