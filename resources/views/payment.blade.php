
<html>
    <head></head>
    <body>
<script>
    var total = Number('{{ $price }}').toFixed(2);
    var headers = new Headers();
headers.append('Accept', 'application/json');
var parameters = new URLSearchParams();
parameters.append('account_number', '1234567890');
parameters.append('avs', '0');
parameters.append('country_code', 'JM');
parameters.append('currency', 'JMD');
parameters.append('data', '{"a":"b"}');
parameters.append('environment', 'sandbox');
parameters.append('fee_structure', 'customer_pay');
parameters.append('method', 'credit_card');
parameters.append('order_id', 'oid_123-aBc');
parameters.append('origin', 'Brandon_Book_Store');
parameters.append('response_url',
'https://jm.wipayfinancial.com/response/');
parameters.append('total', total);
var options = {
method: 'POST',
headers: headers,
body: parameters,
redirect: 'follow'
};
fetch('https://tt.wipayfinancial.com/plugins/payments/request', options)
.then(response => response.text())
.then(result => {
// result in JSON format (header)
result = JSON.parse(result);
// perform redirect
window.location.href = result.url;
})
.catch(error => console.log('error', error));
</script>
    </body>
    </html>
