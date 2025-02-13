<?php
/**
 * IfThenGive Transaction template.
 *
 * This template can be overriden by copying this file to your-theme/ifthengive/template-ifthengive-my-transactions.php
 *
 * @author 	Angell EYE <andrew@angelleye.com>
 * @package 	IfThenGive
 * @version     0.1.0
 */
if (!defined('ABSPATH'))
    exit; // Don't allow direct access
?>

<?php
if(! is_admin()){
    $userID = get_current_user_id();
    if(is_int($userID) && $userID > 0){
    do_action('before_ifthengive_my_transactions', $userID);
?>
<div class="itg_hr-title itg_hr-long itg_center" style="margin: 10px auto 25px;"><abbr><?php esc_html_e('Transactions', 'ifthengive') ?></abbr></div>
<div class="itg_center_container">   
    <div class="itgcontainer">
        <div class="itg_table-responsive">
            <table class="itg_table" id="IfThenGive_Transaction_Table" width="100%">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Transaction ID', 'ifthengive'); ?></th>                        
                        <th><?php esc_html_e('Amount', 'ifthengive'); ?></th>
                        <th><?php esc_html_e('Goal Name', 'ifthengive'); ?></th>                                                
                        <th><?php esc_html_e('Payment Status', 'ifthengive'); ?></th>
                        <th><?php esc_html_e('Payment Date', 'ifthengive'); ?></th>
                    </tr>
                </thead>
            </table>            
        </div>            
    </div>
</div>
<?php
do_action('after_ifthengive_my_transactions', $userID);
$ccode = get_option('itg_currency_code');
$paypal = new AngellEYE_IfThenGive_PayPal_Helper();
$symbol = $paypal->get_currency_symbol($ccode);
?>
<script>
    jQuery(document).ready(function ($) {
        $('#IfThenGive_Transaction_Table').dataTable({
            "order": [[ 4, "desc" ]],
            "serverSide": true,
            "responsive": true,
            "colReorder": true,
            "bRetrieve": true,
            "processing": true,
            "oLanguage": {"sEmptyTable": 'No Transactions Found', "sZeroRecords": 'No records Found'},
            "ajax": {
                url: "<?php echo admin_url('admin-ajax.php'); ?>?action=ifthengive_my_transactions",
                type: "POST"
            },
            "columnDefs": [
                {
                    "targets": [0], 'searchable': false,
                    "render": function (data, type, row) {
                        return row.transactionId;
                    }
                },                
                {
                    "targets": [1],
                    "render": function (data, type, row) {
                        var str = '<?php echo $symbol; ?>';
                        var amount = parseFloat(row.amount).toFixed(2);
                        return str + amount;
                    }
                },                    
                {
                    "targets": [2],
                    "render": function (data, type, row) {
                        return row.goal_name;
                    }
                },
                {
                    "targets": [3],
                    "render": function (data, type, row) {
                        return row.ppack;
                    }
                },
                {
                    "targets": [4],
                    "render": function (data, type, row) {
                        return row.Txn_date;
                    }
                }
            ]
        });
    });
</script>
<?php }
    else{
        esc_html_e("Please login to site.",'ifthengive');
    }
}