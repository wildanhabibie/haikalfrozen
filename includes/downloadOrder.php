<?php
// Download pesanan sebagai PDF (pelanggan)
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/../assets/fpdf184/fpdf.php';

$order_id = isset($_GET['order_no']) ? db_esc($_GET['order_no']) : '';
$ip_add = db_esc(getUserIP());
$order_filter = "user_ip = '$ip_add' AND invoice_no = '$order_id'";
$back_url = '../index.php';

// jika pesanan tidak ada, kembali
$result = q("SELECT * FROM orders WHERE $order_filter ORDER BY id");
if ($order_id === '' || q_count($result) == 0) {
    redirect($back_url);
}
$row = mysqli_fetch_assoc($result);
mysqli_data_seek($result, 0);

$user_name = $row['user_name'];
$user_email = $row['user_email'];
$user_phone = $row['user_phone'];
$user_address = $row['user_address'];
$date_order = $row['date'];

// FPDF memakai encoding windows-1252
function pdf_text($text)
{
    $converted = @iconv('UTF-8', 'windows-1252//TRANSLIT', (string) $text);
    return $converted === false ? (string) $text : $converted;
}

// format angka: 25 -> 25.000 (harga disimpan dalam ribuan)
function pdf_money($value)
{
    return number_format((float) $value * 1000, 0, ',', '.');
}

$pdf = new FPDF();
$pdf->AddPage();

// untuk membuat dimensi di setiap sisi
$pdf->Cell(276, 5);

// Mensetting Font
$pdf->SetFont('Arial', '', 20); //font-size => 20

// untuk logo
$pdf->Cell(10,30,"",0, 1,$pdf->Image(__DIR__ . '/../assets/images/logo/logo.png',8,10,90,15)); //x->10,y->30, 1-> kolom baru

// Mensetting Font
$pdf->SetFont('Arial','',10);

// kolom tentang perusahaan
$pdf->Cell(130 ,5,'Bendungan, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta, 55651', 0,0);
$pdf->Cell(15 ,5,'Date:',0,0);
$date = (new \DateTime())->format('Y-m-d H:i:s');
$pdf->Cell(34 ,5, $date ,0,1);//akhir dari Line

$pdf->Cell(130 ,5,'Muhammad Wildan Habibie',0,0);

$pdf->Cell(25 ,5,'Order Date:',0,0);
$pdf->Cell(20 ,5,pdf_text($date_order),0,1);

$pdf->Cell(130 ,5,'Phone : +081236007473', 0, 0);

$pdf->Cell(28 ,5,'Invoice Number:',0,0);
$pdf->Cell(34 ,5,$order_id,0,1);

//Set kolom yang kosong
$pdf->Cell(189 ,30,'',0,1);

//Set Font
$pdf->SetFont('Arial','B', 20); // b->bold

//Title
$pdf->Cell(190 ,20,'PESANAN Anda',0,1, 'C'); //c->center

// Set Font
$pdf->SetFont('Arial', '', 10);

//membuat sel dummy kosong sebagai vertical spacer
$pdf->Cell(189 ,10,'',0,1);

//Alamat Billing

$order_for = pdf_text('Pesanan untuk:');
$pdf->Cell(100 ,5,$order_for,0,1);


$pdf->SetFont('Arial', 'B', 10);
//menambah sel dummy di awal line untuk setiap indentation
$pdf->Cell(25, 5, '', 0,0);
$name=pdf_text($user_name);
$pdf->Cell(90 ,5,$name,0,1);

$pdf->Cell(25, 5, '', 0,0);
$address=pdf_text($user_address);
$pdf->Cell(90 ,5,$address,0,1);

$pdf->Cell(25, 5, '', 0,0);
$pdf->Cell(90 ,5,pdf_text($user_phone),0,1);

$pdf->Cell(25, 5, '', 0,0);
$email=pdf_text($user_email);
$pdf->Cell(90 ,5,$email,0,1);

// Set Font
$pdf->SetFont('Arial','B', 9);

// membuat sel dummy kosong sebagai vertical spacer
$pdf->Cell(189 ,10,'', 0,1);
$pdf->Cell(189 ,10,'', 0,1);

// invoice contents
$pdf->SetFont('Arial','',9);
$pdf->SetDrawColor(139,198,63);
$pdf->Cell(25 ,7,'Quantity','TB',0);//->top bottom
$pdf->Cell(41 ,7,'Total','TB',0);
$pdf->Cell(41 ,7,'Product','TB',0);
$pdf->Cell(41 ,7,'Jenis','TB',0);
$pdf->Cell(41 ,7,'Size','TB',1);

// mendapatkan produk order
$total = 0;
while ($invoice = mysqli_fetch_assoc($result)) {
    $pro_name = $invoice['product_name'];
    $pro_price = $invoice['product_price'];
    $pro_qty = $invoice['product_quantity'];
    $sub_total = $pro_price * $pro_qty;
    $total += $sub_total;

    //item produk
    $pdf->Cell(25, 7, $pro_qty, 0, 0);
    $pdf->Cell(41, 7, pdf_money($sub_total), 0, 0);
    $pdf->Cell(41, 7, pdf_text(substr($pro_name, 0, 28)), 0, 0);
    $pdf->Cell(41, 7, pdf_text($invoice['product_jenis']), 0, 0);
    $pdf->Cell(41, 7, pdf_text($invoice['product_size']), 0, 1);
    $pdf->Cell(189, 7, "", 'B', 1);
}

    $pdf->SetFont('Arial','',10);

    //ringkasan
    $pdf->Cell(120 ,7,'',0,0);
    $pdf->Cell(35 ,7,'Total',0,0);
    $pdf->Cell(9 ,7,'Rp',1,0);
    $pdf->Cell(26 ,7,pdf_money($total),1,1,'R'); //r->kanan

    $pdf->Cell(120 ,7,'',0,0);
    $pdf->Cell(35 ,7,'ongkir 20%',0,0);
    $pdf->Cell(9 ,7,'Rp',1,0);
    //ongkir 20%
    $reduced_price = (($total / 100)*20);
    $pdf->Cell(26 ,7,pdf_money($reduced_price),1,1,'R'); //r->kanan

    $pdf->SetFont('Arial','B',8);

    $pdf->Cell(120 ,7,'',0,0);
    $pdf->Cell(35 ,7,'Total dengan Ongkir',0,0);
    $pdf->Cell(9 ,7,'Rp',1,0);
    $totalPrice = (($total / 100)*20) + $total;
    $pdf->Cell(26 ,7,pdf_money($totalPrice),1,1,'R'); //r->kanan

    
    
    

    $pdf->Output();
    ?>