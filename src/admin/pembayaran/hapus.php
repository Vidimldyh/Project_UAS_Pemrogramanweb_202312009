<?php
session_start();
include '../../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM pembayaran WHERE id_pembayaran = '$id'");
header("Location: index.php");
exit;
