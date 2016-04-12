<?php
$f_id = array('id' => 'f_id', 'style' => 'display:none;', 'name' => 'id', 'value' => set_value('id', $id));
$f_company = array('id' => 'f_company', 'class' => 'span12 required', 'name' => 'company', 'value' => set_value('company', $company));
$f_first = array('id' => 'f_firstname', 'class' => 'span12 required', 'name' => 'firstname', 'value' => set_value('firstname', $firstname));
$f_last = array('id' => 'f_lastname', 'class' => 'span12 required', 'name' => 'lastname', 'value' => set_value('lastname', $lastname));
$f_email = array('id' => 'f_email', 'class' => 'span12', 'name' => 'email', 'value' => set_value('email', $email));
$f_phone = array('id' => 'f_phone', 'class' => 'span12 required', 'name' => 'phone', 'value' => set_value('phone', $phone));

$f_line1 = array('id' => 'f_line1', 'class' => 'span12', 'name' => 'address_l1', 'value' => set_value('address_l1', $address_l1));
$f_line2 = array('id' => 'f_line2', 'class' => 'span12', 'name' => 'address_l2', 'value' => set_value('address_l2', $address_l2));
$f_city = array('id' => 'f_city', 'class' => 'span12', 'name' => 'city', 'value' => set_value('city', $city));
$f_state = array('id' => 'f_state', 'class' => 'span12', 'name' => 'state', 'value' => set_value('state', $state));
//$f_country = array('id' => 'f_country', 'class' => 'span12', 'name' => 'country', 'value' => set_value('country', $country));
$f_zipcode = array('id' => 'f_zipcode', 'class' => 'span12', 'name' => 'zipcode', 'value' => set_value('zipcode', $zipcode));
$f_license = array('id' => 'f_license', 'class' => 'span12', 'name' => 'license_no', 'value' => set_value('license_no', $license_no));
//echo form_input($f_line2);
echo form_input($f_id);
?>
<div id="my-modal" style="width: 50%; margin: 0 auto;">
    <div class="modal-body">
        <form id="frmEditVen">
            <div class="alert alert-danger hide" id="form-error">
                <a class="close" data-dismiss="alert">×</a>
            </div>

            <div class="alert alert-success">
                <div class="row-fluid">
                    <div class="span12">
                        <h4>Manager details</h4>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('address_firstname'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_first); ?>
                    </div>
                    <div class="span6">
                        <label><?php echo lang('address_lastname'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_last); ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('address_email'); ?><span class="error">*</span></label>
                        <div class="form-control-static">
                            <?php echo $email; ?>
                        </div>
                    </div>
                    <div class="span6">
                        <label><?php echo lang('address_phone'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_phone); ?>
                    </div>
                </div>        
                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('address_line1'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_line1); ?>
                    </div>
                    <div class="span6">
                        <label><?php echo lang('address_line2'); ?></label>
                        <?php echo form_input($f_line2); ?>
                    </div>
                </div>       
                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('city'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_city); ?>
                    </div>
                    <div class="span6">
                        <label><?php echo lang('state'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_state); ?>
                    </div>
                </div>    
                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('country'); ?><span class="error">*</span></label>
                        <select class="span12 required" id="f_country" name="country">
                            <option value="">- Select Country -</option>
                            <?php if ($countries) { ?>
                                <?php foreach ($countries as $country_each) { ?>
                                    <option value="<?php echo $country_each->id; ?>" <?php
                                    if ($country_each->id == set_value('country', $country)) {
                                        echo "selected=selected";
                                    }
                                    ?>><?php echo $country_each->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="span6">
                        <label><?php echo lang('zipcode'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_zipcode); ?>
                    </div>
                </div>       
                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('address_company'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_company); ?>
                    </div>
                    <div class="span6">
                        <label><?php echo lang('license_no'); ?><span class="error">*</span></label>
                        <?php echo form_input($f_license); ?>
                    </div>        
                </div>    
                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('minimum_delivery_amount'); ?><span class="error">*</span></label>
                        <input type="text" value="<?php echo set_value('min_delivery_amount', $min_delivery_amount); ?>" id="f_min_delivery_amount" class="span12 " name="min_delivery_amount">
                    </div>
                    <div class="span6">
                        <label><?php echo lang('delivery_fee'); ?></label>
                        <input type="text" value="<?php echo set_value('delivery_fee', $delivery_fee); ?>" id="f_delivery_fee" class="span12" name="delivery_fee">
                    </div>
                </div>    

                <div class="row-fluid">
                    <div class="span6">
                        <label><?php echo lang('avg_delivery_time'); ?><span class="error">*</span></label>
                        <input type="text" value="<?php echo set_value('avg_delivery_time', $avg_delivery_time); ?>" id="f_avg_delivery_time" class="span12 " name="avg_delivery_time">
                    </div>
                    <div class="span6">
                        <label><?php echo lang('payment_method'); ?><span class="error">*</span></label>
                        <select class="span12 " id="f_payment_type" name="payment_type">
                            <option value="">-Select Method-</option>
                            <option <?php
                            if (set_value('payment_type', $payment_type) == 'card') {
                                echo "selected=selected";
                            }
                            ?> value="card">Card</option>
                            <option <?php
                            if (set_value('payment_type', $payment_type) == 'paypal') {
                                echo "selected=selected";
                            }
                            ?> value="paypal">Paypal</option>
                            <option <?php
                            if (set_value('payment_type', $payment_type) == 'delivery') {
                                echo "selected=selected";
                            }
                            ?> value="delivery">Delivery</option>
                        </select>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span12 pad-bottom">
                        <label><?php echo lang('cuisine'); ?><span class="error">*</span></label>                            
                        <?php
                        if ($cuisines) {
                            $i = 0;
                            $div = array();
                            foreach ($cuisines as $cuisine) {
                                $div[$i % 3] .= '<label class="checkbox clearfix"><input';
                                if (in_array($cuisine->cuisine_id, $venturecuisines)) {
                                    $div[$i % 3] .= " checked=checked ";
                                }
                                $div[$i % 3] .= ' id="f_cuisine_id" name="cuisin_id[]" type="checkbox" value="' . $cuisine->cuisine_id . '" class="check">' . $cuisine->cuisine_name . '</label>';
                                $i++;
                            }
                            ?>
                        <?php } ?>
                        <div class="row-fluid">
                            <div class="span4">
                                <?php echo $div[0]; ?>
                            </div>
                            <div class="span4">
                                <?php echo $div[1]; ?>
                            </div>
                            <div class="span4">
                                <?php echo $div[2]; ?>
                            </div>
                        </div>
                    </div>
                </div>    

                <?php if ($venturetiming) { ?>
                    <div id="addmoreafteredit">
                        <?php foreach ($venturetiming as $venturetime) { ?>
                            <div class="row-fluid">
                                <div class="span6">
                                    <label>Working Days</label>
                                    <select class="span12 days" id="example-getting-started" name="days[]" multiple>
                                        <option value="0">Sunday</option>
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                        <option value="6">Saturday</option>
                                    </select>
                                </div>
                                <div class="span3">
                                    <label>Start Time</label>
                                    <input type="text" id="f_starttime" value="<?php echo date('h:i a', strtotime($venturetime->OpenTime)); ?>" class="span12 required f_starttime" name="start_time[]">
                                </div>
                                <div class="span3">
                                    <label>End Time</label>
                                    <input type="text" id="f_endtime" value="<?php echo date('h:i a', strtotime($venturetime->CloseTime)); ?>" class="span12 required f_endtime" name="end_time[]">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div id="addmoreafteredit" class="row-fluid">
                        <div class="span6">
                            <label>Working Days</label>
                            <select class="span12 example days" id="example-getting-started" name="days[]" multiple>
                                <option value="0">Sunday</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                            </select>
                        </div>
                        <div class="span3">
                            <label>Start Time</label>
                            <input type="text" id="f_starttime" class="span12 " name="start_time[]">
                        </div>
                        <div class="span3">
                            <label>End Time</label>
                            <input type="text" id="f_endtime" class="span12 " name="end_time[]">
                        </div>    
                    </div>

                <?php }
                ?>

                <div class="row-fluid">
                    <div class="span12">
                        <a id="addMoreedit" href="#">Add More</a>&nbsp;&nbsp;
                        <a id="removeMoreedit" href="#">Remove</a>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span12">
                        <label><?php echo lang('license_details'); ?><span class="error">*</span></label>
                        <input type="file" name="licensedoc" size="20" />
                    </div>
                </div>        
                <div class="row-fluid">
                    <div class="span12 clsMarCen">
                        <a href="javascript:void(0)" id="backStep2" class="btn btn-info" type="button">back</a>
                        <a href="javascript:void(0)" id="btnStep3" class="btn btn-primary" type="button">save</a>
                    </div>
                </div>  
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">

<?php
if ($venturetiming) {
    $selectedd = '';
    ?>
    <?php foreach ($venturetiming as $venturetime) { ?>
        <?php
        $selecteddy .= '[' . $venturetime->WeekDay . '],';
        $selectedd = rtrim($selecteddy, ',');
        ?>
    <?php } ?>
<?php } ?>
<?php //print_r($selectedd);          ?>
    var selected = [<?php echo $selectedd; ?>];
    //var selected = '';    

    $(function () {
        var extDiv = $('#addmoreafteredit');
        var i = $('#removemoreafteredit').size() + 1;
        $('#removeMoreedit').hide();

        $('#addMoreedit').on('click', function () {
            $('#removeMoreedit').show();
            $('<div id="removemoreafteredit" class="row-fluid"><div class="span6"><label>Additional Working Day</label><select class="span12 days" style="width:100%;" id=example-getting-started' + i + ' name="days[]" multiple><option value="0">Sunday</option><option value="1">Monday</option><option value="2">Tuesday</option><option value="3">Wednesday</option><option value="4">Thursday</option><option value="5">Friday</option><option value="6">Saturday</option></select></div><div class="span3"><label>Start Time</label><input type="text" id=f_starttime' + i + ' class="span12 required" name="start_time[]"></div><div class="span3"><label>End Time</label><input type="text" id=f_endtime' + i + ' class="span12 required" name="end_time[]"></div></div>').appendTo(extDiv);
            $('.days').multiselect();
            $('#f_starttime' + i).timepicker({'scrollDefault': '9:30am'});
            $('#f_endtime' + i).timepicker({'scrollDefault': '5:30pm'});
            i++;
            return false;
        });

        $('#removeMoreedit').on('click', function () {
            if (i < 2) {
                $('#addMoreedit').show();
                $('#removeMoreedit').hide();
                return false;
            } else {
                $('#addMoreedit,#removeMoreedit').show();
                $("#removemoreafteredit").remove();
            }
            i--;
            if (i < 2) {
                $('#removeMoreedit').hide();
            }
        });
        var j = 0;
        $("select.days").each(function () {
            $(this).multiselect('select', selected[j]);
            j++;
        });
    });

    //'select', ['1', '2', '4']
    //$('.days').multiselect('select', selected);


    $('#f_starttime').timepicker({'scrollDefault': '9:30am'});
    $('#f_endtime').timepicker({'scrollDefault': '5:30pm'});
</script>