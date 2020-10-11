<!DOCTYPE html>

<html>

<head>

    <title>Macrolan Enquiries</title>

</head>

<body>

   

<center>

<h2 style="padding: 23px;background: #0599D7;border-bottom: 6px #F95913 solid;">
@if ($data['type'] == 'admin')
<a href="https://www.macrolankenya.co.ke/enquiry/index "><span style="color: white">View Enquiries</span></a>
@else
<span style="color: white"> Macrolan Kenya</span>
@endif   

</h2>

</center>

  

<p>{{$data['message']}}</p>

  

</body>

</html>