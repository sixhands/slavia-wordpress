<html>
<?php
    $doc_title = '';
    $doc_text = '';
    if (is_var($doc_type))
        switch ($doc_type) {
            case 'output':
                $doc_title = 'возврата паевого взноса';
                $doc_text = 'получил паевой взнос, а Совет МПК «Славия» передал из Паевого Фонда паевой взнос';
                break;
            case 'input':
                $doc_title = 'приема паевого взноса';
                $doc_text = 'внёс паевой взнос, а Совет принял в Паевой Фонд паевой взнос';
                break;
            case 'deposit':
                $doc_title = 'внесение целевого взноса';
                $doc_text = 'внёс целевой взнос на Целевую Программу: '.(is_var($deposit_type) ? $deposit_type : '').
                    ', а Совет принял взнос в Целевой Фонд';
                break;
        };

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif !important; }
        table.doc_table, table.doc_table th, table.doc_table td {border: 1px solid black; }
        table {border-collapse:collapse}
        table.doc_table th {
            font-weight: normal;
            text-align: center;
        }
        table.doc_table td {
            text-align: center;
        }
        div.header_text {width: 100%;}

        /*div.header_text > div {  }*/
        div.header_text > div.header_city {text-align: left; float: left; width: 48%}
        div.header_text > div.header_date {text-align: right; float: right; width: 48%}
        /*div.header_text > p.header_date::after {*/
        /*    clear: both;*/
        /*}*/
        div.clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        div.header_text_container {
            display: inline-block;
            text-align: left;
            width: auto;
        }

        div.header, div.doc_body {
            width: 90%;
            margin: 0 5%;
        }
        br {
            line-height: 5px;
        }
        p {
            font-size: 14px;
        }
        table.signatures td.signature_cell {
            position: relative;
        }
        table.signatures .signature_cell img.podpis {
            position: absolute;
            top: 2%;
            width: 20%;
            /*opacity: 90%;*/
            z-index: 3;
        }
        table.signatures .signature_cell img.pechat {
            position: absolute;
            top: 6%;
        }
        table.signatures .signature_cell p {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
<div class="header" style="width: 100%">
    <p style="text-align: center; font-weight: bold">АКТ № <?php if (is_var($doc_num)) echo $doc_num; ?><br>
        <?php
            echo $doc_title;
        ?>
    </p>
    <br>
    <div class="header_text clearfix" style="width: 100%">
        <div class="header_city">г. Электросталь </div>
        <div class="header_date">
            <div class="header_text_container">
                <span>“_<?php if (is_var($day)) echo $day; ?>_”___<?php if (is_var($month)) echo $month; ?>__ <?php if (is_var($year)) echo $year; ?>_г.</span>
                <br>
                <span>ч.<?php if (is_var($hour)) echo $hour ?>_.<?php if (is_var($minute)) echo $minute ?>_</span>
            </div>
        </div>
    </div>
    <br>
</div>
<div class="doc_body">
    <p>Совет МПК «СЛАВИЯ» (в дальнейшем Совет) в лице председателя Сергея Андреевича С. и пайщик №<?php if (is_var($client_num)) echo $client_num; ?>_______<?php if (is_var($client_fio)) echo $client_fio; ?>_(в дальнейшем Пайщик), составили
        настоящий акт о том, что Пайщик <?php echo $doc_text; ?> в виде следующего имущества:
    </p>
    <table class="doc_table" style="width: 100%">
        <thead>
        <tr>
            <th><p>№ п/п</p></th>
            <th><p>Наименование</p></th>
            <th><p>Кол-во</p></th>
            <th><p>Стоимость за ед.</p></th>
            <th><p>Стоимость итого</p></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><p>1</p></td>
            <td><p><?php
                    if (is_var($currency)) {
                        if ($currency == 'RUB')
                            echo 'Билеты Банка России';
                        else
                            echo 'Учетная Единица '.$currency;

                    } ?></p></td>
            <td><p><?php if (is_var($amount)) echo $amount; ?></p></td>
            <td><p><?php if (is_var($currency_rate)) echo $currency_rate; ?> руб.</p></td>
            <td><p><?php if (is_var($sum)) echo $sum; ?> руб.</p></td>
        </tr>
        <tr>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
        </tr>
        <tr>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
        </tr>
        </tbody>
    </table>
    <br>
    <p style="width: 50%;">Итого на сумму <?php if (is_var($sum)) echo $sum; ?> руб. </p>
    <br>
    <table class="signatures" style="margin-left: auto; margin-right: auto;">
        <tbody>
        <tr>
            <td class="signature_cell">
                <p>Председатель Совета МПК «СЛАВИЯ» _________________<br> Сергей Андреевич С. М.П. <br> PRIZM-AWTX-HDBX-ADDH-7SMM7 <br> 8490fffdd6d9ac3433ca007cf71f137f9951 <br> e23e731453d36ab10fd4c9c4ce5b <br> 3PAM1XRQG4cpvh15evZenJWvXBAcTcC2jjt</p>
                <img class="podpis" src="/var/www/html/wp-content/uploads/2020/05/podpis_1.png">
                <img class="pechat" src="/var/www/html/wp-content/uploads/2020/05/pechat_1.png">
            </td>
            <td style="padding-left: 30px"><p>Пайщик: <br> №<?php if (is_var($client_num)) echo $client_num; ?> <br> <?php if (isset($currency_address) && $currency == 'PRIZM') echo $currency_address.'<br>'; ?><?php if (is_var($public_key)) echo $public_key; ?> <br>____________________________________________________________________________________________ <br>__________</p></td>
        </tr>
        </tbody></table>

</div>

</body></html>