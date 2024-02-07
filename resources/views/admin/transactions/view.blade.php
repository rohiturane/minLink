<style>
{{ $css }}
</style>
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} -->
    <div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:image {"sizeSlug":"large"} -->
        <figure class="wp-block-image size-large"><img src="{{ $image}}" style="height: 100px;" alt="" /></figure><!-- /wp:image -->
    </div><!-- /wp:column --><!-- wp:column {"width":"66.66%"} -->
    <div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:heading {"textAlign":"center"} -->
        <h2 class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-vivid-red-color">{{ env('APP_NAME') }}</mark></h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">{{ env('ADDRESS') }}</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">{{ env('MOBILE') }}</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">{{ env('EMAIL')}}</mark></p><!-- /wp:paragraph -->
    </div><!-- /wp:column -->
</div><!-- /wp:columns --><!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide" /><!-- /wp:separator --><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
    <div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Invoice No: {{ $transaction->transaction_no }}</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Name: {{ $transaction->user->name }}</mark></p><!-- /wp:paragraph -->
    </div><!-- /wp:column --><!-- wp:column -->
    <div class="wp-block-column"><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Date: {{ date('d-M-Y', strtotime($transaction->created_at))}}</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Email: {{ $transaction->user->email }}</mark></p><!-- /wp:paragraph -->
    </div><!-- /wp:column -->
</div><!-- /wp:columns --><!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide" /><!-- /wp:separator --><!-- wp:table -->
<figure class="wp-block-table">
    <table>
        <tbody>
            <tr>
                <td><strong><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Products</mark></strong></td>
                <td><strong><mark style="background-color:rgba(0, 0, 0, 0); display: block; text-align: right;" class="has-inline-color has-black-color">Subtotal</mark></strong></td>
            </tr>
            <tr>
                <td><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Plan 3003</mark></td>
                <td><mark style="background-color:rgba(0, 0, 0, 0); display: block; text-align: right;" class="has-inline-color has-black-color">&nbsp;{{$transaction->amount}}</mark></td>
            </tr>
        </tbody>
    </table>
</figure><!-- /wp:table --><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} -->
    <div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:paragraph {"align":"right"} -->
        <p class="has-text-align-right"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Sub Total</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"right"} -->
        <p class="has-text-align-right"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Total Tax</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"right"} -->
        <p class="has-text-align-right"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">Total Amount</mark></p><!-- /wp:paragraph -->
    </div><!-- /wp:column --><!-- wp:column {"width":"33.33%"} -->
    <div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:paragraph {"align":"right"} -->
        <p class="has-text-align-right"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">{{ $transaction->amount}}</mark></p><!-- /wp:paragraph --><!-- wp:paragraph {"align":"right"} -->
        <!-- <p class="has-text-align-right"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">{subtax}</mark></p> -->
        <p class="has-text-align-right"><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color">{{$transaction->amount}}</mark></p><!-- /wp:paragraph -->
    </div><!-- /wp:column -->
</div><!-- /wp:columns --><!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide" /><!-- /wp:separator --><!-- wp:paragraph -->
<p><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-black-color"><strong>Amount In Words:</strong> {{ numberToText($transaction->amount)}}</mark></p><!-- /wp:paragraph --><!-- wp:paragraph -->
<div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer --><!-- wp:columns -->
<script>
window.onload = function() { window.print(); }
</script>