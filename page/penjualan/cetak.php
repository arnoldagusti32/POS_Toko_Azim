<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$koneksi = new mysqli("localhost", "root", "", "db_pos");
$kasir = $_GET['kasir'];
$kode_pj = $_GET['kode_pjl'];
?>
<style>
    .noPrint {
        padding: 5px 10px;
        background-color: #483D8B;
        color: white;
    }

    @media print {
        button.noPrint {
            display: none;
        }
    }
</style>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<h4>Struk Pembelanjaan</h4>
<table>
    <tr>
        <td>
            <center>Toko Azam Grosir</center>
        </td>
    </tr>
    <tr>
        <td>
            <center>Jln. Cempaka Raya Blok AA No.3 Bumiasri Kutajaya, Pasar Kemis, Kab Tangerang</center>
        </td>
    </tr>
    <tr>
        <td>
            <hr>
        </td>
    </tr>
</table>

<table>
    <?php
    $sql = $koneksi->query("SELECT * FROM tb_penjualan, tb_pelanggan WHERE tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan AND kode_penjualan='$kode_pj'");
    $tampil = $sql->fetch_assoc();
    ?>

    <tr>
        <td>Kode Penjualan &nbsp;&nbsp;</td>
        <td>: &nbsp;&nbsp;<?php echo $tampil['kode_penjualan']; ?></td>
    </tr>
    <tr>
        <td>Tanggal &nbsp;&nbsp;</td>
        <td>: &nbsp;&nbsp;<?php echo $tampil['tgl_penjualan']; ?></td>
    </tr>
    <tr>
        <td>Pelanggan &nbsp;&nbsp;</td>
        <td>: &nbsp;&nbsp;<?php echo $tampil['nama']; ?></td>
    </tr>
    <tr>
        <td>Kasir &nbsp;&nbsp;</td>
        <td>: &nbsp;&nbsp;<?php echo $kasir; ?></td>
    </tr>
    <td colspan="5">
        <hr>
    </td>

    <?php
    $sql2 = $koneksi->query("SELECT * FROM tb_penjualan, tb_penjualan_detail, tb_barang 
    WHERE tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan 
    AND tb_penjualan.kode_barcode=tb_barang.kode_barcode 
    AND tb_penjualan.kode_penjualan='$kode_pj'");
    while ($tampil2 = $sql2->fetch_assoc()) {
    ?>

        <tr>
            <td><?php echo $tampil2['nama_barang']; ?></td>
            <td><?php echo 'Rp.' . '&nbsp;' . number_format($tampil2['harga_jual']) . ',-' . '&nbsp;' . '&nbsp;' . 'X' . '&nbsp;' . '&nbsp;' . $tampil2['jumlah'] . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;' ?> </td>
            <td><?php echo 'Rp.' . '&nbsp;' . number_format($tampil2['total']) . ',-'; ?></td>
        </tr>

    <?php
        $diskon = $tampil2['diskon'];
        $potongan = $tampil2['potongan'];
        $bayar = $tampil2['bayar'];
        $kembali = $tampil2['kembali'];
        $total_b = $tampil2['total_b'];

        $total_bayar = $total_bayar + $tampil2['total'];
    }
    ?>

    <tr>
        <td colspan="5">
            <hr>
        </td>
    </tr>
    <tr>
        <th colspan="2">Total &nbsp;&nbsp;</th>
        <td> : <?php echo 'Rp.' . '&nbsp;' . number_format($total_bayar) . ',-'; ?></td>
    </tr>
    <tr>
        <th colspan="2">Diskon &nbsp;&nbsp;</th>
        <td> : <?php echo $diskon . ' %'; ?></td>
    </tr>
    <tr>
        <th colspan="2">Potongan Diskon &nbsp;&nbsp;</th>
        <td> : <?php echo 'Rp.' . '&nbsp;' . number_format($potongan) . ',-'; ?></td>
    </tr>
    <tr>
        <th colspan="2">Sub Total &nbsp;&nbsp;</th>
        <td> : <?php echo 'Rp.' . '&nbsp;' . number_format($total_b) . ',-'; ?></td>
    </tr>
    <tr>
        <th colspan="2">Bayar &nbsp;&nbsp;</th>
        <td> : <?php echo 'Rp.' . '&nbsp;' . number_format($bayar) . ',-'; ?></td>
    </tr>
    <tr>
        <th colspan="2">Kembali &nbsp;&nbsp;</th>
        <td> : <?php echo 'Rp.' . '&nbsp;' . number_format($kembali) . ',-'; ?></td>
    </tr>
</table>

<table>
    <tr>
        <td>Barang Yang Sudah Dibeli Tidak Dapat Dikembalikan</td>
    </tr>
    <tr>
        <td>
            <center>
                <button type="button" class="noPrint btn bg-indigo waves-effect" value="Print" onclick="window.print()">
                    <i class="material-icons">print</i>
                    <span>PRINT</span>
                </button>
            </center>
        </td>
    </tr>
</table>