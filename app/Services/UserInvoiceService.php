<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Invoice;
use App\Models\UserInvoice;
use Illuminate\Support\Str;


class UserInvoiceService
{
    public function index()
    {
        $userinvoices = UserInvoice::orderBy('id','desc')->get();
        return $userinvoices;
    }

    public function store($params)
    {
        $invoice = Invoice::where('uuid', $params['invoice_id'])->first();
        $business = Business::where('user_id', auth()->user()->id)->first();
        $invoice_replace = [
            '{logo}' => asset($business->logo),
            '{business_name}' => $business->name,
            '{address}' => empty($business->address) ? '' : $business->address,
            '{mobile}' => empty($business->mobile) ? '' : $business->mobile,
            '{email}' => empty($business->email) ? '' : $business->email,
            '{note}' => empty($params['note']) ? '': $params['note'],
            '{date}' => $params['date'],
            '{total_in_words}' => $this->num_to_text($params['final_total']),
            '{customer_name}' => $params['customer_name'],
            '{customer_mobile}' => $params['customer_mobile'],
            '{customer_taxid}' => empty($params['customer_taxid'])? '' : $params['customer_taxid'],
            '{customer_email}' => empty($params['customer_email'])? '' : $params['customer_email'],
            '{taxid}' => empty($business->taxid) ? '' : $business->taxid,
            '{invoice_id}' => $params['invoice_no'],
            '{subtotal}'=> $params['subtotal'],
            '{subtax}' => $params['subtax'],
            '{final_total}' => $params['final_total'],
        ];
        $products = $quantity = $price = $total = '';
        foreach($params['particular'] as $key => $product)
        {
            $products.= '<p>'.$product.'</p>';
            $quantity.= '<p>'.$params['qty'][$key].'</p>';
            $price.= '<p>'.$params['rate'][$key].'</p>';
            $total.= '<p>'.$params['total'][$key].'</p>';
        }

        $invoice_replace['{products}'] = $products;
        $invoice_replace['{rates}'] = $price;
        $invoice_replace['{qtys}'] = $quantity;
        $invoice_replace['{product_totals}'] = $total;

        $html_content = str_replace(array_keys($invoice_replace), array_values($invoice_replace), $invoice->html_content);
        $insertData = [
            'uuid' => Str::orderedUuid(),
            'date' => date('Y-m-d', strtotime($params['date'])),
            'user_id' => auth()->user()->id,
            'invoice_id' => $params['invoice_id'],
            'invoice_no' => $params['invoice_no'],
            'customer_name' => $params['customer_name'],
            'customer_mobile' => $params['customer_mobile'],
            'customer_taxid'  => empty($params['customer_taxid']) ? '': $params['customer_taxid'],
            'html_content' => $html_content,
            'status' => $params['status'],
            'total_amount' => $params['final_total'],
            'payload' => json_encode($params),
        ];

        $userInvoice = UserInvoice::create($insertData);
        return $userInvoice;
    }

    function num_to_text($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees Only' : '') . $paise;
    }

    public function get($uuid)
    {
        $invoice = UserInvoice::where('uuid', $uuid)->first();

        return $invoice;
    }

    public function update($uuid, $params)
    {
        $invoice = Invoice::where('uuid', $params['invoice_id'])->first();
        $business = Business::where('user_id', auth()->user()->id)->first();
        $invoice_replace = [
            '{logo}' => asset($business->logo),
            '{business_name}' => $business->name,
            '{address}' => empty($business->address) ? '' : $business->address,
            '{mobile}' => empty($business->mobile) ? '' : $business->mobile,
            '{email}' => empty($business->email) ? '' : $business->email,
            '{note}' => empty($params['note']) ? '': $params['note'],
            '{date}' => $params['date'],
            '{total_in_words}' => $this->num_to_text($params['final_total']),
            '{customer_name}' => $params['customer_name'],
            '{customer_mobile}' => $params['customer_mobile'],
            '{customer_taxid}' => empty($params['customer_taxid'])? '' : $params['customer_taxid'],
            '{customer_email}' => empty($params['customer_email'])? '' : $params['customer_email'],
            '{taxid}' => empty($business->taxid) ? '' : $business->taxid,
            '{invoice_id}' => $params['invoice_no'],
            '{subtotal}'=> $params['subtotal'],
            '{subtax}' => $params['subtax'],
            '{final_total}' => $params['final_total'],
        ];
        $products = $quantity = $price = $total = '';
        foreach($params['particular'] as $key => $product)
        {
            $products.= '<p>'.$product.'</p>';
            $quantity.= '<p>'.$params['qty'][$key].'</p>';
            $price.= '<p>'.$params['rate'][$key].'</p>';
            $total.= '<p>'.$params['total'][$key].'</p>';
        }

        $invoice_replace['{products}'] = $products;
        $invoice_replace['{rates}'] = $price;
        $invoice_replace['{qtys}'] = $quantity;
        $invoice_replace['{product_totals}'] = $total;

        $html_content = str_replace(array_keys($invoice_replace), array_values($invoice_replace), $invoice->html_content);

        $insertData = [
            'date' => date('Y-m-d', strtotime($params['date'])),
            'invoice_id' => $params['invoice_id'],
            'invoice_no' => $params['invoice_no'],
            'customer_name' => $params['customer_name'],
            'customer_mobile' => $params['customer_mobile'],
            'customer_taxid'  => empty($params['customer_taxid']) ? '': $params['customer_taxid'],
            'html_content' => $html_content,
            'status' => $params['status'],
            'total_amount' => $params['final_total'],
            'payload' => json_encode($params),
        ];

        $invoice = UserInvoice::where('uuid', $uuid)->update($insertData);

        return $invoice;
    }

    public function destory($uuid)
    {
        $userInvoice = UserInvoice::where('uuid', $uuid)->first();

        if(!$userInvoice) 
        {
            return false;
        }
        $userInvoice->delete();
        return true;
    }
}