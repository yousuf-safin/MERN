<?php
require_once('auth.php');
require_once('db_connect.php');
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE user_id='$user_id'";
$result = $conn->query($sql);

$pdf = new TCPDF();

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 12);

$html = '<h1>Product List</h1>
<table border="1" cellpadding="5">
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Date</th>
    <th>Quantity</th>
    <th>Sold By</th>
    <th>Location</th>
    <th>Image</th>
</tr>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['name'] . '</td>
        <td>' . $row['price'] . '</td>
        <td>' . $row['date'] . '</td>
        <td>' . $row['quantity'] . '</td>
        <td>' . $row['sold_by'] . '</td>
        <td>' . $row['location'] . '</td>
        <td><img src="../' . $row['img_path'] . '" width="50"></td>
    </tr>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('product_list.pdf', 'I');
?>
