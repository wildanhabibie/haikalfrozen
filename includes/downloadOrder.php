<?php
//Download Order Page -> jadikan PHP

// includes file
include "./db.php";
include "./functions/functions.php";
include ("../assets/fpdf184/fpdf.php");

// memeriksa halaman order jika ada,kalau tidak ada maka langsung menuju ke homepage
if (!isset($_GET['order_no'])) {
    echo "<script>window.open('./index.php','_self');</script>";
    } else if(isset($_GET['order_no'])){
        // jika tidak ada order akan diarahkan ke homepage
        $check_id = $_GET['order_no'];
        $ip_add = getUserIP();
        $check_order = "SELECT * FROM orders WHERE user_ip='$ip_add' AND invoice_no = '$check_id'";
        $query_order = mysqli_query($conn, $check_order);
        $count = mysqli_num_rows($query_order);
        if($count == 0){
            echo"<script>window.open('./index.php','_self');</script>";
        }
    }

// membuat PDF

// mendapatkan order
if(isset($_GET['order_no'])){

    $order_id = $_GET['order_no'];
    $ip_add = getUserIP();

    $query = "SELECT * FROM orders WHERE user_ip='$ip_add' AND invoice_no = '$order_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    $user_name = $row['user_name'];
    $user_email = $row['user_email'];
    $user_phone = $row['user_phone'];
    $user_address = $row['user_address'];
    $date_order = $row['date'];

}

$pdf = new FPDF();
$pdf->AddPage();

// untuk membuat dimensi di setiap sisi
$pdf->Cell(276, 5);

// Mensetting Font
$pdf->SetFont('Arial', '', 20); //font-size => 20

// untuk logo
$pdf->Cell(10,30,"",0, 1,$pdf->Image('../assets/images/logo/logo.png',8,10,90,15)); //x->10,y->30, 1-> kolom baru

// Mensetting Font
$pdf->SetFont('Arial','',10);

// kolom tentang perusahaan
$pdf->Cell(130 ,5,'Bendungan, Kabupaten Kulon Progo, Daerah Istimewa Yogyakarta, 55651', 0,0);
$pdf->Cell(15 ,5,'Date:',0,0);
$date = (new \DateTime())->format('Y-m-d H:i:s');
$pdf->Cell(34 ,5, $date ,0,1);//akhir dari Line

$pdf->Cell(130 ,5,'Muhammad Wildan Habibie',0,0);

$pdf->Cell(25 ,5,'Order Date:',0,0);
$pdf->Cell(20 ,5,$date_order,0,1);

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

$order_for = iconv('UTF-8', 'windows-1252', 'Pesanan untuk:');
$pdf->Cell(100 ,5,$order_for,0,1);


$pdf->SetFont('Arial', 'B', 10);
//menambah sel dummy di awal line untuk setiap indentation
$pdf->Cell(25, 5, '', 0,0);
$name=iconv('UTF-8', 'windows-1252', $user_name);
$pdf->Cell(90 ,5,$name,0,1);

$pdf->cell(25, 5, '', 0,0);
$address=iconv('UTF-8', 'windows-1252', $user_address);
$pdf->Cell(90 ,5,$address,0,1);

$pdf->Cell(25, 5, '', 0,0);
$pdf->Cell(90 ,5,$user_phone,0,1);

$pdf->Cell(25, 5, '', 0,0);
$email=iconv('UTF-8', 'windows-1252', $user_email);
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
$pdf->Cell(41 ,7,'Size','TB',0);

// mendapatkan produk order
if(isset($_GET['order_no'])){
    $order_id = $_GET['order_no'];
    
    $get_order = "SELECT * FROM orders WHERE user_ip = '$ip_add' AND invoice_no='$order_id'";
    $query = mysqli_query($conn, $get_order);
    $total = 0;
    while($invoice=mysqli_fetch_array($query)){
        $pro_name = $invoice['product_name'];
        $pro_price = $invoice['product_price'];
        $pro_qty = $invoice['product_quantity'];
        $pro_jenis = $invoice['product_jenis'];
        $pro_size = $invoice['product_size'];
        $sub_total = $pro_price * $pro_qty;
        $total += $sub_total;


    //item produk
    $pdf->Cell(25 ,7,$pro_qty, 0, 0);
    $pdf->Cell(41 ,7,number_format((float)$pro_price, 3, '.', ''), 0, 0);
    $product_title = iconv('UTF-8', 'windows-1252', substr($pro_name, 0, 28));
    $pdf->Cell(41 ,7,$product_title,0,0);
    $pdf->Cell(41 ,7,$pro_jenis,0,0);
    $pdf->Cell(41 ,7,$pro_size,0,1);
    $pdf->Cell(189 ,7,"",'B',1);
    }

    $pdf->SetFont('Arial','',10);

    //ringkasan
    $pdf->Cell(120 ,7,'',0,0);
    $pdf->Cell(35 ,7,'Total',0,0);
    $pdf->Cell(9 ,7,'Rp',1,0);
    $pdf->Cell(26 ,7,number_format((float)$total, 3, '.', ''),1,1,'R'); //r->kanan

    $pdf->Cell(120 ,7,'',0,0);
    $pdf->Cell(35 ,7,'ongkir 20%',0,0);
    $pdf->Cell(9 ,7,'Rp',1,0);
    //ongkir 20%
    $reduced_price = (($total / 100)*20);
    $pdf->Cell(26 ,7,number_format((float)$reduced_price, 3, '.', ''),1,1,'R'); //r->kanan

    $pdf->SetFont('Arial','B',8);

    $pdf->Cell(120 ,7,'',0,0);
    $pdf->Cell(35 ,7,'Total dengan Ongkir',0,0);
    $pdf->Cell(9 ,7,'Rp',1,0);
    $totalPrice = (($total / 100)*20) + $total;
    $pdf->Cell(26 ,7,number_format((float)$totalPrice, 3, '.', ''),1,1,'R'); //r->kanan

    
    
    }

    $pdf->Output();
    ?>