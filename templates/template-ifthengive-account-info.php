<?php
/**
 * IfThenGive My Account Info template.
 *
 * This template can be overriden by copying this file to your-theme/ifthengive/template-ifthengive-account-info.php
 *
 * @author 	Angell EYE <andrew@angelleye.com>
 * @package 	IfThenGive
 * @version     0.1.0
 */

if (!defined('ABSPATH'))
    exit; // Don't allow direct access

if (!is_admin()) {
    $userID = get_current_user_id();
    if(is_int($userID) && $userID > 0){
        $BAID = get_user_meta($userID,'itg_gec_billing_agreement_id',true);
        $paypal_email = get_user_meta($userID,'itg_gec_email',true);
        $paypal_payer_id = get_user_meta($userID,'itg_gec_payer_id',true);  
        do_action('before_ifthengive_account_info', $userID);
?>
<div class="itg_hr-title itg_hr-long itg_center" style="margin: 10px auto 25px;"><abbr><?php esc_html_e('Account Info', 'ifthengive') ?></abbr></div>
<div class="itgcontainer">
    <div id="canceel_baid_overlay" style=" background: #d9d9da;opacity: 0.9;width: 100%;float: left;height: 100%;position: fixed;top: 0;left:0;right:0;z-index: 1031;text-align: center; display: none;">
        <div class="itg_loader"></div>
        <h1 style="font-weight: 600;"><?php esc_html_e('Processing','ifthengive'); ?>...</h1>
    </div>
    <ul class="itg-list-group">
        <li class="itg-list-group-item">
            <span class="itg_span itg_span_1"><?php esc_html_e('Billing Agreement ID : ','ifthengive');?></span>
            <span class="itg_span itg_span_2"><?php echo ($BAID!=='') ? $BAID : '-';?></span>
        </li>
        <li class="itg-list-group-item">
            <span class="itg_span itg_span_1"><?php esc_html_e('PayPal Email ID : ','ifthengive');?></span>
            <span class="itg_span itg_span_2"><?php echo ($paypal_email !== '') ? $paypal_email : '-'; ?></span>
        </li>        
        <li class="itg-list-group-item">
            <span class="itg_span itg_span_1"><?php esc_html_e('PayPal Payer ID : ','ifthengive');?></span>
            <span class="itg_span itg_span_2"><?php echo ($paypal_payer_id !=='') ? $paypal_payer_id : '-'; ?></span>
        </li>
        <?php
        if($BAID!=='') {
        ?>
        <li class="itg-list-group-item">
            <button type="button" class="itg_btn itg_btn-primary" id="itg_account_cancel_baid" data-baid="<?php echo $BAID; ?>" data-userid="<?php echo $userID; ?>"><?php esc_html_e('Cancel Billing Agreement','ifthengive'); ?></button>
        </li>
        <?php } ?>
    </ul>
    <div class="itg_alert itg_alert-warning" id="cancel_ba_error_public" style="display: none;text-align: left;">
        <div id="itg_cancel_ba_msg"></div>
    </div>         
</div>
<?php 
    do_action('after_ifthengive_account_info', $userID);
    }
    else{
        esc_html_e("Please login to site.",'ifthengive');
    }
}