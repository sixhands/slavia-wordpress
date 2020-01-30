<div class="col-lg-12 col-md-12"  style="z-index: 4; /*margin-top: 10px;*/">
    <div class="row">
        <div class="coop_maps question-bg col-lg-12">
            <div class="row">
                <div class="col-12">
                    <h1 class="coop_maps-h1 ib">Мои документы</h1>
        <!--            <img src="/wp-content/uploads/2019/12/calendar.png" class="ib" style="float: right; margin-top: 20px;">-->
        <!--            <h1 class="coop_maps-h1 ib" style="float: right; font-size: 16px;">08.11.19</h1>-->
                    <div class="ib" style="float:right; margin-bottom: 10px;">
                        <input class="datepicker" disabled="disabled"/>
                    </div>
                </div>
            </div>

            <div class="row docs">
                <div class="table-title w-100">
                    <div class="row">
                        <div class="col-2 text-center">
                            Дата
                        </div>
                        <div class="col-8 text-left">
                            Наименование документа
                        </div>
                        <div class="col-2 text-center">
                        </div>
                    </div>
                </div>
                <?php if (isset($user_documents) && !empty($user_documents))://echo print_r( $user_documents, true); ?>
                    <?php foreach($user_documents as $key => $document): ?>
                        <div class="table-text w-100">
                            <div class="row">
                                <div class="col-2 text-center"><?php echo $document['date'] ?></div>

                                <div class="col-8 text-left"><?php echo $document['filename'] ?></div>

                                <div class="col-2 text-center">
                                    <a href="<?=$document['url']?>" download>
                                        <img src="/wp-content/uploads/2019/12/don.png">
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

<!--                <div class="table-text w-100">-->
<!--                    <div class="row">-->
<!--                        <div class="col-2 text-center">-->
<!--                            08.11.19-->
<!--                        </div>-->
<!--                        <div class="col-8 text-left">-->
<!--                            Какое-нибудь длинное наименование документа-->
<!--                        </div>-->
<!--                        <div class="col-2 text-center">-->
<!--                            <img src="/wp-content/uploads/2019/12/don.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery('input.datepicker').change(function(){
        let el = jQuery(this);
        let search = {
            type: 'date',
            datatype: 'documents',
            val: el.val()
        };
        let output_el = jQuery('.row.docs');
        search_ajax(el, search, search_callback, output_el);
    });

    function search_callback(response, output_el)
    {
        output_el.children().not('.table-title').remove();
        output_el.append(response);
    }
</script>