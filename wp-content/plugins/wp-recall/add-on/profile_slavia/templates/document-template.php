<?php
function is_var($var)
{
    if (isset($var) && !empty($var))
        return true;
    else
        return false;
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif !important; }
        table.doc_table, table.doc_table th, table.doc_table td {border: 1px solid black; }
        table {border-collapse:collapse}
    </style>
</head>
<body>
<div class="header">
    <p style="text-align: center;">АКТ № <?php if (is_var($doc_num)) echo $doc_num; ?><br>
        <?php if (is_var($is_output) && $is_output): ?>возврата паевого взноса<?php elseif(!$is_output): ?>приема паевого взноса<?php endif;?>
    </p>
    <br>
    <p style="text-align: center">г. Электросталь “_<?php if (is_var($day)) echo $day; ?>_”___<?php if (is_var($month)) echo $month; ?>__ <?php if (is_var($year)) echo $year; ?>_г.
    </p>
    <br>
</div>
<div class="doc_body">
    <p>Совет МПК «СЛАВИЯ» (в дальнейшем Совет) в лице председателя Сергея Андреевича С. и пайщик №<?php if (is_var($client_num)) echo $client_num; ?>_______<?php if (is_var($client_fio)) echo $client_fio; ?>_(в дальнейшем Пайщик), составили
        настоящий акт в том, что Пайщик <?php if (is_var($is_output) && $is_output): ?> получил паевой взнос, а Совет МПК
        «Славия»  передал из Паевого Фонда паевой взнос <?php elseif (!$is_output): ?> внёс паевой взнос, а Совет принял в Паевой Фонд паевой взнос <?php endif; ?>в виде следующего
        имущества:
    </p>
    <table class="doc_table" style="margin-left: auto; margin-right: auto;">
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
                        if ($currency == 'PRIZM')
                            echo 'Учетная Единица PRIZM';
                        elseif ($currency == 'SLAV')
                            echo 'Учетная Единица Slav';
                        elseif ($currency == 'RUB')
                            echo 'Билеты Банка России';
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
    <p style="margin-left: auto; margin-right: auto; width: 50%;">Итого на сумму <?php if (is_var($sum)) echo $sum; ?> руб. </p>
    <br>
    <table class="signatures" style="margin-left: auto; margin-right: auto;">
        <tbody>
        <tr>
            <td><p>Председатель Совета МПК «СЛАВИЯ» _________________<br> Сергей Андреевич С. М.П. <br> 3PAM1XRQG4cpvh15evZenJWvXBAcTcC2jjt</p></td>
            <td style="padding-left: 30px"><p>Пайщик: <br> №<?php if (is_var($client_num)) echo $client_num; ?> <br> <?php if (is_var($currency_address) && $currency == 'PRIZM') echo $currency_address.'<br>'; ?><?php if (is_var($public_key)) echo $public_key; ?> <br>____________________________________________________________________________________________ <br>__________</p></td>
        </tr>
        </tbody></table>

</div>

</body></html>