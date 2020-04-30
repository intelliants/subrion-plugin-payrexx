<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="https://media.payrexx.com/modal/v1/modal.min.js"></script>

<a class="payrexx-modal-window" href="#"  data-href="https://{$core.config.payrexx_username}.payrexx.com/pay?tid={$core.config.payrexx_template_id}&invoice_number={$transaction.sec_key}&invoice_amount={$transaction.amount}&invoice_currency=1">
    Open modal window
</a>
<script type="text/javascript">
jQuery(".payrexx-modal-window").payrexxModal({
    // hideObjects: ['.product-section']
});
</script>
